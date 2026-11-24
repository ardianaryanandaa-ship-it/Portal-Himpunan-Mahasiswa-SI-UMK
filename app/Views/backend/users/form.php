<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $user !== null; ?>
<?php $action = $isEdit ? site_url('admin/pengguna/' . $user['id'] . '/edit') : site_url('admin/pengguna/tambah'); ?>

<?= $this->section('content') ?>
<div class="row g-6">
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-body p-7 p-lg-10">
                <form method="post" action="<?= $action ?>">
                    <?= csrf_field() ?>
                    <div class="row g-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Role</label>
                            <select name="role_id" class="form-select form-select-solid" required>
                                <option value="">Pilih role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= esc((string) $role['id'], 'attr') ?>" <?= (string) old('role_id', $user['role_id'] ?? '') === (string) $role['id'] ? 'selected' : '' ?>>
                                        <?= esc($role['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Username</label>
                            <input type="text" name="username" class="form-control form-control-solid" maxlength="100" required value="<?= esc(old('username', $user['username'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('email', $user['email'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold <?= $isEdit ? '' : 'required' ?>"><?= $isEdit ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi' ?></label>
                            <input type="password" name="password" class="form-control form-control-solid" minlength="8" <?= $isEdit ? '' : 'required' ?> autocomplete="new-password">
                            <?php if ($isEdit): ?><div class="form-text">Kosongkan jika tidak ingin mengubah kata sandi.</div><?php endif; ?>
                        </div>
                        <?php if (! $isEdit): ?>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold required">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirm" class="form-control form-control-solid" minlength="8" required autocomplete="new-password">
                            </div>
                        <?php endif; ?>
                        <?php if ($isEdit): ?>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?= (int) ($user['is_active'] ?? 1) === 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-semibold" for="is_active">Akun aktif dan dapat masuk</label>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3 mt-8">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna' ?></button>
                        <a href="<?= site_url('admin/pengguna') ?>" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($isEdit): ?>
        <div class="col-lg-4">
            <div class="card card-flush">
                <div class="card-body p-7">
                    <h3 class="fs-5 fw-bold mb-2">Reset Kata Sandi</h3>
                    <p class="text-muted fs-7 mb-5">Gunakan formulir ini untuk mengganti kata sandi pengguna tanpa perlu mengetahui kata sandi lama.</p>
                    <form method="post" action="<?= site_url('admin/pengguna/' . $user['id'] . '/reset-password') ?>" class="js-confirm-submit" data-confirm-title="Reset kata sandi?" data-confirm-text="Kata sandi pengguna akan diganti.">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kata Sandi Baru</label>
                            <input type="password" name="new_password" class="form-control form-control-solid" minlength="8" required autocomplete="new-password">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi</label>
                            <input type="password" name="new_password_confirm" class="form-control form-control-solid" minlength="8" required autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Reset Kata Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
