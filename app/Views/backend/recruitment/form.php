<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $period !== null; ?>
<?php $action = $isEdit ? site_url('admin/rekrutmen/' . $period['id'] . '/edit') : site_url('admin/rekrutmen/tambah'); ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-body p-7 p-lg-10">
        <form method="post" action="<?= $action ?>" id="recruitmentForm">
            <?= csrf_field() ?>
            <div class="row g-5">
                <div class="col-lg-8">
                    <label class="form-label fw-semibold required">Judul Periode</label>
                    <input type="text" name="title" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('title', $period['title'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Deskripsi</label>
                    <div class="bg-white rounded border mb-5" style="min-height:200px" id="descriptionEditor"><?= $period['description'] ?? '' ?></div>
                    <input type="hidden" name="description" id="descriptionInput" value="<?= esc(old('description', $period['description'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Persyaratan</label>
                    <div class="bg-white rounded border" style="min-height:200px" id="requirementsEditor"><?= $period['requirements'] ?? '' ?></div>
                    <input type="hidden" name="requirements" id="requirementsInput" value="<?= esc(old('requirements', $period['requirements'] ?? '')) ?>">
                </div>
                <div class="col-lg-4">
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold required">Status</label>
                            <select name="status" class="form-select form-select-solid mb-5">
                                <option value="draft" <?= old('status', $period['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draf</option>
                                <option value="published" <?= old('status', $period['status'] ?? '') === 'published' ? 'selected' : '' ?>>Terbit</option>
                                <option value="closed" <?= old('status', $period['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Ditutup</option>
                            </select>

                            <label class="form-label fw-semibold required">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control form-control-solid mb-5" required value="<?= esc(old('start_date', $period['start_date'] ?? '')) ?>">

                            <label class="form-label fw-semibold required">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control form-control-solid mb-5" required value="<?= esc(old('end_date', $period['end_date'] ?? '')) ?>">

                            <label class="form-label fw-semibold">Kuota</label>
                            <input type="number" name="quota" min="1" class="form-control form-control-solid" placeholder="Kosongkan jika tidak dibatasi" value="<?= esc(old('quota', $period['quota'] ?? '')) ?>">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Periode' ?></button>
                        <a href="<?= site_url('admin/rekrutmen') ?>" class="btn btn-light">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('recruitmentForm');
    if (!form) return;

    const editors = [
        { element: '#descriptionEditor', input: '#descriptionInput' },
        { element: '#requirementsEditor', input: '#requirementsInput' }
    ];

    editors.forEach(function (config) {
        const container = document.querySelector(config.element);
        const hidden = document.querySelector(config.input);
        if (!container || !hidden) return;

        const quill = new Quill(config.element, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        quill.root.innerHTML = hidden.value || '';
        form.addEventListener('submit', function () {
            hidden.value = quill.root.innerHTML;
        });
    });
});
</script>
<?= $this->endSection() ?>
