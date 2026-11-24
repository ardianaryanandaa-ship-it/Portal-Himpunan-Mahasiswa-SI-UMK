<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<?= $this->include('frontend/partials/about-content') ?>

	<div class="card border-0 mt-12" style="background:linear-gradient(120deg,#12345c,#1b4f7a)">
		<div class="card-body p-8 p-lg-12 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-6">
			<div class="text-white">
				<h2 class="fs-2x fw-bold text-white mb-2">Ingin mengenal kami lebih dekat?</h2>
				<p class="fs-6 opacity-75 mb-0">Lihat struktur pengurus, program kerja, dan agenda kegiatan <?= esc($organization->name) ?>.</p>
			</div>
			<div class="d-flex flex-wrap gap-3">
				<a href="<?= site_url('struktur') ?>" class="btn btn-light">Struktur Pengurus</a>
				<a href="<?= site_url('proker') ?>" class="btn btn-outline btn-outline-dashed btn-outline-light text-white">Program Kerja</a>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
