 <?= $this->include('frontend/partials/header') ?>
<!--begin::Main-->
<!-- Layout utama menyatukan header, navbar, hero, konten section, dan footer halaman. -->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
	<?= $this->include('frontend/partials/navbar') ?>

	<!--begin::Header Section-->
	<div class="mb-0" id="home">
		<!--begin::Wrapper-->
		<div class="hero-photo-bg">
			<?= $this->include('frontend/sections/beranda') ?>
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Header Section-->

	<!--begin::Content Section-->
	<?= $this->renderSection('content') ?>
	<!--end::Content Section-->

	<?= $this->include('frontend/partials/footer') ?>
