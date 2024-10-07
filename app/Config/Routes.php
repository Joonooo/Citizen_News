<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // 기본 경로
$routes->get('about', 'Pages::view/about'); // /about 경로
$routes->get('contact', 'Pages::view/contact'); // /contact 경로
$routes->get('(:segment)', 'Pages::view/$1'); // 모든 페이지를 Pages 컨트롤러로