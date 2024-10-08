<?php

namespace App\Controllers;

use App\Models\NewsModel;

class Home extends BaseController
{
    public function index()
    {
        $newsModel = new NewsModel();

        // 요청된 페이지 번호 가져오기 (기본값은 1페이지)
        $page = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
        $limit = 10;  // 페이지 당 보여줄 뉴스 수
        $offset = ($page - 1) * $limit;

        // 카테고리 필터 처리
        $categoryQuery = $this->request->getVar('category');

        // 카테고리 목록 가져오기
        $categories = $newsModel->getDistinctCategories();

        // 허용된 카테고리 목록 배열 생성
        $allowedCategories = array_column($categories, 'category');

        // 카테고리 검증 및 보안 강화
        if ($categoryQuery && !in_array($categoryQuery, $allowedCategories)) {
            throw new \Exception('Invalid category selected.');
        }

        // 카테고리 필터 적용
        if ($categoryQuery) {
            $newsModel->where('category', $categoryQuery);
        }

        // 전체 뉴스 수 가져오기 (페이지 수 계산을 위해)
        $totalNews = $newsModel->countAllResults(false);
        $totalPages = ceil($totalNews / $limit);

        // 뉴스 데이터 가져오기
        $news = $newsModel->orderBy('created_at', 'DESC')
                          ->findAll($limit, $offset);

        $data = [
            'news' => $news,
            'title' => '시티즌뉴스',
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'categoryQuery' => $categoryQuery
        ];

        echo view('templates/header', $data);
        echo view('news/overview', $data);
        echo view('templates/footer', $data);
    }

    public function view($id)
    {
        $newsModel = new NewsModel();
    
        $data['news'] = $newsModel->getNews($id);
    
        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $id);
        }
    
        $data['title'] = $data['news']['title'];
        $data['categories'] = $this->categories;
    
        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer', $data);
    }    
}
