<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?php if ($periods === []): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-people fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
			<p class="mb-0">Belum ada periode rekrutmen yang dibuka.</p>
		</div>
	<?php else: ?>
		<div class="row g-8">
			<?php foreach ($periods as $period): ?>
				<?php
				$today = date('Y-m-d');
				$count = (int) ($counts[(int) $period['id']] ?? 0);
				$isFull = $period['quota'] !== null && $count >= (int) $period['quota'];
				$isOpen = $today >= $period['start_date'] && $today <= $period['end_date'] && ! $isFull;
				?>
				<div class="col-md-6">
					<article class="card card-flush h-100 border border-gray-200">
						<div class="card-body p-7">
							<div class="d-flex justify-content-between align-items-start gap-3 mb-4">
								<h3 class="fs-4 fw-bold text-gray-900 mb-0">
									<a href="<?= site_url('rekrutmen/' . $period['slug']) ?>" class="text-gray-900 text-hover-primary"><?= esc($period['title']) ?></a>
								</h3>
								<?php if ($isOpen): ?>
									<span class="badge badge-light-success fs-8 fw-semibold text-nowrap">Dibuka</span>
								<?php else: ?>
									<span class="badge badge-light-warning fs-8 fw-semibold text-nowrap">Ditutup</span>
								<?php endif; ?>
							</div>

							<div class="d-flex flex-column gap-2 text-muted fs-8 mb-5">
								<span>
									<i class="ki-duotone ki-calendar fs-8 me-1"><span class="path1"></span><span class="path2"></span></i>
									<?= esc(date('d M Y', strtotime($period['start_date']))) ?> &ndash; <?= esc(date('d M Y', strtotime($period['end_date']))) ?>
								</span>
								<span>
									<i class="ki-duotone ki-people fs-8 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
									<?= $count ?> pendaftar<?= $period['quota'] !== null ? ' / ' . (int) $period['quota'] . ' kuota' : '' ?>
								</span>
							</div>

							<a href="<?= site_url('rekrutmen/' . $period['slug']) ?>" class="btn btn-sm btn-primary">Lihat &amp; Daftar</a>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mt-10 d-flex justify-content-center"><?= $pager->links() ?></div>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>
