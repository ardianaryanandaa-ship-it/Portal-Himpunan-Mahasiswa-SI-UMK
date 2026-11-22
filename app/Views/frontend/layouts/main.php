 <?= $this->include('frontend/partials/header') ?>
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
	<!--begin::Header Section-->
	<div class="mb-0" id="home">
		<!--begin::Wrapper-->
		<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg">
			<?= $this->include('frontend/partials/navbar') ?>
			<?= $this->include('frontend/sections/beranda') ?>
		</div>
		<!--end::Wrapper-->
		<!--begin::Curve bottom-->
		<div class="landing-curve landing-dark-color mb-10 mb-lg-20">
			<svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
			</svg>
		</div>
		<!--end::Curve bottom-->
	</div>
	<!--end::Header Section-->

	<!--begin::Content Section-->
	<?= $this->renderSection('content') ?>
	<!--end::Content Section-->

	<?= $this->include('frontend/partials/footer') ?>
