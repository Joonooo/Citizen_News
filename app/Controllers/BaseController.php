<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NewsModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $categories = []; // 카테고리 변수를 정의합니다.

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // 카테고리 데이터를 로드합니다.
        $newsModel = new NewsModel();
        $this->categories = $newsModel->getDistinctCategories();
    }
}
