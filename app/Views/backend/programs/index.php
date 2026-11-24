<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/proker/tambah') ?>" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
        Tambah Program Kerja
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h2 class="card-title fw-bold">Program Kerja</h2>
        <form method="get" class="d-flex flex-wrap gap-2">
            <select name="status" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="">Semua status</option>
                <option value="planned" <?= $status === 'planned' ? 'selected' : '' ?>>Direncanakan</option>
                <option value="ongoing" <?= $status === 'ongoing' ? 'selected' : '' ?>>Berjalan</option>
                <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>Selesai</option>
            </select>
            <select name="division_id" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="0">Semua divisi</option>
                <?php foreach ($divisions as $division): ?>
                    <option value="<?= (int) $division['id'] ?>" <?= $divisionId === (int) $division['id'] ? 'selected' : '' ?>><?= esc($division['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
            <a href="<?= site_url('admin/proker') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Program</th>
                        <th>Divisi</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programs as $program): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-900"><?= esc($program['title']) ?></div>
                                <div class="text-muted fs-8 text-truncate" style="max-width:420px"><?= esc($program['description'] ?: '-') ?></div>
                            </td>
                            <td class="fs-7"><?= esc($program['division_name'] ?: 'Umum') ?></td>
                            <td class="text-muted fs-8"><?= ! empty($program['target_date']) ? esc(date('d/m/Y', strtotime($program['target_date']))) : '-' ?></td>
                            <td>
                                <?php if ($program['status'] === 'done'): ?>
                                    <span class="badge badge-light-success">Selesai</span>
                                <?php elseif ($program['status'] === 'ongoing'): ?>
                                    <span class="badge badge-light-primary">Berjalan</span>
                                <?php else: ?>
                                    <span class="badge badge-light-warning">Direncanakan</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= site_url('admin/proker/' . $program['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <form method="post" action="<?= site_url('admin/proker/' . $program['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus program kerja?" data-confirm-text="Program kerja akan dihapus permanen." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($programs === []): ?>
                        <tr><td colspan="5" class="text-center text-muted py-10">Belum ada program kerja.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
