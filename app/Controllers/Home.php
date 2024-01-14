<?php

namespace App\Controllers;

use App\Models\NewsModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new NewsModel();
        $categoryQuery = $this->request->getVar('category');

        $data = [
            'news' => $model->getNewsByCategory($categoryQuery),
            'title' => '시티즌뉴스',    
            'categories' => $model->getDistinctCategories()
        ];

        echo view('templates/header', $data);
        echo view('news/overview', $data);
        echo view('templates/footer', $data);
    }
    public function view($id)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNews($id);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $id);
        }

        $data['title'] = $data['news']['title'];

        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer');
    }
}
