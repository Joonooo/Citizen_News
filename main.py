import requests
import xml.etree.ElementTree as ET
import csv
import pymysql
from dotenv import load_dotenv
import os


def append_to_file(file_path, text):
    with open(file_path, "a", encoding="utf-8") as file:
        file.write(text + "\n")


output_file_path = "news.tsv"
open(output_file_path, 'w').close()
response = requests.get("http://api.newswire.co.kr/rss/all")
response.encoding = 'utf-8'
xml_data = response.text
root = ET.fromstring(xml_data)
append_to_file(output_file_path, "title\tlink\tcategory\tdescription\tpubDate")

for item in root.findall("./channel/item"):
    title = item.find("title").text.replace("\n", "|||")
    link = item.find("link").text.replace("\n", "|||")
    category = item.find("category").text.replace("\n", "|||")
    description = item.find("description").text.replace("\n", "|||")
    pubDate = item.find("pubDate").text.replace("\n", "|||")
    append_to_file(output_file_path, f"{title}\t{link}\t{category}\t{description}\t{pubDate}")


data = []
with open(output_file_path, newline='', encoding='utf-8') as file:
    reader = csv.reader(file, delimiter='\t')
    headers = next(reader)
    for row in reader:
        data.append(row)
        

sql_filename = 'upsert_commands.sql'
with open(sql_filename, 'w', encoding='utf-8') as sql_file:
    for row in data:
        values = ', '.join([f"'{val}'" for val in row])  # 각 값을 적절히 escape하고 쿼리에 맞게 포맷합니다.
        command = f"INSERT INTO news (title, link, category, description, pubDate) VALUES ({values}) ON DUPLICATE KEY UPDATE title=VALUES(title), link=VALUES(link), category=VALUES(category), description=VALUES(description), pubDate=VALUES(pubDate);\n"
        sql_file.write(command)
        

load_dotenv()
db_password = os.getenv('DB_PASSWORD')
connection = pymysql.connect(host='localhost',
                             user='root',
                             password=db_password,
                             database='citizen_news',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

try:
    with connection:
        with connection.cursor() as cursor:
            with open(sql_filename, 'r', encoding='utf-8') as sql_file:
                sql_commands = sql_file.read()
                cursor.execute(sql_commands)
        connection.commit()
finally:
    connection.close()

        
print("Done.")