<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0">
<channel>
    <title><?= esc($channel['title']) ?></title>
    <link><?= esc($channel['link']) ?></link>
    <description><?= esc($channel['description']) ?></description>
    <language><?= esc($channel['language']) ?></language>
    <pubDate><?= esc($channel['pubDate']) ?></pubDate>

    <?php foreach ($items as $item): ?>
    <item>
        <title><?= esc($item['title']) ?></title>
        <link><?= esc($item['link']) ?></link>
        <description><?= $item['description'] ?></description>
        <pubDate><?= esc($item['pubDate']) ?></pubDate>
        <category><?= esc($item['category']) ?></category>
        <guid><?= esc($item['guid']) ?></guid>
    </item>
    <?php endforeach; ?>
</channel>
</rss>
