<?= $this->extend('backend/layouts/main') ?>
<?= $this->section('content') ?>

<div class="row g-6">
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-header">
                <h2 class="card-title fw-bold"><?= esc($aspiration['subject']) ?></h2>
                <?php if ((int) $aspiration['is_published'] === 1): ?>
                    <span class="badge badge-light-primary">Ditampilkan di landing page</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">Nama</dt>
                    <dd class="col-sm-9"><?= esc((int) $aspiration['is_anonymous'] === 1 ? 'Anonim' : ($aspiration['name'] ?: '-')) ?></dd>
                    <dt class="col-sm-3 text-muted">NIM</dt>
                    <dd class="col-sm-9"><?= esc($aspiration['nim'] ?: '-') ?></dd>
                    <dt class="col-sm-3 text-muted">Email</dt>
                    <dd class="col-sm-9"><?= esc($aspiration['email'] ?: '-') ?></dd>
                    <dt class="col-sm-3 text-muted">Telepon</dt>
                    <dd class="col-sm-9"><?= esc($aspiration['phone'] ?: '-') ?></dd>
                    <dt class="col-sm-3 text-muted">Kategori</dt>
                    <dd class="col-sm-9"><?= esc($categories[$aspiration['category']] ?? ucfirst($aspiration['category'])) ?></dd>
                    <dt class="col-sm-3 text-muted">Dikirim</dt>
                    <dd class="col-sm-9"><?= esc(date('d/m/Y H:i', strtotime($aspiration['created_at']))) ?></dd>
                </dl>
                <hr>
                <h4 class="fs-5 fw-bold mb-3">Pesan</h4>
                <div class="text-gray-700"><?= nl2br(esc($aspiration['message'])) ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-flush mb-6">
            <div class="card-body">
                <h3 class="fs-5 fw-bold mb-5">Kelola Status</h3>
                <form class="js-confirm-submit" data-confirm-title="Simpan status?" data-confirm-text="Status aspirasi akan diperbarui." method="post" action="<?= site_url('admin/aspirasi/' . $aspiration['id'] . '/status') ?>">
                    <?= csrf_field() ?>
                    <label for="status" class="form-label">Status penanganan</label>
                    <select id="status" name="status" class="form-select form-select-solid mb-4">
                        <?php foreach ($statuses as $value => $label): ?>
                            <option value="<?= esc($value, 'attr') ?>" <?= $aspiration['status'] === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                </form>
            </div>
        </div>

        <div class="card card-flush mb-6">
            <div class="card-body">
                <h3 class="fs-5 fw-bold mb-3">Tampilan Landing Page</h3>
                <?php if ((int) $aspiration['is_published'] === 1): ?>
                    <div class="alert alert-primary fs-7 mb-4">Aspirasi ini sedang ditampilkan sebagai suara mahasiswa.</div>
                    <form class="js-confirm-submit" data-confirm-title="Hentikan tampilan?" data-confirm-text="Aspirasi tidak lagi ditampilkan di landing page." method="post" action="<?= site_url('admin/aspirasi/' . $aspiration['id'] . '/publish') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-light-danger w-100">Hentikan Tampilan</button>
                    </form>
                <?php else: ?>
                    <form class="js-confirm-submit" data-confirm-title="Tampilkan aspirasi?" data-confirm-text="Aspirasi akan ditampilkan di landing page." method="post" action="<?= site_url('admin/aspirasi/' . $aspiration['id'] . '/publish') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="published_name" class="form-label">Nama yang Ditampilkan</label>
                            <input id="published_name" name="published_name" type="text" maxlength="150" class="form-control form-control-solid" value="<?= esc((int) $aspiration['is_anonymous'] === 1 ? 'Penyumbang Anonim' : ($aspiration['name'] ?: 'Mahasiswa')) ?>">
                        </div>
                        <div class="mb-4">
                            <label for="published_role" class="form-label">Peran yang Ditampilkan</label>
                            <input id="published_role" name="published_role" type="text" maxlength="150" class="form-control form-control-solid" value="Aspirasi <?= esc($categories[$aspiration['category']] ?? ucfirst($aspiration['category'])) ?>">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tampilkan di Landing Page</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <form class="js-confirm-submit" data-confirm-title="Hapus aspirasi?" data-confirm-text="Data aspirasi akan dihapus (soft delete)." data-confirm-button="Ya, hapus" method="post" action="<?= site_url('admin/aspirasi/' . $aspiration['id'] . '/delete') ?>">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-light-danger w-100">Hapus Aspirasi</button>
        </form>
    </div>
</div>

<a href="<?= site_url('admin/aspirasi') ?>" class="btn btn-light mt-6">Kembali ke daftar</a>

<?= $this->endSection() ?>
