<?= $this->extend('backend/layouts/main') ?>

<?php $isEdit = $news !== null; ?>
<?php $action = $isEdit ? site_url('admin/berita/' . $news['id'] . '/edit') : site_url('admin/berita/tambah'); ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-body p-7 p-lg-10">
        <form method="post" action="<?= $action ?>" enctype="multipart/form-data" id="newsForm">
            <?= csrf_field() ?>
            <div class="row g-5">
                <div class="col-lg-8">
                    <label class="form-label fw-semibold required">Judul Berita</label>
                    <input type="text" name="title" class="form-control form-control-solid mb-5" maxlength="200" required value="<?= esc(old('title', $news['title'] ?? '')) ?>">

                    <label class="form-label fw-semibold">Ringkasan</label>
                    <textarea name="excerpt" class="form-control form-control-solid mb-5" rows="3" maxlength="1000" placeholder="Ringkasan singkat untuk kartu berita..."><?= esc(old('excerpt', $news['excerpt'] ?? '')) ?></textarea>

                    <label class="form-label fw-semibold required">Isi Berita</label>
                    <div class="bg-white rounded border" style="min-height:320px" id="editor"><?= $news['content'] ?? '' ?></div>
                    <input type="hidden" name="content" id="contentInput" value="<?= esc(old('content', $news['content'] ?? '')) ?>">
                </div>
                <div class="col-lg-4">
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body p-5">
                            <label class="form-label fw-semibold required">Status</label>
                            <select name="status" class="form-select form-select-solid mb-5">
                                <option value="draft" <?= old('status', $news['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draf</option>
                                <option value="published" <?= old('status', $news['status'] ?? '') === 'published' ? 'selected' : '' ?>>Terbit</option>
                            </select>

                            <label class="form-label fw-semibold">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control form-control-solid" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">JPG, PNG, WEBP maks 2 MB.</div>
                            <?php if (! empty($news['thumbnail'])): ?>
                                <img src="<?= esc(base_url($news['thumbnail']), 'attr') ?>" alt="" class="w-100 rounded mt-3" style="height:130px;object-fit:cover">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' ?></button>
                        <a href="<?= site_url('admin/berita') ?>" class="btn btn-light">Batal</a>
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
    const form = document.getElementById('newsForm');
    const hidden = document.getElementById('contentInput');
    if (!editorElement || !form || !hidden) return;

    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, 4, false] }],
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
