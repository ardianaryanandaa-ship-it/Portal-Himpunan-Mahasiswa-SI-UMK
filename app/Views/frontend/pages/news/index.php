<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<div class="row justify-content-center mb-10">
		<div class="col-lg-8 text-center">
			<span class="badge badge-light-primary fs-8 fw-bold text-uppercase mb-3 px-4 py-2">Kabar Terbaru</span>
			<h2 class="page-section-title mb-3">Berita <?= esc($organization->name) ?></h2>
			<p class="text-muted fs-6 mb-6">Informasi kegiatan, prestasi, dan agenda terbaru dari <?= esc($organization->fullName) ?>.</p>

			<form method="get" action="<?= site_url('berita') ?>" class="d-flex gap-2 justify-content-center">
				<input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-solid" style="max-width:340px" placeholder="Cari berita...">
				<button type="submit" class="btn btn-primary">Cari</button>
				<?php if ($keyword !== ''): ?>
					<a href="<?= site_url('berita') ?>" class="btn btn-light">Reset</a>
				<?php endif; ?>
			</form>
		</div>
	</div>

	<?php if ($news === []): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-notepad fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span></i>
			<p class="mb-0"><?= $keyword !== '' ? 'Tidak ada berita yang cocok dengan pencarian Anda.' : 'Belum ada berita yang diterbitkan.' ?></p>
		</div>
	<?php else: ?>
		<div class="row g-8">
			<?php foreach ($news as $item): ?>
				<?php
				$thumbnail = trim((string) ($item['thumbnail'] ?? ''));
				$imageUrl  = $thumbnail !== '' ? base_url(ltrim($thumbnail, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
				$excerpt   = trim((string) ($item['excerpt'] ?? ''));
				if ($excerpt === '') {
					$excerpt = mb_substr(trim(strip_tags((string) $item['content'])), 0, 170);
				}
				?>
				<div class="col-md-6 col-lg-4">
					<article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
						<a href="<?= site_url('berita/' . $item['slug']) ?>">
							<img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($item['title'], 'attr') ?>" class="w-100 h-200px object-fit-cover">
						</a>
						<div class="card-body p-6 d-flex flex-column">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<span class="badge badge-light-primary fs-8 fw-semibold">Berita</span>
								<span class="text-muted fs-7"><?= ! empty($item['published_at']) ? esc(date('d M Y', strtotime($item['published_at']))) : '' ?></span>
							</div>
							<h3 class="fs-5 fw-bold text-gray-900 mb-3">
								<a href="<?= site_url('berita/' . $item['slug']) ?>" class="text-gray-900 text-hover-primary"><?= esc($item['title']) ?></a>
							</h3>
							<p class="text-muted fs-7 mb-4"><?= esc($excerpt) ?><?= mb_strlen($excerpt) >= 170 ? '...' : '' ?></p>
							<a href="<?= site_url('berita/' . $item['slug']) ?>" class="link-primary fw-semibold fs-7 mt-auto d-inline-flex align-items-center">
								Baca Selengkapnya
								<i class="ki-duotone ki-arrow-right fs-6 ms-2"><span class="path1"></span><span class="path2"></span></i>
							</a>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mt-10 d-flex justify-content-center"><?= $pager->links() ?></div>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>
