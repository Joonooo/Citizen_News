<?php

namespace App\Controllers;

use App\Models\NewsModel;

class Feed extends BaseController
{
    public function index()
    {
        $newsModel = new NewsModel();
        $newsItems = $newsModel->orderBy('created_at', 'DESC')->findAll(20);

        $rssData = [
            'channel' => [
                'title' => '시티즌뉴스',
                'link' => site_url(),
                'description' => 'The latest news updates from Your Site.',
                'language' => 'ko-kr',
                'pubDate' => date(DATE_RSS),
            ],
            'items' => array_map(function ($item) {
                return [
                    'title' => $item['title'],
                    'link' => htmlspecialchars_decode($item['link'], ENT_QUOTES),
                    'description' => '<![CDATA[' . $item['description'] . ']]>',
                    'pubDate' => date(DATE_RSS, strtotime($item['pubDate'])),
                    'category' => $item['category'] ?: 'General',
                    'guid' => $item['link'],
                ];
            }, $newsItems)
        ];

        // Content-Type 설정
        return $this->response->setContentType('application/rss+xml')
                              ->setBody(view('feed/rss', $rssData));
    }
}
