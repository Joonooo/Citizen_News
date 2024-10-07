<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function view($page = 'home')
    {
        // 파일 경로 설정
        $filePath = APPPATH . 'Views/pages/' . $page . '.php';
        
        // About과 Contact 페이지가 아닌 경우 404 에러 처리
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        // 페이지 제목 설정
        $data['title'] = ucfirst($page);

        // 헤더, 페이지 본문, 푸터 로드
        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }
}
