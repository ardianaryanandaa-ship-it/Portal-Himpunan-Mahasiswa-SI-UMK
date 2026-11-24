<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/berita/tambah') ?>" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
        Tambah Berita
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h2 class="card-title fw-bold">Daftar Berita</h2>
        <form method="get" class="d-flex flex-wrap gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari judul...">
            <select name="status" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="">Semua status</option>
                <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Terbit</option>
                <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Draf</option>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
            <a href="<?= site_url('admin/berita') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Berita</th>
                        <th>Status</th>
                        <th>Tanggal Terbit</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (! empty($item['thumbnail'])): ?>
                                        <img src="<?= esc(base_url($item['thumbnail']), 'attr') ?>" alt="" style="width:72px;height:50px;object-fit:cover" class="rounded">
                                    <?php else: ?>
                                        <span class="bg-light rounded d-flex align-items-center justify-content-center" style="width:72px;height:50px">
                                            <i class="ki-duotone ki-picture fs-2 text-muted"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-gray-900"><?= esc($item['title']) ?></div>
                                        <div class="text-muted fs-8">/berita/<?= esc($item['slug']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if ($item['status'] === 'published'): ?>
                                    <span class="badge badge-light-success">Terbit</span>
                                <?php else: ?>
                                    <span class="badge badge-light-warning">Draf</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted fs-8"><?= ! empty($item['published_at']) ? esc(date('d/m/Y H:i', strtotime($item['published_at']))) : '-' ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <?php if ($item['status'] === 'published'): ?>
                                        <a href="<?= site_url('berita/' . $item['slug']) ?>" target="_blank" class="btn btn-sm btn-light">Lihat</a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('admin/berita/' . $item['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <form method="post" action="<?= site_url('admin/berita/' . $item['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus berita?" data-confirm-text="Berita akan dihapus (soft delete)." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($news === []): ?>
                        <tr><td colspan="4" class="text-center text-muted py-10">Belum ada berita.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
