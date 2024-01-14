<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/(:segment)', 'Home::view/$1');
$routes->get('/', 'Home::index');
