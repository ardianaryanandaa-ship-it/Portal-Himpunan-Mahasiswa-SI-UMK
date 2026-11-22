<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?php if ($galleries === []): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-picture fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
			<p class="mb-0">Belum ada foto galeri yang dipublikasikan.</p>
		</div>
	<?php else: ?>
		<div class="row g-6">
			<?php foreach ($galleries as $gallery): ?>
				<?php
				$image     = trim((string) ($gallery['image'] ?? ''));
				$imageUrl  = $image !== '' ? base_url(ltrim($image, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
				?>
				<div class="col-sm-6 col-lg-4">
					<article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up">
						<a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="public-gallery">
							<img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($gallery['title'], 'attr') ?>" class="w-100 h-250px object-fit-cover">
						</a>
						<div class="card-body p-6">
							<h3 class="fs-6 fw-bold text-gray-900 mb-2"><?= esc($gallery['title']) ?></h3>
							<?php if (! empty($gallery['event_date'])): ?>
								<span class="text-muted fs-8 d-block mb-2">
									<i class="ki-duotone ki-calendar fs-8 me-1"><span class="path1"></span><span class="path2"></span></i>
									<?= esc(date('d M Y', strtotime($gallery['event_date']))) ?>
								</span>
							<?php endif; ?>
							<?php if (! empty($gallery['description'])): ?>
								<p class="text-muted fs-7 mb-0"><?= nl2br(esc($gallery['description'])) ?></p>
							<?php endif; ?>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mt-10 d-flex justify-content-center"><?= $pager->links() ?></div>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>
