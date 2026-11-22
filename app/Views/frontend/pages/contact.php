<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<div class="row g-8">
		<div class="col-lg-5">
			<div class="card h-100 border border-gray-200">
				<div class="card-body p-7 p-lg-9">
					<h2 class="page-section-title mb-6">Sekretariat</h2>

					<div class="d-flex gap-4 mb-5">
						<i class="ki-duotone ki-geolocation fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
						<div>
							<strong class="d-block text-gray-900 mb-1">Alamat</strong>
							<span class="text-muted fs-7"><?= nl2br(esc($organization->address)) ?></span>
						</div>
					</div>

					<div class="d-flex gap-4 mb-5">
						<i class="ki-duotone ki-sms fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
						<div>
							<strong class="d-block text-gray-900 mb-1">Email</strong>
							<a href="mailto:<?= esc($organization->email, 'attr') ?>" class="text-muted fs-7 text-hover-primary"><?= esc($organization->email) ?></a>
						</div>
					</div>

					<div class="d-flex gap-4 mb-5">
						<i class="ki-duotone ki-whatsapp fs-2x text-success"><span class="path1"></span><span class="path2"></span></i>
						<div>
							<strong class="d-block text-gray-900 mb-1">WhatsApp</strong>
							<a href="<?= esc($organization->whatsappUrl(), 'attr') ?>" target="_blank" rel="noopener" class="text-muted fs-7 text-hover-primary"><?= esc('+' . $organization->whatsappNumber()) ?></a>
						</div>
					</div>

					<div class="d-flex gap-4">
						<i class="ki-duotone ki-clock fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
						<div>
							<strong class="d-block text-gray-900 mb-1">Jam Layanan</strong>
							<span class="text-muted fs-7">Senin - Jumat, 08.00 - 16.00 WIB</span>
						</div>
					</div>

					<div class="separator my-7"></div>

					<?php if ($organization->socialLinks() !== []): ?>
						<strong class="d-block text-gray-900 mb-3">Media Sosial</strong>
						<div class="d-flex flex-wrap gap-2">
							<?php foreach ($organization->socialLinks() as $label => $url): ?>
								<a href="<?= esc($url, 'attr') ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light"><?= esc($label) ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<div class="d-grid gap-2 mt-7">
						<a href="<?= esc($organization->whatsappUrl(), 'attr') ?>" target="_blank" rel="noopener" class="btn btn-success">Hubungi via WhatsApp</a>
						<a href="<?= site_url('/') ?>#aspirations" class="btn btn-light-primary">Kirim Aspirasi</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-7">
			<div class="card h-100 border border-gray-200 overflow-hidden">
				<iframe
					src="https://www.google.com/maps?q=<?= rawurlencode($organization->address) ?>&amp;output=embed"
					title="Peta lokasi <?= esc($organization->name, 'attr') ?>"
					class="w-100 border-0"
					style="min-height:420px;height:100%"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
