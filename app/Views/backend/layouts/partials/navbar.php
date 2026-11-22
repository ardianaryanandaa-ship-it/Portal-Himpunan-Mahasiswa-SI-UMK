<?php $currentUri = trim(uri_string(), '/'); ?>
<nav class="navbar navbar-expand navbar-light bg-white border-bottom" aria-label="Navigasi admin">
    <div class="container-xxl">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <a class="nav-link px-3 px-lg-4 py-3 border-bottom border-3 <?= $currentUri === 'admin' ? 'active fw-bold text-primary border-primary' : 'text-gray-700 border-transparent' ?>" href="<?= site_url('admin') ?>" <?= $currentUri === 'admin' ? 'aria-current="page"' : '' ?>>
                Dashboard
            </a>
            <a class="nav-link px-3 px-lg-4 py-3 border-bottom border-3 <?= str_starts_with($currentUri, 'admin/aspirasi') ? 'active fw-bold text-primary border-primary' : 'text-gray-700 border-transparent' ?>" href="<?= site_url('admin/aspirasi') ?>" <?= str_starts_with($currentUri, 'admin/aspirasi') ? 'aria-current="page"' : '' ?>>
                Aspirasi
            </a>
        </div>
        <a class="btn btn-sm btn-light-primary ms-3 flex-shrink-0" href="<?= site_url('/') ?>">Lihat situs</a>
    </div>
</nav>
