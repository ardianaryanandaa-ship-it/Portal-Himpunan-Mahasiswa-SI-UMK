<?php
$photo = trim((string) ($member['photo'] ?? ''));
?>
<div class="col-6 col-md-4 col-lg-3">
	<div class="card card-flush h-100 border border-gray-200 text-center hover-elevate-up">
		<div class="card-body p-6">
			<?php if ($photo !== ''): ?>
				<img src="<?= esc(base_url(ltrim($photo, '/')), 'attr') ?>" alt="<?= esc($member['name'], 'attr') ?>" class="structure-photo mb-4">
			<?php else: ?>
				<div class="structure-initial mx-auto mb-4"><?= esc(mb_strtoupper(mb_substr($member['name'], 0, 1))) ?></div>
			<?php endif; ?>
			<h3 class="fs-6 fw-bold text-gray-900 mb-1"><?= esc($member['name']) ?></h3>
			<p class="text-primary fs-7 fw-semibold mb-2"><?= esc($member['position']) ?></p>
			<?php if (! empty($member['period'])): ?>
				<span class="text-muted fs-8"><?= esc($member['period']) ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
