<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?php if ($grouped === [] || array_sum(array_map('count', $grouped)) === 0): ?>
		<div class="empty-state">
			<i class="ki-duotone ki-people fs-3x text-muted mb-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
			<p class="mb-0">Data pengurus belum tersedia.</p>
		</div>
	<?php else: ?>
		<?php if (! empty($grouped[0])): ?>
			<section class="structure-group">
				<div class="text-center mb-8">
					<span class="badge badge-light-primary fs-8 fw-bold text-uppercase mb-3 px-4 py-2">Badan Pengurus Harian</span>
					<h2 class="page-section-title mb-2">Pengurus Inti</h2>
					<p class="text-muted fs-7 mb-0">Periode kepengurusan <?= esc($organization->period) ?></p>
				</div>
				<div class="row g-6 justify-content-center">
					<?php foreach ($grouped[0] as $member): ?>
						<?= $this->include('frontend/pages/_member_card', ['member' => $member]) ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php foreach ($divisions as $division): ?>
			<?php $members = $grouped[(int) $division['id']] ?? []; ?>
			<?php if ($members === []) { continue; } ?>
			<section class="structure-group">
				<div class="text-center mb-8">
					<span class="badge badge-light-primary fs-8 fw-bold text-uppercase mb-3 px-4 py-2">Divisi</span>
					<h2 class="page-section-title mb-2"><?= esc($division['name']) ?></h2>
					<?php if (! empty($division['description'])): ?>
						<p class="text-muted fs-7 mb-0 max-w-700px mx-auto"><?= nl2br(esc($division['description'])) ?></p>
					<?php endif; ?>
				</div>
				<div class="row g-6 justify-content-center">
					<?php foreach ($members as $member): ?>
						<?= $this->include('frontend/pages/_member_card', ['member' => $member]) ?>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<?= $this->endSection() ?>
