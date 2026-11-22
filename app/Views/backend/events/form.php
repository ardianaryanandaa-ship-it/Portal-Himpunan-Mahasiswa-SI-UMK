<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $event !== null; ?>
<?php $action = $isEdit ? site_url('admin/event/' . $event['id'] . '/edit') : site_url('admin/event/tambah'); ?>
<?php $toLocal = static fn (?string $value): string => ! empty($value) ? date('Y-m-d\TH:i', strtotime($value)) : ''; ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-body p-7 p-lg-10">
        <form method="post" action="<?= $action ?>" enctype="multipart/form-data" id="eventForm">
            <?= csrf_field() ?>
            <div class="row g-5">
                <div class="col-lg-8">
                    <label class="form-label fw-semibold required">Judul Event</label>
                    <input type="text" name="title" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('title', $event['title'] ?? '')) ?>">

                    <label class="form-label fw-semibold required">Lokasi</label>
                    <input type="text" name="location" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('location', $event['location'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Deskripsi Event</label>
                    <div class="bg-white rounded border" style="min-height:280px" id="editor"><?= $event['description'] ?? '' ?></div>
                    <input type="hidden" name="description" id="descriptionInput" value="<?= esc(old('description', $event['description'] ?? '')) ?>">
                </div>
                <div class="col-lg-4">
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold required">Status</label>
                            <select name="status" class="form-select form-select-solid mb-5">
                                <option value="draft" <?= old('status', $event['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draf</option>
                                <option value="published" <?= old('status', $event['status'] ?? '') === 'published' ? 'selected' : '' ?>>Terbit</option>
                                <option value="closed" <?= old('status', $event['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Ditutup</option>
                            </select>

                            <label class="form-label fw-semibold required">Mulai</label>
                            <input type="datetime-local" name="start_at" class="form-control form-control-solid mb-5" required value="<?= esc(old('start_at', $toLocal($event['start_at'] ?? null))) ?>">

                            <label class="form-label fw-semibold">Selesai</label>
                            <input type="datetime-local" name="end_at" class="form-control form-control-solid mb-5" value="<?= esc(old('end_at', $toLocal($event['end_at'] ?? null))) ?>">

                            <label class="form-label fw-semibold">Batas Pendaftaran</label>
                            <input type="datetime-local" name="registration_deadline" class="form-control form-control-solid mb-5" value="<?= esc(old('registration_deadline', $toLocal($event['registration_deadline'] ?? null))) ?>">

                            <label class="form-label fw-semibold">Kuota Peserta</label>
                            <input type="number" name="quota" min="1" class="form-control form-control-solid" placeholder="Kosongkan jika tidak dibatasi" value="<?= esc(old('quota', $event['quota'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold">Poster</label>
                            <input type="file" name="poster" class="form-control form-control-solid" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, WEBP maks 2 MB.</div>
                            <?php if (! empty($event['poster'])): ?>
                                <img src="<?= esc(base_url($event['poster']), 'attr') ?>" alt="" class="w-100 rounded mt-3" style="height:150px;object-fit:cover">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Event' ?></button>
                        <a href="<?= site_url('admin/event') ?>" class="btn btn-light">Batal</a>
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
    const editorElement = document.getElementById('editor');
    const form = document.getElementById('eventForm');
    const hidden = document.getElementById('descriptionInput');
    if (!editorElement || !form || !hidden) return;

    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['blockquote', 'link'],
                ['clean']
            ]
        }
    });

    quill.root.innerHTML = hidden.value || '';
    form.addEventListener('submit', function () {
        hidden.value = quill.root.innerHTML;
    });
});
</script>
<?= $this->endSection() ?>
