<?php helper(['form', 'url']); ?>
<header class="bg-white border-bottom" id="kt_header">
    <div class="container-xxl d-flex align-items-center justify-content-between py-3 py-lg-4">
        <a href="<?= site_url('admin') ?>" class="d-flex align-items-center text-decoration-none">
            <span class="fs-2 fw-bold text-gray-900">HIMA SI</span>
            <span class="badge badge-light-primary ms-3">Admin</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-sm-block text-end">
                <div class="text-gray-900 fw-semibold fs-7"><?= esc(session()->get('user_name') ?? 'Administrator') ?></div>
                <div class="text-muted fs-8">Pengguna aktif</div>
            </div>
            <form method="post" action="<?= site_url('logout') ?>">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-light-danger" type="submit">Keluar</button>
            </form>
        </div>
    </div>
</header>