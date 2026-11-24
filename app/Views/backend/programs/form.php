<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $program !== null; ?>
<?php $action = $isEdit ? site_url('admin/proker/' . $program['id'] . '/edit') : site_url('admin/proker/tambah'); ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-body p-7 p-lg-10">
        <form method="post" action="<?= $action ?>">
            <?= csrf_field() ?>
            <div class="row g-5">
                <div class="col-lg-8">
                    <label class="form-label fw-semibold required">Judul Program Kerja</label>
                    <input type="text" name="title" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('title', $program['title'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control form-control-solid" rows="6" placeholder="Tujuan dan bentuk kegiatan..."><?= esc(old('description', $program['description'] ?? '')) ?></textarea>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold">Divisi Pelaksana</label>
                            <select name="division_id" class="form-select form-select-solid mb-5">
                                <option value="">Umum / tidak terikat divisi</option>
                                <?php foreach ($divisions as $division): ?>
                                    <option value="<?= (int) $division['id'] ?>" <?= (int) old('division_id', $program['division_id'] ?? 0) === (int) $division['id'] ? 'selected' : '' ?>><?= esc($division['name']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label class="form-label fw-semibold">Target Pelaksanaan</label>
                            <input type="date" name="target_date" class="form-control form-control-solid mb-5" value="<?= esc(old('target_date', $program['target_date'] ?? '')) ?>">

                            <label class="form-label fw-semibold required">Status</label>
                            <select name="status" class="form-select form-select-solid">
                                <option value="planned" <?= old('status', $program['status'] ?? 'planned') === 'planned' ? 'selected' : '' ?>>Direncanakan</option>
                                <option value="ongoing" <?= old('status', $program['status'] ?? '') === 'ongoing' ? 'selected' : '' ?>>Berjalan</option>
                                <option value="done" <?= old('status', $program['status'] ?? '') === 'done' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Program' ?></button>
                        <a href="<?= site_url('admin/proker') ?>" class="btn btn-light">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
