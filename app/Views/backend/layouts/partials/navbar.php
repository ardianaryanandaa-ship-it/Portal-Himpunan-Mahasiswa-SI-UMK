<?php $currentUri = trim(uri_string(), '/'); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" aria-label="Navigasi admin">
    <div class="container-xxl">
        <a class="nav-link <?= $currentUri === 'admin' ? 'active fw-bold text-primary' : '' ?>" href="<?= site_url('admin') ?>" <?= $currentUri === 'admin' ? 'aria-current="page"' : '' ?>>
            Dashboard
        </a>
        <a class="btn btn-sm btn-light-primary" href="<?= site_url('/') ?>">Lihat situs</a>
    </div>
</nav>
