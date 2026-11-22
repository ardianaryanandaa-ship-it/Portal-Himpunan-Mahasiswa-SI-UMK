<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <?php if (has_role('super-admin', 'panitia')): ?>
        <a href="<?= site_url('admin/event/tambah') ?>" class="btn btn-primary">Tambah Event</a>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h2 class="card-title fw-bold">Daftar Event</h2>
        <form method="get" class="d-flex flex-wrap gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari judul/lokasi...">
            <select name="status" class="form-select form-select-sm form-select-solid" style="width:auto">
                <option value="">Semua status</option>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?= esc($value, 'attr') ?>" <?= $status === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
            <a href="<?= site_url('admin/event') ?>" class="btn btn-sm btn-light">Reset</a>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Event</th>
                        <th>Jadwal</th>
                        <th>Peserta</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (! empty($event['poster'])): ?>
                                        <img src="<?= esc(base_url($event['poster']), 'attr') ?>" alt="" class="rounded" style="width:64px;height:48px;object-fit:cover">
                                    <?php else: ?>
                                        <span class="bg-light rounded d-flex align-items-center justify-content-center" style="width:64px;height:48px">
                                            <i class="ki-duotone ki-calendar fs-2 text-muted"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-gray-900"><?= esc($event['title']) ?></div>
                                        <div class="text-muted fs-8"><?= esc($event['location']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="fs-8 text-muted">
                                <?= esc(date('d/m/Y H:i', strtotime($event['start_at']))) ?>
                                <?php if (! empty($event['registration_deadline'])): ?>
                                    <div class="text-warning">Daftar s.d. <?= esc(date('d/m/Y H:i', strtotime($event['registration_deadline']))) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="fs-8">
                                <span class="fw-bold text-gray-900"><?= (int) $event['registration_count'] ?></span>
                                <?php if ($event['quota'] !== null): ?>
                                    <span class="text-muted">/ <?= (int) $event['quota'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($event['status'] === 'published'): ?>
                                    <span class="badge badge-light-success">Terbit</span>
                                <?php elseif ($event['status'] === 'closed'): ?>
                                    <span class="badge badge-light-dark">Ditutup</span>
                                <?php else: ?>
                                    <span class="badge badge-light-warning">Draf</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end flex-wrap gap-2">
                                    <?php if ($event['status'] === 'published'): ?>
                                        <a href="<?= site_url('agenda/' . $event['slug']) ?>" target="_blank" class="btn btn-sm btn-light">Lihat</a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('admin/event/' . $event['id'] . '/peserta') ?>" class="btn btn-sm btn-light-info">Peserta</a>
                                    <?php if (has_role('super-admin', 'panitia')): ?>
                                        <a href="<?= site_url('admin/event/' . $event['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                        <form method="post" action="<?= site_url('admin/event/' . $event['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus event?" data-confirm-text="Event akan dihapus (soft delete) beserta datanya tidak lagi tampil." data-confirm-button="Ya, hapus">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($events === []): ?>
                        <tr><td colspan="5" class="text-center text-muted py-10">Belum ada event.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
