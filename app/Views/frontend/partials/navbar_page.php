<?php
$organization = config('Organization');
$currentPath  = trim(uri_string(), '/');
$isActive     = static fn (string $path): string => $currentPath === $path || ($path !== '' && str_starts_with($currentPath, $path . '/')) ? 'active' : '';
?>
<header class="page-navbar">
	<div class="container">
		<nav class="navbar navbar-expand-lg py-3">
			<a href="<?= site_url('/') ?>" class="navbar-brand d-flex align-items-center gap-3 m-0">
				<img src="<?= esc($organization->logoUrl(), 'attr') ?>" alt="Logo <?= esc($organization->name, 'attr') ?>" style="height:44px;width:auto">
				<span class="d-flex flex-column lh-1">
					<strong class="fs-4 text-gray-900"><?= esc($organization->name) ?></strong>
					<small class="text-muted fs-8 mt-1"><?= esc($organization->university) ?></small>
				</span>
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pageNavbar" aria-controls="pageNavbar" aria-expanded="false" aria-label="Buka menu">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="pageNavbar">
				<ul class="navbar-nav mx-auto gap-lg-1 my-4 my-lg-0">
					<li class="nav-item"><a class="nav-link <?= $isActive('') ?>" href="<?= site_url('/') ?>">Beranda</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('tentang') ?>" href="<?= site_url('tentang') ?>">Tentang</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('berita') ?>" href="<?= site_url('berita') ?>">Berita</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('agenda') ?>" href="<?= site_url('agenda') ?>">Agenda</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('galeri') ?>" href="<?= site_url('galeri') ?>">Galeri</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('struktur') ?>" href="<?= site_url('struktur') ?>">Struktur</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('proker') ?>" href="<?= site_url('proker') ?>">Program Kerja</a></li>
					<li class="nav-item"><a class="nav-link <?= $isActive('kontak') ?>" href="<?= site_url('kontak') ?>">Kontak</a></li>
				</ul>
				<div class="d-flex flex-wrap gap-2">
					<a href="<?= site_url('/') ?>#aspirations" class="btn btn-sm btn-light-primary">Aspirasi</a>
					<?php if (is_logged_in()): ?>
						<a href="<?= site_url('admin') ?>" class="btn btn-sm btn-primary">Panel Admin</a>
					<?php else: ?>
						<a href="<?= site_url('login') ?>" class="btn btn-sm btn-primary">Masuk Pengurus</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
</header>
