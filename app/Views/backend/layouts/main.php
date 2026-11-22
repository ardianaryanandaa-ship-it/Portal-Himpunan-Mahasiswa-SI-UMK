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
    <?= $this->renderSection('styles') ?>
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

    <?= $this->include('backend/layouts/partials/header') ?>
    <?= $this->include('backend/layouts/partials/navbar') ?>

    <main class="container-xxl flex-grow-1 py-6">
        <h1 class="fs-2hx fw-bold text-gray-900 mb-6"><?= esc($title ?? 'Dashboard') ?></h1>
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('backend/layouts/partials/footer') ?>

    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
