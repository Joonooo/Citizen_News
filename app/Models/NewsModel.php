<?php
namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'link', 'category', 'description', 'pubDate'];

    /**
     * 특정 뉴스 또는 모든 뉴스를 가져옵니다.
     *
     * @param int|null $id 뉴스 ID
     * @return array 뉴스 데이터
     */
    public function getNews($id = null)
    {
        if ($id === null) {
            return $this->orderBy('pubDate', 'DESC')->findAll();
        }

        return $this->where('id', $id)->first();
    }

    /**
     * 중복되지 않는 카테고리 목록을 가져옵니다.
     *
     * @return array 카테고리 목록
     */
    public function getDistinctCategories()
    {
        return $this->select('category')->distinct()->findAll();
    }

    /**
     * 카테고리에 따라 뉴스를 가져옵니다.
     *
     * @param string|null $category 카테고리 이름
     * @param int|null $limit 가져올 뉴스 수
     * @param int|null $offset 시작 위치
     * @return array 뉴스 데이터
     */
    public function getNewsByCategory($category = null, $limit = null, $offset = null)
    {
        $builder = $this->orderBy('pubDate', 'DESC');

        if ($category) {
            $builder->where('category', $category);
        }

        return $builder->findAll($limit, $offset);
    }

    /**
     * 조건에 맞는 뉴스의 총 개수를 반환합니다.
     *
     * @param string|null $category 카테고리 이름
     * @return int 뉴스 개수
     */
    public function getTotalNewsCount($category = null)
    {
        if ($category) {
            return $this->where('category', $category)->countAllResults();
        }

        return $this->countAllResults();
    }
}
