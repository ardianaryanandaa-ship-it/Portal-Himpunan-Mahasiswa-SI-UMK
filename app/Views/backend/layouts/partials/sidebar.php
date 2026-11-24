<?php
$organization = config('Organization');
$currentUri   = trim(uri_string(), '/');
$isActive     = static fn (string $prefix): bool => $currentUri === $prefix || str_starts_with($currentUri, $prefix . '/');
?>
<aside class="admin-sidebar" id="adminSidebar">
    <a href="<?= site_url('admin') ?>" class="admin-brand">
        <img src="<?= esc($organization->logoUrl(), 'attr') ?>" alt="Logo <?= esc($organization->name, 'attr') ?>">
        <span>
            <strong class="d-block text-white fs-5"><?= esc($organization->name) ?></strong>
            <small class="text-gray-500 fs-8">Panel Pengurus</small>
        </span>
    </a>

    <div class="px-4 py-3 border-bottom border-gray-800">
        <div class="text-white fw-semibold fs-7"><?= esc(session('user_name') ?? 'Pengguna') ?></div>
        <span class="badge badge-light-primary fs-8 mt-1"><?= esc(session('role_name') ?: role_label(session('role_slug'))) ?></span>
    </div>

    <nav class="admin-menu" aria-label="Menu admin">
        <div class="admin-menu-label">Utama</div>
        <a class="admin-link <?= $currentUri === 'admin' ? 'active' : '' ?>" href="<?= site_url('admin') ?>">
            <i class="ki-duotone ki-element-11"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            Dashboard
        </a>

        <?php if (has_role('super-admin', 'pengurus-inti')): ?>
            <div class="admin-menu-label">Layanan</div>
            <a class="admin-link <?= $isActive('admin/aspirasi') ? 'active' : '' ?>" href="<?= site_url('admin/aspirasi') ?>">
                <i class="ki-duotone ki-messages"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                Aspirasi
            </a>
            <a class="admin-link <?= $isActive('admin/rekrutmen') ? 'active' : '' ?>" href="<?= site_url('admin/rekrutmen') ?>">
                <i class="ki-duotone ki-people"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                Rekrutmen
            </a>
        <?php endif; ?>

        <?php if (has_role('super-admin', 'kominfo')): ?>
            <div class="admin-menu-label">Konten</div>
            <a class="admin-link <?= $isActive('admin/berita') ? 'active' : '' ?>" href="<?= site_url('admin/berita') ?>">
                <i class="ki-duotone ki-notepad-edit"><span class="path1"></span><span class="path2"></span></i>
                Berita
            </a>
            <a class="admin-link <?= $isActive('admin/galeri') ? 'active' : '' ?>" href="<?= site_url('admin/galeri') ?>">
                <i class="ki-duotone ki-picture"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                Galeri
            </a>
        <?php endif; ?>

        <?php if (has_role('super-admin', 'kominfo', 'pengurus-inti')): ?>
            <a class="admin-link <?= $isActive('admin/divisi') ? 'active' : '' ?>" href="<?= site_url('admin/divisi') ?>">
                <i class="ki-duotone ki-hierarchy-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                Struktur Organisasi
            </a>
        <?php endif; ?>

        <?php if (has_role('super-admin', 'pengurus-inti')): ?>
            <a class="admin-link <?= $isActive('admin/proker') ? 'active' : '' ?>" href="<?= site_url('admin/proker') ?>">
                <i class="ki-duotone ki-calendar-tick"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
                Program Kerja
            </a>
        <?php endif; ?>

        <?php if (has_role('super-admin', 'panitia', 'pengurus-inti')): ?>
            <div class="admin-menu-label">Kegiatan</div>
            <a class="admin-link <?= $isActive('admin/event') ? 'active' : '' ?>" href="<?= site_url('admin/event') ?>">
                <i class="ki-duotone ki-calendar"><span class="path1"></span><span class="path2"></span></i>
                Event &amp; Peserta
            </a>
        <?php endif; ?>

        <?php if (has_role('super-admin')): ?>
            <div class="admin-menu-label">Sistem</div>
            <a class="admin-link <?= $isActive('admin/pengguna') ? 'active' : '' ?>" href="<?= site_url('admin/pengguna') ?>">
                <i class="ki-duotone ki-profile-user"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                Kelola Pengguna
            </a>
        <?php endif; ?>

        <div class="admin-menu-label">Akun</div>
        <a class="admin-link <?= $isActive('admin/profil') ? 'active' : '' ?>" href="<?= site_url('admin/profil') ?>">
            <i class="ki-duotone ki-user"><span class="path1"></span><span class="path2"></span></i>
            Profil Saya
        </a>
        <a class="admin-link" href="<?= site_url('/') ?>" target="_blank" rel="noopener">
            <i class="ki-duotone ki-exit-right-corner"><span class="path1"></span><span class="path2"></span></i>
            Lihat Website
        </a>
    </nav>
</aside>
<div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>
