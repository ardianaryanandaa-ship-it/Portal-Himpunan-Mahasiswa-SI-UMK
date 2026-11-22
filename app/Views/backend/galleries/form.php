<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $gallery !== null; ?>
<?php $action = $isEdit ? site_url('admin/galeri/' . $gallery['id'] . '/edit') : site_url('admin/galeri/tambah'); ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-body p-7 p-lg-10">
        <form method="post" action="<?= $action ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-5">
                <div class="col-lg-7">
                    <label class="form-label fw-semibold required">Judul</label>
                    <input type="text" name="title" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('title', $gallery['title'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control form-control-solid mb-5" rows="4"><?= esc(old('description', $gallery['description'] ?? '')) ?></textarea>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Kegiatan</label>
                            <input type="date" name="event_date" class="form-control form-control-solid" value="<?= esc(old('event_date', $gallery['event_date'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan</label>
                            <input type="number" name="sort_order" class="form-control form-control-solid" min="0" value="<?= esc(old('sort_order', $gallery['sort_order'] ?? 0)) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card bg-light border-0">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold <?= $isEdit ? '' : 'required' ?>">Gambar</label>
                            <input type="file" name="image" class="form-control form-control-solid" accept="image/jpeg,image/png,image/webp" <?= $isEdit ? '' : 'required' ?>>
                            <div class="form-text mb-3">JPG, PNG, WEBP maks 2 MB.</div>
                            <?php if (! empty($gallery['image'])): ?>
                                <img src="<?= esc(base_url($gallery['image']), 'attr') ?>" alt="" class="w-100 rounded" style="height:180px;object-fit:cover">
                            <?php endif; ?>
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?= (int) old('is_active', $gallery['is_active'] ?? 1) === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="is_active">Tampilkan di website</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Galeri' ?></button>
                        <a href="<?= site_url('admin/galeri') ?>" class="btn btn-light">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
