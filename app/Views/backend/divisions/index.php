<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <div class="d-flex gap-2">
        <a href="<?= site_url('admin/divisi/anggota') ?>" class="btn btn-light-primary">Kelola Anggota</a>
        <a href="<?= site_url('admin/divisi/tambah') ?>" class="btn btn-primary">Tambah Divisi</a>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <h2 class="card-title fw-bold">Daftar Divisi</h2>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Urutan</th>
                        <th>Divisi</th>
                        <th>Deskripsi</th>
                        <th>Anggota</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($divisions as $division): ?>
                        <tr>
                            <td class="text-muted"><?= (int) $division['sort_order'] ?></td>
                            <td class="fw-bold text-gray-900"><?= esc($division['name']) ?></td>
                            <td class="text-muted fs-7"><?= esc(mb_strimwidth((string) $division['description'], 0, 120, '...')) ?></td>
                            <td><span class="badge badge-light-primary"><?= (int) ($memberCounts[(int) $division['id']] ?? 0) ?> orang</span></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= site_url('admin/divisi/anggota?division_id=' . $division['id']) ?>" class="btn btn-sm btn-light">Anggota</a>
                                    <a href="<?= site_url('admin/divisi/' . $division['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <form method="post" action="<?= site_url('admin/divisi/' . $division['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus divisi?" data-confirm-text="Divisi hanya bisa dihapus jika tidak memiliki anggota." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($divisions === []): ?>
                        <tr><td colspan="5" class="text-center text-muted py-10">Belum ada divisi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
