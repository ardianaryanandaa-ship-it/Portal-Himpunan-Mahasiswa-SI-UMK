<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('landing', 'Home::index', ['as' => 'landing']);

$routes->get('login', 'Backend\AuthController::showLoginForm');
$routes->post('login', 'Backend\AuthController::attemptLogin');
$routes->post('logout', 'Backend\AuthController::logout', ['filter' => 'auth']);

$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\Backend'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
});
