<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<div class="row g-8">
		<div class="col-lg-7">
			<div class="card card-flush border border-gray-200 mb-6">
				<div class="card-body p-7 p-lg-9">
					<div class="d-flex flex-wrap gap-3 mb-4">
						<span class="badge badge-light-primary fs-8 fw-semibold">Rekrutmen</span>
						<?php if ($isOpen): ?>
							<span class="badge badge-light-success fs-8 fw-semibold">Pendaftaran Dibuka</span>
						<?php else: ?>
							<span class="badge badge-light-warning fs-8 fw-semibold">Pendaftaran Ditutup</span>
						<?php endif; ?>
					</div>

					<h1 class="fs-2x fw-bold text-gray-900 mb-4"><?= esc($period['title']) ?></h1>
					<p class="text-muted fs-7 mb-6">
						<i class="ki-duotone ki-calendar fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>
						<?= esc(date('d F Y', strtotime($period['start_date']))) ?> &ndash; <?= esc(date('d F Y', strtotime($period['end_date']))) ?>
					</p>

					<div class="article-content"><?= $description ?></div>

					<?php if (trim(strip_tags($requirements)) !== ''): ?>
						<div class="separator my-7"></div>
						<h2 class="fs-5 fw-bold text-gray-900 mb-3">Persyaratan</h2>
						<div class="article-content"><?= $requirements ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<aside class="col-lg-5">
			<div class="card card-flush border border-gray-200">
				<div class="card-body p-6 p-lg-7">
					<h2 class="fs-5 fw-bold text-gray-900 mb-2">Formulir Pendaftaran</h2>
					<p class="text-muted fs-8 mb-5"><?= (int) $applicationCount ?> orang sudah mendaftar<?= $period['quota'] !== null ? ' dari kuota ' . (int) $period['quota'] : '' ?>.</p>

					<?php if ($message = session()->getFlashdata('recruitment_success')): ?>
						<div class="alert alert-success fs-7"><?= esc($message) ?></div>
					<?php endif; ?>
					<?php if ($message = session()->getFlashdata('recruitment_error')): ?>
						<div class="alert alert-danger fs-7"><?= esc($message) ?></div>
					<?php endif; ?>
					<?php if ($errors = session()->getFlashdata('recruitment_errors')): ?>
						<div class="alert alert-danger fs-7">
							<?php foreach ($errors as $error): ?>
								<div><?= esc($error) ?></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ($isOpen): ?>
						<form method="post" action="<?= site_url('rekrutmen/' . $period['slug'] . '/daftar') ?>" enctype="multipart/form-data" class="d-flex flex-column gap-3">
							<?= csrf_field() ?>
							<div>
								<label for="app-name" class="form-label fs-8 fw-semibold required">Nama Lengkap</label>
								<input id="app-name" type="text" name="name" class="form-control form-control-sm form-control-solid" maxlength="150" required value="<?= esc(old('name')) ?>">
							</div>
							<div>
								<label for="app-nim" class="form-label fs-8 fw-semibold required">NIM</label>
								<input id="app-nim" type="text" name="nim" class="form-control form-control-sm form-control-solid" maxlength="30" required value="<?= esc(old('nim')) ?>">
							</div>
							<div>
								<label for="app-email" class="form-label fs-8 fw-semibold required">Email</label>
								<input id="app-email" type="email" name="email" class="form-control form-control-sm form-control-solid" maxlength="150" required value="<?= esc(old('email')) ?>">
							</div>
							<div>
								<label for="app-phone" class="form-label fs-8 fw-semibold required">Nomor WhatsApp</label>
								<input id="app-phone" type="tel" name="phone" class="form-control form-control-sm form-control-solid" maxlength="30" required value="<?= esc(old('phone')) ?>">
							</div>
							<div>
								<label for="app-prodi" class="form-label fs-8 fw-semibold">Program Studi</label>
								<input id="app-prodi" type="text" name="study_program" class="form-control form-control-sm form-control-solid" maxlength="100" value="<?= esc(old('study_program')) ?>">
							</div>
							<div>
								<label for="app-motivation" class="form-label fs-8 fw-semibold required">Motivasi Bergabung</label>
								<textarea id="app-motivation" name="motivation" class="form-control form-control-sm form-control-solid" rows="4" maxlength="3000" required><?= esc(old('motivation')) ?></textarea>
							</div>
							<div>
								<label for="app-cv" class="form-label fs-8 fw-semibold required">Berkas CV</label>
								<input id="app-cv" type="file" name="cv" class="form-control form-control-sm form-control-solid" accept=".pdf,.doc,.docx" required>
								<div class="form-text fs-8">PDF, DOC, atau DOCX maksimal 5 MB.</div>
							</div>
							<button type="submit" class="btn btn-primary btn-sm">Kirim Pendaftaran</button>
						</form>
					<?php else: ?>
						<div class="alert alert-warning fs-7 mb-0">Pendaftaran pada periode ini sudah ditutup.</div>
					<?php endif; ?>
				</div>
			</div>
		</aside>
	</div>
</div>
<?= $this->endSection() ?>
