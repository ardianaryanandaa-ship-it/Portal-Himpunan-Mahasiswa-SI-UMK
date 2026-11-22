<?= $this->include('frontend/partials/header', ['isLanding' => false]) ?>
<div class="d-flex flex-column flex-root">
	<?= $this->include('frontend/partials/navbar_page') ?>

	<section class="page-hero">
		<div class="container py-10 py-lg-15">
			<?php if (! empty($pageEyebrow)): ?>
				<span class="badge badge-light-primary fs-8 fw-bold text-uppercase mb-4 px-4 py-2"><?= esc($pageEyebrow) ?></span>
			<?php endif; ?>
			<h1 class="fs-2hx text-white fw-bold mb-3"><?= esc($pageTitle ?? $title ?? '') ?></h1>
			<?php if (! empty($pageDescription)): ?>
				<p class="fs-5 text-white opacity-75 mb-0 max-w-800px"><?= esc($pageDescription) ?></p>
			<?php endif; ?>
			<?php if (! empty($breadcrumb)): ?>
				<div class="d-flex flex-wrap align-items-center gap-2 mt-5 fs-7 text-white opacity-75">
					<a href="<?= site_url('/') ?>" class="text-white opacity-75 text-hover-primary">Beranda</a>
					<?php foreach ($breadcrumb as $label => $url): ?>
						<i class="ki-duotone ki-right fs-7"><span class="path1"></span><span class="path2"></span></i>
						<?php if ($url): ?>
							<a href="<?= esc($url, 'attr') ?>" class="text-white opacity-75 text-hover-primary"><?= esc($label) ?></a>
						<?php else: ?>
							<span><?= esc($label) ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<main class="py-10 py-lg-15">
		<?= $this->renderSection('content') ?>
	</main>

	<?= $this->include('frontend/partials/footer') ?>
