<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<?php $isEdit = $gallery !== null; ?>
<div class="row g-6">
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-header border-0 pt-6">
                <h2 class="card-title fw-bold"><?= $isEdit ? 'Informasi Galeri' : 'Tambah Galeri' ?></h2>
            </div>
            <div class="card-body pt-0">
                <form action="<?= site_url($isEdit ? 'admin/galeri/' . $gallery['id'] . '/update' : 'admin/galeri/simpan') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-6">
                        <label class="form-label required">Judul</label>
                        <input type="text" name="title" class="form-control" maxlength="150" required value="<?= old('title', $gallery['title'] ?? '') ?>">
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" maxlength="5000"><?= old('description', $gallery['description'] ?? '') ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label">Tanggal Kegiatan</label>
                            <input type="date" name="event_date" class="form-control" value="<?= old('event_date', $gallery['event_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-6">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" min="0" value="<?= old('sort_order', $gallery['sort_order'] ?? 0) ?>">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Sampul</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <?php if ($isEdit && ! empty($gallery['cover_image'])): ?>
                            <img src="<?= base_url($gallery['cover_image']) ?>" alt="" class="mt-4 rounded w-200px h-150px object-fit-cover">
                        <?php endif; ?>
                    </div>
                    <div class="form-check form-switch mb-6">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="publish-gallery" <?= old('is_published', $gallery['is_published'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="publish-gallery">Publikasikan pada landing page</label>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Galeri' ?></button>
                        <a href="<?= site_url('admin/galeri') ?>" class="btn btn-light">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
