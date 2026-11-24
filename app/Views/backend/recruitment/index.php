<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/rekrutmen/tambah') ?>" class="btn btn-primary">Tambah Periode</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <h2 class="card-title fw-bold">Periode Rekrutmen</h2>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Periode</th>
                        <th>Rentang Pendaftaran</th>
                        <th>Pendaftar</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periods as $period): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-gray-900"><?= esc($period['title']) ?></div>
                                <div class="text-muted fs-8">/rekrutmen/<?= esc($period['slug']) ?></div>
                            </td>
                            <td class="fs-8 text-muted">
                                <?= esc(date('d/m/Y', strtotime($period['start_date']))) ?> &ndash; <?= esc(date('d/m/Y', strtotime($period['end_date']))) ?>
                            </td>
                            <td class="fs-8">
                                <span class="fw-bold text-gray-900"><?= (int) $period['application_count'] ?></span>
                                <?php if ($period['quota'] !== null): ?>
                                    <span class="text-muted">/ <?= (int) $period['quota'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($period['status'] === 'published'): ?>
                                    <span class="badge badge-light-success">Terbit</span>
                                <?php elseif ($period['status'] === 'closed'): ?>
                                    <span class="badge badge-light-dark">Ditutup</span>
                                <?php else: ?>
                                    <span class="badge badge-light-warning">Draf</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end flex-wrap gap-2">
                                    <?php if ($period['status'] === 'published'): ?>
                                        <a href="<?= site_url('rekrutmen/' . $period['slug']) ?>" target="_blank" class="btn btn-sm btn-light">Lihat</a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/pendaftar') ?>" class="btn btn-sm btn-light-info">Pendaftar</a>
                                    <a href="<?= site_url('admin/rekrutmen/' . $period['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <form method="post" action="<?= site_url('admin/rekrutmen/' . $period['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus periode?" data-confirm-text="Periode rekrutmen akan dihapus (soft delete)." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($periods === []): ?>
                        <tr><td colspan="5" class="text-center text-muted py-10">Belum ada periode rekrutmen.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
