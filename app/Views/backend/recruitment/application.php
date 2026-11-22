<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar') ?>" class="btn btn-light">Kembali ke Daftar</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-6">
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header pt-6">
                <h2 class="card-title fw-bold">Data Pendaftar</h2>
                <?php if ($application['status'] === 'accepted'): ?>
                    <span class="badge badge-light-success fs-7 px-4 py-2">Diterima</span>
                <?php elseif ($application['status'] === 'rejected'): ?>
                    <span class="badge badge-light-danger fs-7 px-4 py-2">Ditolak</span>
                <?php else: ?>
                    <span class="badge badge-light-warning fs-7 px-4 py-2">Menunggu</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row g-5 mb-5">
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">Nama</div>
                        <div class="fw-bold text-gray-900"><?= esc($application['name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">NIM</div>
                        <div class="fw-bold text-gray-900"><?= esc($application['nim']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">Email</div>
                        <div class="fw-semibold"><?= esc($application['email']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">Telepon</div>
                        <div class="fw-semibold"><?= esc($application['phone']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">Program Studi</div>
                        <div class="fw-semibold"><?= esc($application['study_program'] ?: '-') ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted fs-8 mb-1">Waktu Daftar</div>
                        <div class="fw-semibold"><?= esc(date('d/m/Y H:i', strtotime($application['created_at']))) ?></div>
                    </div>
                </div>

                <div class="separator my-6"></div>

                <h3 class="fs-6 fw-bold text-gray-900 mb-2">Motivasi</h3>
                <p class="text-muted fs-7"><?= nl2br(esc($application['motivation'] ?: '-')) ?></p>

                <?php if (! empty($application['cv'])): ?>
                    <a href="<?= esc(base_url($application['cv']), 'attr') ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success mt-3">Buka Berkas CV</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-flush">
            <div class="card-header pt-6">
                <h3 class="card-title fw-bold">Ubah Status</h3>
            </div>
            <div class="card-body">
                <form method="post" action="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar/' . $application['id'] . '/status') ?>">
                    <?= csrf_field() ?>
                    <label class="form-label fw-semibold">Status Seleksi</label>
                    <select name="status" class="form-select form-select-solid mb-4">
                        <?php foreach ($statuses as $value => $label): ?>
                            <option value="<?= esc($value, 'attr') ?>" <?= $application['status'] === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                </form>
            </div>
        </div>

        <div class="card card-flush mt-6">
            <div class="card-body">
                <div class="text-muted fs-8 mb-1">Periode Rekrutmen</div>
                <div class="fw-bold text-gray-900"><?= esc($period['title']) ?></div>
                <div class="text-muted fs-8 mt-2">
                    <?= esc(date('d/m/Y', strtotime($period['start_date']))) ?> &ndash; <?= esc(date('d/m/Y', strtotime($period['end_date']))) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
