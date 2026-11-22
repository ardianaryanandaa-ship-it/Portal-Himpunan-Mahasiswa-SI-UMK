<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('landing', 'Home::index', ['as' => 'landing']);

$routes->get('login', 'Backend\AuthController::showLoginForm');
$routes->post('login', 'Backend\AuthController::attemptLogin');
$routes->post('logout', 'Backend\AuthController::logout', ['filter' => 'auth']);
$routes->post('aspirasi', 'AspirasiController::store');

$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\Backend'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('aspirasi', 'AspirasiController::index');
    $routes->get('aspirasi/(:num)', 'AspirasiController::show/$1');
    $routes->post('aspirasi/(:num)/status', 'AspirasiController::updateStatus/$1');
    $routes->post('aspirasi/(:num)/publish', 'AspirasiController::togglePublish/$1');
    $routes->post('aspirasi/(:num)/delete', 'AspirasiController::delete/$1');
});
