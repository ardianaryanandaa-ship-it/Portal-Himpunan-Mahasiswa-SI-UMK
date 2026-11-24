<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-flush">
            <div class="card-body p-7 p-lg-10">
                <h3 class="fs-4 fw-bold mb-2">Ganti Kata Sandi</h3>
                <p class="text-muted fs-7 mb-7">Gunakan kata sandi yang kuat dan tidak dipakai di layanan lain.</p>
                <form method="post" action="<?= site_url('admin/profil/password') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-5">
                        <label class="form-label fw-semibold required">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" class="form-control form-control-solid" required autocomplete="current-password">
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-semibold required">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="form-control form-control-solid" minlength="8" required autocomplete="new-password">
                    </div>
                    <div class="mb-6">
                        <label class="form-label fw-semibold required">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirm" class="form-control form-control-solid" minlength="8" required autocomplete="new-password">
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Simpan Kata Sandi</button>
                        <a href="<?= site_url('admin/profil') ?>" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
