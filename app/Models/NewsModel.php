<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'category', 'pubDate', 'image', 'created_at', 'updated_at'];
    protected $returnType = 'array'; // 배열 형태로 데이터 반환

    // 단일 뉴스 항목 가져오기
    public function getNews($id = null)
    {
        if ($id === null) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->where('id', $id)->first();
    }

    // 고유한 카테고리 목록 가져오기
    public function getDistinctCategories()
    {
        return $this->select('category')
                    ->distinct()
                    ->findAll();
    }

    // 관련 뉴스 가져오기
    public function getRelatedNews($category, $currentId, $limit = 5)
    {
        return $this->where('category', $category)
                    ->where('id !=', $currentId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }
}
