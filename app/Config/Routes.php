<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
<<<<<<< HEAD
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('landing', 'Frontend\LandingController::index', ['as' => 'landing']);
=======
>>>>>>> origin/nando

// Halaman publik
$routes->get('/', 'Home::index', ['as' => 'home', 'filter' => 'honeypot']);
$routes->get('landing', 'Home::index', ['as' => 'landing', 'filter' => 'honeypot']);
$routes->get('tentang', 'Frontend\PageController::about');
$routes->get('kontak', 'Frontend\PageController::contact');
$routes->get('berita', 'Frontend\NewsController::index');
$routes->get('berita/(:segment)', 'Frontend\NewsController::show/$1');
$routes->get('galeri', 'Frontend\GalleryController::index');
$routes->get('struktur', 'Frontend\StructureController::index');
$routes->get('proker', 'Frontend\ProgramController::index');

// Agenda kegiatan publik
$routes->get('agenda', 'Frontend\AgendaController::index');
$routes->get('agenda/(:segment)', 'Frontend\AgendaController::show/$1', ['filter' => 'honeypot']);
$routes->post('agenda/(:segment)/daftar', 'Frontend\AgendaController::register/$1', ['filter' => 'honeypot']);

// Rekrutmen anggota publik
$routes->get('rekrutmen', 'Frontend\RecruitmentController::index');
$routes->get('rekrutmen/(:segment)', 'Frontend\RecruitmentController::show/$1', ['filter' => 'honeypot']);
$routes->post('rekrutmen/(:segment)/daftar', 'Frontend\RecruitmentController::apply/$1', ['filter' => 'honeypot']);

// Autentikasi panel
$routes->get('login', 'Backend\AuthController::showLoginForm');
$routes->post('login', 'Backend\AuthController::attemptLogin');
$routes->post('logout', 'Backend\AuthController::logout', ['filter' => 'auth']);

// Form aspirasi publik (honeypot + throttler di controller)
$routes->post('aspirasi', 'Backend\AspirasiController::store', ['filter' => 'honeypot']);

