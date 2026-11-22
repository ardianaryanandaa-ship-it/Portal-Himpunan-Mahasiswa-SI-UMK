<?= $this->extend('backend/layouts/auth_metronic') ?>

<?= $this->section('content') ?>
    <div class="text-start mb-10">
        <h1 class="text-gray-900 mb-3">Masuk ke Backend</h1>
        <div class="text-gray-500 fw-semibold fs-6">Gunakan username atau email dan kata sandi akun Anda.</div>
    </div>

    <?php if ($message = session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert"><?= esc($message) ?></div>
    <?php endif; ?>

    <?php if ($validationErrors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($validationErrors as $validationError): ?>
                <div><?= esc($validationError) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($message = session()->getFlashdata('message')): ?>
        <div class="alert alert-success" role="status"><?= esc($message) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>

        <div class="fv-row mb-8">
            <label for="identifier" class="form-label fs-6 fw-bold text-gray-900">Username atau email</label>
            <input
                id="identifier"
                name="identifier"
                type="text"
                class="form-control form-control-lg form-control-solid"
                value="<?= esc($identifier ?? '') ?>"
                required
                maxlength="150"
                autocomplete="username"
                autocapitalize="none"
                autofocus
            >
        </div>

        <div class="fv-row mb-8">
            <label for="password" class="form-label fs-6 fw-bold text-gray-900">Kata sandi</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control form-control-lg form-control-solid"
                required
                maxlength="255"
                autocomplete="current-password"
            >
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-100">
            <span class="indicator-label">Masuk</span>
        </button>
    </form>
<?= $this->endSection() ?>
