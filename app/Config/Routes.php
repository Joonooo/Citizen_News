<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index'); // 기본 경로
$routes->get('search', 'Search::index'); // 검색 경로
$routes->get('about', 'Pages::view/about'); // about 페이지
$routes->get('contact', 'Pages::view/contact'); // contact 페이지

$routes->post('send-message', 'Contact::sendMessage');

// 뉴스 상세 페이지 라우트 추가
$routes->get('news/(:num)', 'Home::view/$1');

// 와일드카드 라우트는 가장 마지막에 배치
$routes->get('(:segment)', 'Pages::view/$1'); // 기타 모든 페이지