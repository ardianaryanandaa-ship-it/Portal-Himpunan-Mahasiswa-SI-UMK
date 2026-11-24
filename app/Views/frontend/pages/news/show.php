<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<div class="row g-10">
		<div class="col-lg-8">
			<article class="card card-flush border border-gray-200">
				<?php if (! empty($news['thumbnail'])): ?>
					<img src="<?= esc(base_url(ltrim($news['thumbnail'], '/')), 'attr') ?>" alt="<?= esc($news['title'], 'attr') ?>" class="w-100" style="max-height:420px;object-fit:cover">
				<?php endif; ?>
				<div class="card-body p-7 p-lg-10">
					<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
						<span class="badge badge-light-primary fs-8 fw-semibold">Berita</span>
						<span class="text-muted fs-7">
							<i class="ki-duotone ki-calendar fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>
							<?= ! empty($news['published_at']) ? esc(date('d F Y H:i', strtotime($news['published_at']))) : '-' ?>
						</span>
					</div>

					<h1 class="fs-2x fw-bold text-gray-900 mb-5"><?= esc($news['title']) ?></h1>

					<?php if (! empty($news['excerpt'])): ?>
						<p class="fs-5 text-muted fw-semibold mb-6"><?= nl2br(esc($news['excerpt'])) ?></p>
					<?php endif; ?>

					<div class="separator my-7"></div>

					<div class="article-content"><?= $content ?></div>

					<div class="separator my-8"></div>

					<div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
						<a href="<?= site_url('berita') ?>" class="btn btn-sm btn-light">
							<i class="ki-duotone ki-arrow-left fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
							Semua Berita
						</a>
						<a href="<?= esc($organization->whatsappUrl(), 'attr') ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light-success">
							<i class="ki-duotone ki-whatsapp fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
							Bagikan via WhatsApp
						</a>
					</div>
				</div>
			</article>
		</div>

		<aside class="col-lg-4">
			<div class="card card-flush border border-gray-200 mb-8">
				<div class="card-header pt-6">
					<h3 class="card-title fw-bold">Berita Lainnya</h3>
				</div>
				<div class="card-body pt-2">
					<?php if ($related === []): ?>
						<p class="text-muted fs-7 mb-0">Belum ada berita lain.</p>
					<?php else: ?>
						<?php foreach ($related as $item): ?>
							<a href="<?= site_url('berita/' . $item['slug']) ?>" class="d-flex gap-3 py-4 border-bottom border-gray-200 text-decoration-none">
								<?php $thumb = trim((string) ($item['thumbnail'] ?? '')); ?>
								<img src="<?= esc($thumb !== '' ? base_url(ltrim($thumb, '/')) : base_url('assets/media/stock/600x400/img-1.jpg'), 'attr') ?>" alt="" class="rounded" style="width:76px;height:58px;object-fit:cover">
								<span class="d-flex flex-column">
									<strong class="text-gray-900 fs-7"><?= esc($item['title']) ?></strong>
									<small class="text-muted fs-8 mt-1"><?= ! empty($item['published_at']) ? esc(date('d M Y', strtotime($item['published_at']))) : '' ?></small>
								</span>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="card card-flush border-0" style="background:linear-gradient(135deg,#12345c,#1b4f7a)">
				<div class="card-body p-7 text-white">
					<h3 class="fs-5 fw-bold text-white mb-2">Punya aspirasi?</h3>
					<p class="fs-7 opacity-75 mb-5">Sampaikan ide, kritik, atau saran untuk <?= esc($organization->name) ?> melalui kotak aspirasi.</p>
					<a href="<?= site_url('/') ?>#aspirations" class="btn btn-sm btn-light">Kirim Aspirasi</a>
				</div>
			</div>
		</aside>
	</div>
</div>
<?= $this->endSection() ?>
