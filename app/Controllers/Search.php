<?php

namespace App\Controllers;

use App\Models\NewsModel;
use Exception;

class Search extends BaseController
{
    public function index()
    {
        try {
            $searchQuery = $this->request->getVar('q');

            $searchQuery = trim($searchQuery); // 앞뒤 공백 제거
            $searchQuery = strip_tags($searchQuery); // HTML 태그 제거
            $searchQuery = htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); // 특수문자 이스케이프

            // 검색어가 없는 경우 홈 페이지로 리다이렉트
            if (!$searchQuery) {
                return redirect()->to('/');
            }

            $newsModel = new NewsModel();

            // 요청된 페이지 번호 가져오기 (기본값은 1페이지)
            $page = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
            $limit = 10;  // 페이지 당 보여줄 뉴스 수
            $offset = ($page - 1) * $limit;

            // 전체 뉴스 수 가져오기 (페이지 수 계산을 위해)
            $totalNews = $newsModel->searchNewsCount($searchQuery);
            $totalPages = ceil($totalNews / $limit);

            // 뉴스 검색
            $results = $newsModel->searchNews($searchQuery, $limit, $offset);

            // 공통 데이터와 병합
            $data = array_merge($this->data, [
                'title' => '검색 결과',
                'results' => $results,
                'searchQuery' => $searchQuery,
                'currentPage' => $page,
                'totalPages' => $totalPages,
            ]);

            echo view('templates/header', $data);
            echo view('search/results', $data);
            echo view('templates/footer', $data);
        } catch (Exception $e) {
            // 오류 메시지를 로그로 기록
            log_message('error', '검색 오류: ' . $e->getMessage());

            // 사용자에게 친절한 오류 메시지 표시
            $data = array_merge($this->data, [
                'title' => '오류 발생',
                'errorMessage' => '검색 중 오류가 발생했습니다. 잠시 후 다시 시도해주세요.',
            ]);

            echo view('templates/header', $data);
            echo view('errors/custom_error', $data);
            echo view('templates/footer', $data);
        }
    }
}
