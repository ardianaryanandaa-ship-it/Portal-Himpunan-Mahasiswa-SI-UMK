<?= $this->extend('frontend/layouts/page') ?>

<?= $this->section('content') ?>
<div class="container">
	<div class="row g-8">
		<div class="col-lg-8">
			<article class="card card-flush border border-gray-200">
				<?php if (! empty($event['poster'])): ?>
					<img src="<?= esc(base_url(ltrim($event['poster'], '/')), 'attr') ?>" alt="<?= esc($event['title'], 'attr') ?>" class="w-100" style="max-height:420px;object-fit:cover">
				<?php endif; ?>
				<div class="card-body p-7 p-lg-10">
					<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
						<span class="badge badge-light-primary fs-8 fw-semibold">Agenda</span>
						<span class="text-muted fs-7">
							<i class="ki-duotone ki-calendar fs-7 me-1"><span class="path1"></span><span class="path2"></span></i>
							<?= esc(date('d F Y', strtotime($event['start_at']))) ?>
						</span>
					</div>
					<h1 class="fs-2x fw-bold text-gray-900 mb-5"><?= esc($event['title']) ?></h1>

					<div class="row g-4 mb-7">
						<div class="col-md-6">
							<div class="bg-light rounded p-4">
								<div class="text-muted fs-8 mb-1">Waktu</div>
								<div class="fw-semibold text-gray-900 fs-7">
									<?= esc(date('d/m/Y H:i', strtotime($event['start_at']))) ?>
									<?php if (! empty($event['end_at'])): ?>
										&ndash; <?= esc(date('d/m/Y H:i', strtotime($event['end_at']))) ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="bg-light rounded p-4">
								<div class="text-muted fs-8 mb-1">Lokasi</div>
								<div class="fw-semibold text-gray-900 fs-7"><?= esc($event['location']) ?></div>
							</div>
						</div>
					</div>

					<div class="article-content"><?= $content ?></div>
				</div>
			</article>
		</div>

		<aside class="col-lg-4">
			<div class="card card-flush border border-gray-200 mb-6">
				<div class="card-body p-6">
					<h3 class="fs-5 fw-bold text-gray-900 mb-4">Pendaftaran Peserta</h3>

					<div class="d-flex justify-content-between fs-7 mb-2">
						<span class="text-muted">Terdaftar</span>
						<strong class="text-gray-900"><?= (int) $registrationCount ?><?= $event['quota'] !== null ? ' / ' . (int) $event['quota'] : '' ?></strong>
					</div>
					<?php if ($event['quota'] !== null): ?>
						<?php $percent = min(100, (int) round($registrationCount / max(1, (int) $event['quota']) * 100)); ?>
						<div class="progress h-8px mb-4">
							<div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<?php endif; ?>

					<?php if (! empty($event['registration_deadline'])): ?>
						<div class="text-muted fs-8 mb-4">
							Batas pendaftaran: <?= esc(date('d/m/Y H:i', strtotime($event['registration_deadline']))) ?> WIB
						</div>
					<?php endif; ?>

					<?php if ($message = session()->getFlashdata('agenda_success')): ?>
						<div class="alert alert-success fs-7"><?= esc($message) ?></div>
					<?php endif; ?>
					<?php if ($message = session()->getFlashdata('agenda_error')): ?>
						<div class="alert alert-danger fs-7"><?= esc($message) ?></div>
					<?php endif; ?>
					<?php if ($errors = session()->getFlashdata('agenda_errors')): ?>
						<div class="alert alert-danger fs-7">
							<?php foreach ($errors as $error): ?>
								<div><?= esc($error) ?></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ($registrationOpen): ?>
						<form method="post" action="<?= site_url('agenda/' . $event['slug'] . '/daftar') ?>" class="d-flex flex-column gap-3">
							<?= csrf_field() ?>
							<div>
								<label for="reg-name" class="form-label fs-8 fw-semibold required">Nama Lengkap</label>
								<input id="reg-name" type="text" name="name" class="form-control form-control-sm form-control-solid" maxlength="150" required value="<?= esc(old('name')) ?>">
							</div>
							<div>
								<label for="reg-nim" class="form-label fs-8 fw-semibold required">NIM</label>
								<input id="reg-nim" type="text" name="nim" class="form-control form-control-sm form-control-solid" maxlength="30" required value="<?= esc(old('nim')) ?>">
							</div>
							<div>
								<label for="reg-email" class="form-label fs-8 fw-semibold required">Email</label>
								<input id="reg-email" type="email" name="email" class="form-control form-control-sm form-control-solid" maxlength="150" required value="<?= esc(old('email')) ?>">
							</div>
							<div>
								<label for="reg-phone" class="form-label fs-8 fw-semibold required">Nomor WhatsApp</label>
								<input id="reg-phone" type="tel" name="phone" class="form-control form-control-sm form-control-solid" maxlength="30" required value="<?= esc(old('phone')) ?>">
							</div>
							<div>
								<label for="reg-prodi" class="form-label fs-8 fw-semibold">Program Studi</label>
								<input id="reg-prodi" type="text" name="study_program" class="form-control form-control-sm form-control-solid" maxlength="100" value="<?= esc(old('study_program')) ?>">
							</div>
							<div>
								<label for="reg-notes" class="form-label fs-8 fw-semibold">Catatan</label>
								<textarea id="reg-notes" name="notes" class="form-control form-control-sm form-control-solid" rows="2" maxlength="1000"><?= esc(old('notes')) ?></textarea>
							</div>
							<button type="submit" class="btn btn-primary btn-sm">Daftar Sekarang</button>
						</form>
					<?php else: ?>
						<div class="alert alert-warning fs-7 mb-0">Pendaftaran event ini sudah ditutup.</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ($related !== []): ?>
				<div class="card card-flush border border-gray-200">
					<div class="card-header pt-6">
						<h3 class="card-title fw-bold fs-6">Agenda Lainnya</h3>
					</div>
					<div class="card-body pt-2">
						<?php foreach ($related as $item): ?>
							<a href="<?= site_url('agenda/' . $item['slug']) ?>" class="d-flex gap-3 py-3 border-bottom border-gray-200 text-decoration-none">
								<span class="symbol symbol-40px">
									<span class="symbol-label bg-light-primary">
										<i class="ki-duotone ki-calendar fs-4 text-primary"><span class="path1"></span><span class="path2"></span></i>
									</span>
								</span>
								<span class="d-flex flex-column">
									<strong class="text-gray-900 fs-7"><?= esc($item['title']) ?></strong>
									<small class="text-muted fs-8 mt-1"><?= esc(date('d M Y', strtotime($item['start_at']))) ?></small>
								</span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</aside>
	</div>
</div>
<?= $this->endSection() ?>
