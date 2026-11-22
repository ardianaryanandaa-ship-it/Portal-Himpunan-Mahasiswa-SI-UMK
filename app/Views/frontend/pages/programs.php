<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?php if ((int) $total === 0): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-calendar-tick fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
			<p class="mb-0">Belum ada program kerja yang dipublikasikan.</p>
		</div>
	<?php else: ?>
		<?php
		$sections = [
			'ongoing' => ['label' => 'Sedang Berjalan', 'badge' => 'primary', 'empty' => 'Tidak ada program yang sedang berjalan.'],
			'planned' => ['label' => 'Direncanakan', 'badge' => 'warning', 'empty' => 'Belum ada program yang direncanakan.'],
			'done'    => ['label' => 'Selesai', 'badge' => 'success', 'empty' => 'Belum ada program yang selesai.'],
		];
		?>
		<?php foreach ($sections as $status => $section): ?>
			<section class="<?= $status !== 'ongoing' ? 'mt-12' : '' ?>">
				<div class="d-flex align-items-center gap-3 mb-6">
					<h2 class="page-section-title mb-0"><?= esc($section['label']) ?></h2>
					<span class="badge badge-light-<?= esc($section['badge']) ?> fs-8 fw-semibold"><?= count($grouped[$status]) ?> program</span>
				</div>

				<?php if ($grouped[$status] === []): ?>
					<p class="text-muted fs-7 mb-0"><?= esc($section['empty']) ?></p>
				<?php else: ?>
					<div class="row g-6">
						<?php foreach ($grouped[$status] as $program): ?>
							<div class="col-md-6">
								<div class="card card-flush h-100 border border-gray-200">
									<div class="card-body p-6">
										<div class="d-flex justify-content-between align-items-start gap-3 mb-3">
											<h3 class="fs-5 fw-bold text-gray-900 mb-0"><?= esc($program['title']) ?></h3>
											<span class="badge badge-light-<?= esc($section['badge']) ?> fs-8 fw-semibold text-nowrap"><?= esc($section['label']) ?></span>
										</div>
										<div class="d-flex flex-wrap gap-4 text-muted fs-8 mb-3">
											<span>
												<i class="ki-duotone ki-hierarchy-2 fs-8 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
												<?= esc($program['division_name'] ?: 'Umum') ?>
											</span>
											<?php if (! empty($program['target_date'])): ?>
												<span>
													<i class="ki-duotone ki-calendar fs-8 me-1"><span class="path1"></span><span class="path2"></span></i>
													<?= esc(date('d M Y', strtotime($program['target_date']))) ?>
												</span>
											<?php endif; ?>
										</div>
										<?php if (! empty($program['description'])): ?>
											<p class="text-muted fs-7 mb-0"><?= nl2br(esc($program['description'])) ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>
