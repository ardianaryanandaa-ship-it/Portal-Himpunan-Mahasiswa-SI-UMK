<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $division !== null; ?>
<?php $action = $isEdit ? site_url('admin/divisi/' . $division['id'] . '/edit') : site_url('admin/divisi/tambah'); ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-flush">
            <div class="card-body p-7 p-lg-10">
                <form method="post" action="<?= $action ?>">
                    <?= csrf_field() ?>
                    <div class="mb-5">
                        <label class="form-label fw-semibold required">Nama Divisi</label>
                        <input type="text" name="name" class="form-control form-control-solid" maxlength="150" required value="<?= esc(old('name', $division['name'] ?? '')) ?>">
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control form-control-solid" rows="4"><?= esc(old('description', $division['description'] ?? '')) ?></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control form-control-solid" min="0" value="<?= esc(old('sort_order', $division['sort_order'] ?? 0)) ?>">
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Divisi' ?></button>
                        <a href="<?= site_url('admin/divisi') ?>" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
