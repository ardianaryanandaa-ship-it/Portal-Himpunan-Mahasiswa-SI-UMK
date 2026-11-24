<header class="admin-topbar">
    <div class="d-flex align-items-center justify-content-between gap-3 px-4 py-3">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn btn-sm btn-light d-lg-none" id="adminSidebarToggle" aria-label="Buka menu">
                <i class="ki-duotone ki-abstract-14 fs-3"><span class="path1"></span><span class="path2"></span></i>
            </button>
            <div>
                <div class="text-muted fs-8 text-uppercase fw-bold">Panel Admin</div>
                <div class="text-gray-900 fw-bold fs-6"><?= esc($title ?? 'Dashboard') ?></div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="<?= site_url('admin/profil') ?>" class="text-decoration-none d-none d-sm-block text-end">
                <span class="d-block text-gray-900 fw-semibold fs-7"><?= esc(session('user_name') ?? 'Pengguna') ?></span>
                <span class="text-muted fs-8"><?= esc(session('role_name') ?: role_label(session('role_slug'))) ?></span>
            </a>
            <form method="post" action="<?= site_url('logout') ?>" class="mb-0">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-light-danger" type="submit">Keluar</button>
            </form>
        </div>
    </div>
</header>
