<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/event/' . $event['id'] . '/peserta/ekspor') ?>" class="btn btn-light-success">Ekspor CSV</a>
    <a href="<?= site_url('admin/event') ?>" class="btn btn-light">Kembali</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush mb-6">
    <div class="card-body p-6 d-flex flex-wrap justify-content-between align-items-center gap-4">
        <div>
            <h2 class="fw-bold mb-1"><?= esc($event['title']) ?></h2>
            <div class="text-muted fs-8">
                <?= esc(date('d/m/Y H:i', strtotime($event['start_at']))) ?> &middot; <?= esc($event['location']) ?>
            </div>
        </div>
        <div class="d-flex gap-3">
            <span class="badge badge-light-primary fs-7 px-4 py-2"><?= (int) $total ?> peserta terdaftar</span>
            <?php if ($event['quota'] !== null): ?>
                <span class="badge badge-light-warning fs-7 px-4 py-2">Kuota <?= (int) $event['quota'] ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h3 class="card-title fw-bold">Daftar Peserta</h3>
        <form method="get" class="d-flex gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari nama/NIM/email...">
            <button class="btn btn-sm btn-primary" type="submit">Cari</button>
            <a href="<?= site_url('admin/event/' . $event['id'] . '/peserta') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Kontak</th>
                        <th>Program Studi</th>
                        <th>Waktu Daftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (($pager->getCurrentPage('peserta') - 1) * 20); ?>
                    <?php foreach ($participants as $participant): ?>
                        <tr>
                            <td class="text-muted fs-8"><?= $no++ ?></td>
                            <td class="fw-bold text-gray-900"><?= esc($participant['name']) ?></td>
                            <td class="fs-8"><?= esc($participant['nim']) ?></td>
                            <td class="fs-8">
                                <div><?= esc($participant['email']) ?></div>
                                <div class="text-muted"><?= esc($participant['phone']) ?></div>
                            </td>
                            <td class="fs-8"><?= esc($participant['study_program'] ?: '-') ?></td>
                            <td class="text-muted fs-8"><?= esc(date('d/m/Y H:i', strtotime($participant['created_at']))) ?></td>
                            <td class="text-end">
                                <?php if (has_role('super-admin', 'panitia')): ?>
                                    <form method="post" action="<?= site_url('admin/event/' . $event['id'] . '/peserta/' . $participant['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus peserta?" data-confirm-text="Data peserta akan dihapus permanen." data-confirm-button="Ya, hapus">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted fs-8">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($participants === []): ?>
                        <tr><td colspan="7" class="text-center text-muted py-10">Belum ada peserta terdaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
