<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('landing', 'Frontend\LandingController::index', ['as' => 'landing']);

$routes->get('login', 'Backend\AuthController::showLoginForm');
$routes->post('login', 'Backend\AuthController::attemptLogin');
$routes->post('logout', 'Backend\AuthController::logout', ['filter' => 'auth']);
$routes->post('aspirasi', 'Backend\AspirasiController::store');

$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\Backend'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
});

$routes->group('admin/galeri', ['filter' => 'auth', 'namespace' => 'App\Controllers\Backend'], static function ($routes) {
    $routes->get('/', 'GaleriController::index');
    $routes->get('tambah', 'GaleriController::create');
    $routes->post('simpan', 'GaleriController::store');
    $routes->get('(:num)/edit', 'GaleriController::edit/$1');
    $routes->post('(:num)/update', 'GaleriController::update/$1');
    $routes->post('(:num)/publish', 'GaleriController::togglePublish/$1');
    $routes->post('(:num)/delete', 'GaleriController::delete/$1');
    $routes->post('(:num)/item', 'GaleriController::storeItem/$1');
    $routes->post('item/(:num)/delete', 'GaleriController::deleteItem/$1');
});

$routes->get('admin/aspirasi', 'Backend\AspirasiController::index', ['filter' => 'auth']);
$routes->get('admin/aspirasi/(:num)', 'Backend\AspirasiController::show/$1', ['filter' => 'auth']);
$routes->post('admin/aspirasi/(:num)/status', 'Backend\AspirasiController::updateStatus/$1', ['filter' => 'auth']);
$routes->post('admin/aspirasi/(:num)/publish', 'Backend\AspirasiController::togglePublish/$1', ['filter' => 'auth']);
$routes->post('admin/aspirasi/(:num)/delete', 'Backend\AspirasiController::delete/$1', ['filter' => 'auth']);
