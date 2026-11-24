<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $member !== null; ?>
<?php $action = $isEdit ? site_url('admin/divisi/anggota/' . $member['id'] . '/edit') : site_url('admin/divisi/anggota/tambah'); ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-flush">
            <div class="card-body p-7 p-lg-10">
                <form method="post" action="<?= $action ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Divisi</label>
                            <select name="division_id" class="form-select form-select-solid" required>
                                <option value="">Pilih divisi</option>
                                <?php foreach ($divisions as $division): ?>
                                    <option value="<?= (int) $division['id'] ?>" <?= (int) old('division_id', $selectedDivision) === (int) $division['id'] ? 'selected' : '' ?>><?= esc($division['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Jabatan</label>
                            <input type="text" name="position" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('position', $member['position'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold required">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('name', $member['name'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Periode</label>
                            <input type="text" name="period" class="form-control form-control-solid" maxlength="50" value="<?= esc(old('period', $member['period'] ?? config('Organization')->period)) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto</label>
                            <input type="file" name="photo" class="form-control form-control-solid" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, WEBP maks 2 MB.</div>
                            <?php if (! empty($member['photo'])): ?>
                                <img src="<?= esc(base_url($member['photo']), 'attr') ?>" alt="" class="rounded mt-3" style="width:80px;height:80px;object-fit:cover">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan</label>
                            <input type="number" name="sort_order" class="form-control form-control-solid" min="0" value="<?= esc(old('sort_order', $member['sort_order'] ?? 0)) ?>">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?= (int) old('is_active', $member['is_active'] ?? 1) === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="is_active">Tampilkan di struktur organisasi</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-8">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Anggota' ?></button>
                        <a href="<?= site_url('admin/divisi/anggota') ?>" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
