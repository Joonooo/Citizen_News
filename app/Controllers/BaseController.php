<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NewsModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $data = []; // 공통 데이터 저장용 프로퍼티

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // 부모의 initController 호출
        parent::initController($request, $response, $logger);

        // NewsModel 인스턴스 생성
        $newsModel = new NewsModel();

        // 카테고리 목록 가져오기
        $this->data['categories'] = $newsModel->getDistinctCategories();
    }
}
