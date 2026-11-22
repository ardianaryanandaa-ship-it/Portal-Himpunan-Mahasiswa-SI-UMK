<?php $organization = config('Organization'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panel admin <?= esc($organization->fullName) ?>">
    <title><?= esc($title ?? 'Panel Admin') ?> - <?= esc($organization->name) ?></title>
    <link rel="shortcut icon" href="<?= esc($organization->faviconUrl(), 'attr') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/backend-custom.css') ?>" rel="stylesheet">
    <?= $this->renderSection('styles') ?>
</head>
<body id="kt_body" class="admin-body">
    <script>
        var defaultThemeMode = "light";
        var themeMode = localStorage.getItem("data-bs-theme") || defaultThemeMode;
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>

    <div class="admin-shell">
        <?= $this->include('backend/layouts/partials/sidebar') ?>

        <div class="admin-main">
            <?= $this->include('backend/layouts/partials/topbar') ?>

            <main class="admin-content">
                <?php if ($message = session()->getFlashdata('message')): ?>
                    <div class="alert alert-success d-flex align-items-center" role="status">
                        <i class="ki-duotone ki-check-circle fs-2 text-success me-3"><span class="path1"></span><span class="path2"></span></i>
                        <span><?= esc($message) ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($message = session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="ki-duotone ki-information fs-2 text-danger me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <span><?= esc($message) ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($errors = session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ((array) $errors as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
                    <h1 class="fs-2hx fw-bold text-gray-900 mb-0"><?= esc($title ?? 'Dashboard') ?></h1>
                    <?= $this->renderSection('actions') ?>
                </div>

                <?= $this->renderSection('content') ?>
            </main>

            <footer class="bg-white border-top py-4">
                <div class="px-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                    <span class="text-muted fs-7">&copy; <?= date('Y') ?> <?= esc($organization->name) ?> <?= esc($organization->university) ?></span>
                    <a href="<?= site_url('/') ?>" class="text-gray-600 text-hover-primary fs-7">Kembali ke situs utama</a>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            const toggle = document.getElementById('adminSidebarToggle');

            function closeSidebar() {
                sidebar?.classList.remove('show');
                backdrop?.classList.remove('show');
            }

            toggle?.addEventListener('click', function () {
                sidebar?.classList.toggle('show');
                backdrop?.classList.toggle('show');
            });
            backdrop?.addEventListener('click', closeSidebar);

            document.querySelectorAll('.js-confirm-submit').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const submitButton = form.querySelector('[type="submit"]');
                    Swal.fire({
                        icon: 'question',
                        title: form.dataset.confirmTitle || 'Konfirmasi',
                        text: form.dataset.confirmText || 'Lanjutkan tindakan ini?',
                        showCancelButton: true,
                        confirmButtonText: form.dataset.confirmButton || 'Ya, lanjutkan',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then(function (result) {
                        if (!result.isConfirmed) return;
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.innerHTML = 'Memproses...';
                        }
                        form.submit();
                    });
                });
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
