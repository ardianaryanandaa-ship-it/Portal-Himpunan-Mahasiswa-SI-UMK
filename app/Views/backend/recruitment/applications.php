<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar/ekspor') ?>" class="btn btn-light-success">Ekspor CSV</a>
    <a href="<?= site_url('admin/rekrutmen') ?>" class="btn btn-light">Kembali</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush mb-6">
    <div class="card-body p-6">
        <h2 class="fw-bold mb-1"><?= esc($period['title']) ?></h2>
        <div class="text-muted fs-8 mb-4">
            <?= esc(date('d/m/Y', strtotime($period['start_date']))) ?> &ndash; <?= esc(date('d/m/Y', strtotime($period['end_date']))) ?>
            <?php if ($period['quota'] !== null): ?>
                &middot; Kuota <?= (int) $period['quota'] ?>
            <?php endif; ?>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($counts as $key => $count): ?>
                <span class="badge badge-light-<?= $key === 'accepted' ? 'success' : ($key === 'rejected' ? 'danger' : ($key === 'pending' ? 'warning' : 'primary')) ?> fs-8 px-3 py-2">
                    <?= $key === 'all' ? 'Semua' : esc($statuses[$key]) ?>: <?= (int) $count ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h3 class="card-title fw-bold">Daftar Pendaftar</h3>
        <form method="get" class="d-flex flex-wrap gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari nama/NIM/email...">
            <select name="status" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="">Semua status</option>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?= esc($value, 'attr') ?>" <?= $status === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
            <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Kontak</th>
                        <th>CV</th>
                        <th>Status</th>
                        <th>Waktu Daftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td class="fw-bold text-gray-900"><?= esc($application['name']) ?></td>
                            <td class="fs-8"><?= esc($application['nim']) ?></td>
                            <td class="fs-8">
                                <div><?= esc($application['email']) ?></div>
                                <div class="text-muted"><?= esc($application['phone']) ?></div>
                            </td>
                            <td>
                                <?php if (! empty($application['cv'])): ?>
                                    <a href="<?= esc(base_url($application['cv']), 'attr') ?>" target="_blank" rel="noopener" class="btn btn-sm btn-light-success">Buka CV</a>
                                <?php else: ?>
                                    <span class="text-muted fs-8">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($application['status'] === 'accepted'): ?>
                                    <span class="badge badge-light-success">Diterima</span>
                                <?php elseif ($application['status'] === 'rejected'): ?>
                                    <span class="badge badge-light-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge badge-light-warning">Menunggu</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted fs-8"><?= esc(date('d/m/Y H:i', strtotime($application['created_at']))) ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar/' . $application['id']) ?>" class="btn btn-sm btn-light-primary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($applications === []): ?>
                        <tr><td colspan="7" class="text-center text-muted py-10">Belum ada pendaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
