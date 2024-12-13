<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 기존 라우트 설정
$routes->get('/', 'Home::index'); // 기본 경로
$routes->get('search', 'Search::index'); // 검색 경로
$routes->get('about', 'Pages::view/about'); // about 페이지
$routes->get('contact', 'Pages::view/contact'); // contact 페이지

$routes->post('send-message', 'Contact::sendMessage');

// 뉴스 목록 및 상세 페이지 라우트
$routes->get('news', 'News::index');
$routes->get('news/(:num)', 'News::view/$1');

// 예를 들어, pages/(:segment)로 변경
$routes->get('pages/(:segment)', 'Pages::view/$1');

$routes->get('rss', 'Feed::index');