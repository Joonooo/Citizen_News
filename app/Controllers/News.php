<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $newsModel = new NewsModel();

        // GET 요청에서 'category' 파라미터 가져오기
        $categoryQuery = $this->request->getGet('category');

        // 승인된 뉴스 기사 가져오기
        if ($categoryQuery) {
            // 특정 카테고리의 뉴스 가져오기
            $news = $newsModel->where('status', 'approved')
                ->where('category', $categoryQuery)
                ->orderBy('pubDate', 'DESC')
                ->findAll();
        } else {
            // 모든 승인된 뉴스 가져오기
            $news = $newsModel->where('status', 'approved')
                ->orderBy('pubDate', 'DESC')
                ->findAll();
        }

        // 페이지 제목 설정
        $title = '뉴스 목록';

        // 선택된 카테고리 전달
        $categoryQuery = $categoryQuery ?? '';

        // 뷰에 전달할 데이터 구성
        $data = array_merge($this->data, [
            'news' => $news,
            'title' => $title,
            'categoryQuery' => $categoryQuery,
        ]);

        // 뷰 반환
        return view('news/view', $data);
    }

    public function view($id)
    {
        $newsModel = new NewsModel();

        // 단일 뉴스 항목 가져오기
        $newsItem = $newsModel->getNews($id);

        if (empty($newsItem)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('뉴스 기사를 찾을 수 없습니다.');
        }
        
        // 주요 키워드 추출 (예: 제목과 설명을 기반으로)
        $keywords = $newsItem['title'];
        if (!empty($newsItem['description'])) {
            $keywords .= ' ' . $newsItem['description'];
        }
        
        // 관련 뉴스 가져오기
        $relatedNews = $newsModel->getRelatedNews($newsItem['id'], $keywords, $newsItem['category'], 5);
        
        // 데이터 배열 구성
        $data = array_merge($this->data, [
            'news' => $newsItem,
            'relatedNews' => $relatedNews,
            'title' => $newsItem['title'],
            'categoryQuery' => $newsItem['category'] ?? ''
        ]);

        // 뷰 반환
        return view('templates/header', $data)
            . view('news/view', $data)
            . view('templates/footer', $data);
    }
}
