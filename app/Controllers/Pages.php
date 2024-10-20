<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function view($page = 'home')
    {
        // 뷰 파일 경로 확인
        $filePath = APPPATH . 'Views/pages/' . $page . '.php';

        // 뷰 파일이 존재하지 않으면 404 오류 발생
        if (!is_file($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        // 페이지 제목 설정
        $data['title'] = ucfirst($page);

        // 공통 데이터와 병합
        $data = array_merge($this->data, $data);

        // 헤더, 페이지 본문, 푸터 로드
        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }
}
