<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/profil/password') ?>" class="btn btn-light-primary">Ganti Kata Sandi</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-6">
    <div class="col-lg-4">
        <div class="card card-flush">
            <div class="card-body p-8 text-center">
                <?php if (! empty($user['avatar'])): ?>
                    <img src="<?= esc(base_url($user['avatar']), 'attr') ?>" alt="Avatar" class="rounded-circle mb-5" style="width:110px;height:110px;object-fit:cover">
                <?php else: ?>
                    <div class="symbol symbol-100px symbol-circle bg-light-primary mb-5 mx-auto">
                        <span class="symbol-label fs-1 fw-bold text-primary"><?= esc(mb_substr($user['full_name'], 0, 1)) ?></span>
                    </div>
                <?php endif; ?>
                <h3 class="fs-4 fw-bold text-gray-900 mb-1"><?= esc($user['full_name']) ?></h3>
                <div class="text-muted fs-7 mb-3">@<?= esc($user['username']) ?></div>
                <span class="badge badge-light-primary"><?= esc($user['role_name'] ?: 'Tanpa Role') ?></span>
                <div class="text-muted fs-8 mt-5">Terakhir masuk: <?= ! empty($user['last_login_at']) ? esc(date('d/m/Y H:i', strtotime($user['last_login_at']))) : '-' ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-body p-7 p-lg-10">
                <h3 class="fs-4 fw-bold mb-6">Edit Profil</h3>
                <form method="post" action="<?= site_url('admin/profil') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('full_name', $user['full_name'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Username</label>
                            <input type="text" name="username" class="form-control form-control-solid" maxlength="100" required value="<?= esc(old('username', $user['username'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('email', $user['email'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" name="avatar" class="form-control form-control-solid" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, atau WEBP maksimal 2 MB.</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-8">Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
