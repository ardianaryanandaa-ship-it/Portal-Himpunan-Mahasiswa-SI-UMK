<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Akses Ditolak') ?> - <?= esc(config('Organization')->name) ?></title>
    <link rel="shortcut icon" href="<?= esc(config('Organization')->faviconUrl(), 'attr') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex flex-column flex-center min-vh-100 p-8 text-center">
        <span class="badge badge-light-danger fs-6 fw-bold px-4 py-3 mb-5">ERROR 403</span>
        <h1 class="fs-2hx fw-bold text-gray-900 mb-3">Anda Tidak Memiliki Akses</h1>
        <p class="fs-5 text-muted fw-semibold mw-600px mb-8">
            Halaman ini hanya dapat dibuka oleh pengguna dengan hak akses tertentu.
            Silakan kembali ke dashboard atau masuk menggunakan akun yang sesuai.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <?php if (session('user_id')): ?>
                <a href="<?= site_url('admin') ?>" class="btn btn-primary">Kembali ke Dashboard</a>
            <?php else: ?>
                <a href="<?= site_url('login') ?>" class="btn btn-primary">Masuk</a>
            <?php endif; ?>
            <a href="<?= site_url('/') ?>" class="btn btn-light">Halaman Utama</a>
        </div>
    </div>
</body>
</html>
