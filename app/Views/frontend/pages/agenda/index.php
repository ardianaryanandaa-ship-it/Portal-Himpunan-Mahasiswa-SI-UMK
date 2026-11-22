<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?php if ($events === []): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-calendar fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span></i>
			<p class="mb-0">Belum ada agenda kegiatan yang dipublikasikan.</p>
		</div>
	<?php else: ?>
		<div class="row g-8">
			<?php foreach ($events as $event): ?>
				<?php
				$poster = trim((string) ($event['poster'] ?? ''));
				$imageUrl = $poster !== '' ? base_url(ltrim($poster, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
				$count = (int) ($counts[(int) $event['id']] ?? 0);
				$deadlinePassed = ! empty($event['registration_deadline']) && strtotime($event['registration_deadline']) < time();
				$isFull = $event['quota'] !== null && $count >= (int) $event['quota'];
				$isPast = strtotime($event['start_at']) < time();
				$isOpen = ! $deadlinePassed && ! $isFull && ! $isPast;
				?>
				<div class="col-md-6 col-lg-4">
					<article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
						<a href="<?= site_url('agenda/' . $event['slug']) ?>">
							<img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($event['title'], 'attr') ?>" class="w-100 h-200px object-fit-cover">
						</a>
						<div class="card-body p-6 d-flex flex-column">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<?php if ($isOpen): ?>
									<span class="badge badge-light-success fs-8 fw-semibold">Pendaftaran Dibuka</span>
								<?php elseif ($isPast): ?>
									<span class="badge badge-light-dark fs-8 fw-semibold">Selesai</span>
								<?php else: ?>
									<span class="badge badge-light-warning fs-8 fw-semibold">Pendaftaran Ditutup</span>
								<?php endif; ?>
								<span class="text-muted fs-8"><?= esc(date('d M Y', strtotime($event['start_at']))) ?></span>
							</div>
							<h3 class="fs-5 fw-bold text-gray-900 mb-3">
								<a href="<?= site_url('agenda/' . $event['slug']) ?>" class="text-gray-900 text-hover-primary"><?= esc($event['title']) ?></a>
							</h3>
							<div class="d-flex flex-column gap-2 text-muted fs-8 mb-4">
								<span>
									<i class="ki-duotone ki-geolocation fs-8 me-1"><span class="path1"></span><span class="path2"></span></i>
									<?= esc($event['location']) ?>
								</span>
								<span>
									<i class="ki-duotone ki-time fs-8 me-1"><span class="path1"></span><span class="path2"></span></i>
									<?= esc(date('H:i', strtotime($event['start_at']))) ?> WIB
								</span>
								<span>
									<i class="ki-duotone ki-people fs-8 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
									<?= $count ?> peserta<?= $event['quota'] !== null ? ' / ' . (int) $event['quota'] . ' kuota' : '' ?>
								</span>
							</div>
							<a href="<?= site_url('agenda/' . $event['slug']) ?>" class="link-primary fw-semibold fs-7 mt-auto d-inline-flex align-items-center">
								Lihat Detail
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