// Panel admin
$routes->group('admin', ['filter' => 'auth', 'namespace' => 'App\Controllers\Backend'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');

<<<<<<< HEAD
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
=======
    $routes->get('profil', 'ProfileController::index');
    $routes->post('profil', 'ProfileController::update');
    $routes->get('profil/password', 'ProfileController::changePassword');
    $routes->post('profil/password', 'ProfileController::updatePassword');

    $routes->group('pengguna', ['filter' => 'role:super-admin'], static function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('tambah', 'UserController::create');
        $routes->post('tambah', 'UserController::store');
        $routes->get('(:num)/edit', 'UserController::edit/$1');
        $routes->post('(:num)/edit', 'UserController::update/$1');
        $routes->post('(:num)/toggle', 'UserController::toggleActive/$1');
        $routes->post('(:num)/hapus', 'UserController::delete/$1');
        $routes->post('(:num)/reset-password', 'UserController::resetPassword/$1');
    });

    $routes->group('aspirasi', ['filter' => 'role:super-admin,pengurus-inti'], static function ($routes) {
        $routes->get('/', 'AspirasiController::index');
        $routes->get('ekspor', 'AspirasiController::export');
        $routes->get('(:num)', 'AspirasiController::show/$1');
        $routes->post('(:num)/status', 'AspirasiController::updateStatus/$1');
        $routes->post('(:num)/publish', 'AspirasiController::togglePublish/$1');
        $routes->post('(:num)/delete', 'AspirasiController::delete/$1');
    });

    $routes->group('berita', ['filter' => 'role:super-admin,kominfo'], static function ($routes) {
        $routes->get('/', 'NewsController::index');
        $routes->get('tambah', 'NewsController::create');
        $routes->post('tambah', 'NewsController::store');
        $routes->get('(:num)/edit', 'NewsController::edit/$1');
        $routes->post('(:num)/edit', 'NewsController::update/$1');
        $routes->post('(:num)/hapus', 'NewsController::delete/$1');
    });

    $routes->group('galeri', ['filter' => 'role:super-admin,kominfo'], static function ($routes) {
        $routes->get('/', 'GalleryController::index');
        $routes->get('tambah', 'GalleryController::create');
        $routes->post('tambah', 'GalleryController::store');
        $routes->get('(:num)/edit', 'GalleryController::edit/$1');
        $routes->post('(:num)/edit', 'GalleryController::update/$1');
        $routes->post('(:num)/toggle', 'GalleryController::toggleActive/$1');
        $routes->post('(:num)/hapus', 'GalleryController::delete/$1');
    });

    $routes->group('divisi', ['filter' => 'role:super-admin,kominfo,pengurus-inti'], static function ($routes) {
        $routes->get('/', 'DivisionController::index');
        $routes->get('tambah', 'DivisionController::create');
        $routes->post('tambah', 'DivisionController::store');
        $routes->get('(:num)/edit', 'DivisionController::edit/$1');
        $routes->post('(:num)/edit', 'DivisionController::update/$1');
        $routes->post('(:num)/hapus', 'DivisionController::delete/$1');

        $routes->get('anggota', 'MemberController::index');
        $routes->get('anggota/tambah', 'MemberController::create');
        $routes->post('anggota/tambah', 'MemberController::store');
        $routes->get('anggota/(:num)/edit', 'MemberController::edit/$1');
        $routes->post('anggota/(:num)/edit', 'MemberController::update/$1');
        $routes->post('anggota/(:num)/toggle', 'MemberController::toggleActive/$1');
        $routes->post('anggota/(:num)/hapus', 'MemberController::delete/$1');
    });

    $routes->group('proker', ['filter' => 'role:super-admin,pengurus-inti'], static function ($routes) {
        $routes->get('/', 'WorkProgramController::index');
        $routes->get('tambah', 'WorkProgramController::create');
        $routes->post('tambah', 'WorkProgramController::store');
        $routes->get('(:num)/edit', 'WorkProgramController::edit/$1');
        $routes->post('(:num)/edit', 'WorkProgramController::update/$1');
        $routes->post('(:num)/hapus', 'WorkProgramController::delete/$1');
    });

    $routes->get('event', 'EventController::index', ['filter' => 'role:super-admin,panitia,pengurus-inti']);
    $routes->get('event/tambah', 'EventController::create', ['filter' => 'role:super-admin,panitia']);
    $routes->post('event/tambah', 'EventController::store', ['filter' => 'role:super-admin,panitia']);
    $routes->get('event/(:num)/edit', 'EventController::edit/$1', ['filter' => 'role:super-admin,panitia']);
    $routes->post('event/(:num)/edit', 'EventController::update/$1', ['filter' => 'role:super-admin,panitia']);
    $routes->post('event/(:num)/hapus', 'EventController::delete/$1', ['filter' => 'role:super-admin,panitia']);

    $routes->get('event/(:num)/peserta', 'EventController::participants/$1', ['filter' => 'role:super-admin,panitia,pengurus-inti']);
    $routes->get('event/(:num)/peserta/ekspor', 'EventController::exportParticipants/$1', ['filter' => 'role:super-admin,panitia,pengurus-inti']);
    $routes->post('event/(:num)/peserta/(:num)/hapus', 'EventController::deleteParticipant/$1/$2', ['filter' => 'role:super-admin,panitia']);

    $routes->group('rekrutmen', ['filter' => 'role:super-admin,pengurus-inti'], static function ($routes) {
        $routes->get('/', 'RecruitmentController::index');
        $routes->get('tambah', 'RecruitmentController::create');
        $routes->post('tambah', 'RecruitmentController::store');
        $routes->get('(:num)/edit', 'RecruitmentController::edit/$1');
        $routes->post('(:num)/edit', 'RecruitmentController::update/$1');
        $routes->post('(:num)/hapus', 'RecruitmentController::delete/$1');
        $routes->get('(:num)/pendaftar', 'RecruitmentController::applications/$1');
        $routes->get('(:num)/pendaftar/ekspor', 'RecruitmentController::exportApplications/$1');
        $routes->get('(:num)/pendaftar/(:num)', 'RecruitmentController::application/$1/$2');
        $routes->post('(:num)/pendaftar/(:num)/status', 'RecruitmentController::updateApplicationStatus/$1/$2');
    });
});
>>>>>>> origin/nando
