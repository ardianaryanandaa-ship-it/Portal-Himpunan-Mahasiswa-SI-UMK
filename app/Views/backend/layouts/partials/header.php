<?php helper(['form', 'url']); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panel admin HIMA Sistem Informasi Universitas Muria Kudus">
    <title><?= esc($title ?? 'Panel Admin HIMA SI') ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet">
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed bg-light">
    <script>
        var defaultThemeMode = "light";
        var themeMode = localStorage.getItem("data-bs-theme") || defaultThemeMode;
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>
    <header class="header bg-white border-bottom" id="kt_header">
        <div class="container-xxl d-flex align-items-center justify-content-between py-4">
            <a href="<?= site_url('admin') ?>" class="d-flex align-items-center text-decoration-none">
                <span class="fs-2 fw-bold text-gray-900">HIMA SI</span>
                <span class="badge badge-light-primary ms-3">Admin</span>
            </a>
            <div class="d-flex align-items-center gap-4">
                <span class="text-gray-700"><?= esc(session()->get('user_name') ?? 'Administrator') ?></span>
                <form method="post" action="<?= site_url('logout') ?>">
                    <?= csrf_field() ?>
                    <button class="btn btn-sm btn-light-danger" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </header>