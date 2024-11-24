<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'category', 'pubDate', 'created_at', 'updated_at'];
    protected $returnType = 'array'; // 배열 형태로 데이터 반환

    public function getNews($id = null)
    {
        if ($id === null) {
            return $this->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->where('id', $id)->first();
    }

    public function getDistinctCategories()
    {
        return $this->select('category')
            ->distinct()
            ->where('category !=', '') // 빈 문자열 제외
            ->where('category IS NOT NULL') // NULL 값 제외
            ->findAll();
    }

    public function getRelatedNews($currentId, $keywords, $category = null, $limit = 5)
    {
        $builder = $this->table($this->table);

        // 키워드가 없는 경우 빈 배열 반환
        if (empty(trim($keywords))) {
            return [];
        }

        // FULLTEXT 검색
        $sanitizedKeywords = $this->db->escapeString($keywords);

        $builder->select('*')
            ->where('id !=', $currentId)
            ->where("MATCH(title) AGAINST ('$sanitizedKeywords' IN NATURAL LANGUAGE MODE)", null, false);

        if ($category) {
            $builder->where('category', $category);
        }

        $builder->orderBy('pubDate', 'DESC')->limit($limit);

        $relatedNews = $builder->get()->getResultArray();

        // 부족한 수 계산
        $shortage = $limit - count($relatedNews);

        if ($shortage > 0 && $category) {
            // 부족한 수만큼 같은 카테고리의 1달 이내 글 가져오기
            $randomNewsBuilder = $this->table($this->table);

            $randomNewsBuilder->select('*')
                ->where('id !=', $currentId)
                ->where('category', $category)
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 month')))
                ->orderBy('RAND()')
                ->limit($shortage);

            $randomNews = $randomNewsBuilder->get()->getResultArray();

            // FULLTEXT 결과와 랜덤 결과를 합침
            $relatedNews = array_merge($relatedNews, $randomNews);
        }

        return $relatedNews;
    }

    public function searchNewsCount($keywords)
    {
        $builder = $this->table($this->table);

        // 키워드가 없는 경우 0 반환
        if (empty(trim($keywords))) {
            return 0;
        }

        // FULLTEXT 검색 조건
        $sanitizedKeywords = $this->db->escapeString($keywords);

        $builder->select('COUNT(*) as total')
                ->where("MATCH(title) AGAINST ('$sanitizedKeywords' IN NATURAL LANGUAGE MODE)", null, false);

        $result = $builder->get()->getRowArray();
        return $result['total'] ?? 0;
    }

    public function searchNews($keywords, $limit, $offset)
    {
        $builder = $this->table($this->table);

        if (empty(trim($keywords))) {
            return [];
        }

        $sanitizedKeywords = $this->db->escapeString($keywords);

        $builder->select('*')
                ->where("MATCH(title) AGAINST ('$sanitizedKeywords' IN NATURAL LANGUAGE MODE)", null, false)
                ->orderBy('pubDate', 'DESC')
                ->limit($limit, $offset);

        return $builder->get()->getResultArray();
    }
}