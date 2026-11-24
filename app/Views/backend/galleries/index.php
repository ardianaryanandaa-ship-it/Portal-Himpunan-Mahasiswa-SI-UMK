<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/galeri/tambah') ?>" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
        Tambah Galeri
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-5">
    <?php foreach ($galleries as $gallery): ?>
        <div class="col-sm-6 col-xl-4">
            <div class="card card-flush h-100">
                <img src="<?= esc(base_url($gallery['image']), 'attr') ?>" alt="<?= esc($gallery['title'], 'attr') ?>" style="height:190px;object-fit:cover" class="card-img-top">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <h3 class="fs-6 fw-bold text-gray-900 mb-0"><?= esc($gallery['title']) ?></h3>
                        <?php if ((int) $gallery['is_active'] === 1): ?>
                            <span class="badge badge-light-success fs-9">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-light-danger fs-9">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                    <div class="text-muted fs-8 mb-2">
                        <?= ! empty($gallery['event_date']) ? esc(date('d M Y', strtotime($gallery['event_date']))) : 'Tanpa tanggal' ?>
                        &middot; Urutan <?= (int) $gallery['sort_order'] ?>
                    </div>
                    <?php if (! empty($gallery['description'])): ?>
                        <p class="text-muted fs-8 mb-4"><?= esc(mb_strimwidth($gallery['description'], 0, 110, '...')) ?></p>
                    <?php endif; ?>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= site_url('admin/galeri/' . $gallery['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                        <form method="post" action="<?= site_url('admin/galeri/' . $gallery['id'] . '/toggle') ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-light-warning"><?= (int) $gallery['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                        </form>
                        <form method="post" action="<?= site_url('admin/galeri/' . $gallery['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus galeri?" data-confirm-text="Foto akan dihapus dari galeri." data-confirm-button="Ya, hapus">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($galleries === []): ?>
        <div class="col-12"><div class="alert alert-light text-center text-muted">Belum ada foto galeri.</div></div>
    <?php endif; ?>
</div>
<div class="mt-5"><?= $pager->links() ?></div>
<?= $this->endSection() ?>
