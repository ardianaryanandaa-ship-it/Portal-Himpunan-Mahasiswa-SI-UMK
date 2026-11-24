<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/divisi/anggota/tambah' . ($divisionId > 0 ? '?division_id=' . $divisionId : '')) ?>" class="btn btn-primary">Tambah Anggota</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h2 class="card-title fw-bold">Anggota Organisasi</h2>
        <form method="get" class="d-flex flex-wrap gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari nama/jabatan...">
            <select name="division_id" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="0">Semua divisi</option>
                <?php foreach ($divisions as $division): ?>
                    <option value="<?= (int) $division['id'] ?>" <?= $divisionId === (int) $division['id'] ? 'selected' : '' ?>><?= esc($division['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
            <a href="<?= site_url('admin/divisi/anggota') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Anggota</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (! empty($member['photo'])): ?>
                                        <img src="<?= esc(base_url($member['photo']), 'attr') ?>" alt="" class="rounded-circle" style="width:42px;height:42px;object-fit:cover">
                                    <?php else: ?>
                                        <span class="symbol symbol-40px symbol-circle bg-light-primary"><span class="symbol-label text-primary fw-bold"><?= esc(mb_substr($member['name'], 0, 1)) ?></span></span>
                                    <?php endif; ?>
                                    <span class="fw-bold text-gray-900"><?= esc($member['name']) ?></span>
                                </div>
                            </td>
                            <td class="fs-7"><?= esc($member['division_name'] ?: '-') ?></td>
                            <td class="fs-7"><?= esc($member['position']) ?></td>
                            <td class="text-muted fs-8"><?= esc($member['period'] ?: '-') ?></td>
                            <td>
                                <?php if ((int) $member['is_active'] === 1): ?>
                                    <span class="badge badge-light-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-light-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= site_url('admin/divisi/anggota/' . $member['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <form method="post" action="<?= site_url('admin/divisi/anggota/' . $member['id'] . '/toggle') ?>">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-warning"><?= (int) $member['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                                    </form>
                                    <form method="post" action="<?= site_url('admin/divisi/anggota/' . $member['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus anggota?" data-confirm-text="Data anggota akan dihapus." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($members === []): ?>
                        <tr><td colspan="6" class="text-center text-muted py-10">Belum ada anggota.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
