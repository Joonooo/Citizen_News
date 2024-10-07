<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NewsModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var \CodeIgniter\HTTP\RequestInterface
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * 카테고리 데이터를 저장할 변수
     *
     * @var array
     */
    protected $categories = [];

    /**
     * 생성자
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // 이 줄은 수정하지 마세요.
        parent::initController($request, $response, $logger);

        // 카테고리 데이터를 로드합니다.
        $newsModel = new NewsModel();
        $this->categories = $newsModel->getDistinctCategories();
    }
}
