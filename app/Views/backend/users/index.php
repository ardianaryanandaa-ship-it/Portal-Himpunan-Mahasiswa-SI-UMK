<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <a href="<?= site_url('admin/pengguna/tambah') ?>" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
        Tambah Pengguna
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6 flex-wrap gap-3">
        <h2 class="card-title fw-bold">Daftar Pengguna</h2>
        <form method="get" action="<?= site_url('admin/pengguna') ?>" class="d-flex gap-2">
            <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-sm form-control-solid" placeholder="Cari nama, username, email...">
            <button class="btn btn-sm btn-light-primary" type="submit">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="<?= site_url('admin/pengguna') ?>" class="btn btn-sm btn-light">Reset</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed gy-5 align-middle">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Login Terakhir</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (! empty($user['avatar'])): ?>
                                        <img src="<?= esc(base_url($user['avatar']), 'attr') ?>" alt="" class="rounded-circle" style="width:40px;height:40px;object-fit:cover">
                                    <?php else: ?>
                                        <span class="symbol symbol-40px symbol-circle bg-light-primary">
                                            <span class="symbol-label text-primary fw-bold"><?= esc(mb_substr($user['full_name'], 0, 1)) ?></span>
                                        </span>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-gray-900"><?= esc($user['full_name']) ?></div>
                                        <div class="text-muted fs-8">@<?= esc($user['username']) ?> &middot; <?= esc($user['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-light-primary"><?= esc($user['role_name'] ?: 'Tanpa Role') ?></span></td>
                            <td>
                                <?php if ((int) $user['is_active'] === 1): ?>
                                    <span class="badge badge-light-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-light-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted fs-8">
                                <?= ! empty($user['last_login_at']) ? esc(date('d/m/Y H:i', strtotime($user['last_login_at']))) : 'Belum pernah' ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= site_url('admin/pengguna/' . $user['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                    <?php if ((int) $user['id'] !== (int) session('user_id')): ?>
                                        <form method="post" action="<?= site_url('admin/pengguna/' . $user['id'] . '/toggle') ?>" class="js-confirm-submit" data-confirm-title="Ubah status pengguna?" data-confirm-text="Status aktif pengguna akan diubah.">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-light-warning"><?= (int) $user['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                                        </form>
                                        <form method="post" action="<?= site_url('admin/pengguna/' . $user['id'] . '/hapus') ?>" class="js-confirm-submit" data-confirm-title="Hapus pengguna?" data-confirm-text="Pengguna akan dihapus (soft delete)." data-confirm-button="Ya, hapus">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($users === []): ?>
                        <tr><td colspan="5" class="text-center text-muted py-10">Tidak ada pengguna ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
