<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('actions') ?>
    <?php $exportQuery = http_build_query(array_filter(['q' => $keyword, 'status' => $filterStatus, 'category' => $filterCategory])); ?>
    <a href="<?= site_url('admin/aspirasi/ekspor') . ($exportQuery ? '?' . $exportQuery : '') ?>" class="btn btn-light-success">
        <i class="ki-duotone ki-file-down fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
        Ekspor CSV
    </a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-6">
    <?php
    $cards = [
        'all'         => ['Semua', 'primary'],
        'pending'     => ['Menunggu', 'warning'],
        'read'        => ['Dibaca', 'info'],
        'followed_up' => ['Ditindaklanjuti', 'success'],
        'published'   => ['Ditampilkan', 'dark'],
    ];
    ?>
    <?php foreach ($cards as $key => [$label, $color]): ?>
        <div class="col-6 col-md">
            <div class="card card-flush h-100">
                <div class="card-body py-5">
                    <div class="text-<?= esc($color) ?> fs-2 fw-bold"><?= (int) $counts[$key] ?></div>
                    <div class="text-gray-700 fw-semibold fs-7"><?= esc($label) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <h2 class="card-title fw-bold">Daftar Aspirasi</h2>
    </div>
    <div class="card-body pt-2">
        <form method="get" action="<?= site_url('admin/aspirasi') ?>" class="row g-3 mb-5">
            <div class="col-md-4">
                <input type="search" name="q" value="<?= esc($keyword) ?>" class="form-control form-control-solid" placeholder="Cari subjek, pesan, nama, NIM...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-solid">
                    <option value="">Semua status</option>
                    <?php foreach ($statuses as $value => $label): ?>
                        <option value="<?= esc($value, 'attr') ?>" <?= $filterStatus === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-solid">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $value => $label): ?>
                        <option value="<?= esc($value, 'attr') ?>" <?= $filterCategory === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                <a href="<?= site_url('admin/aspirasi') ?>" class="btn btn-light">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-row-dashed align-middle gy-5">
                <thead>
                    <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                        <th>Tanggal</th>
                        <th>Pengirim</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tampilan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aspirations as $aspiration): ?>
                        <?php
                        $statusColors = ['pending' => 'warning', 'read' => 'info', 'followed_up' => 'success'];
                        $sender = (int) $aspiration['is_anonymous'] === 1 ? 'Anonim' : ($aspiration['name'] ?: 'Tanpa Nama');
                        ?>
                        <tr>
                            <td class="text-gray-700 fs-7"><?= esc(date('d/m/Y H:i', strtotime($aspiration['created_at']))) ?></td>
                            <td>
                                <div class="fw-bold text-gray-900"><?= esc($sender) ?></div>
                                <?php if ((int) $aspiration['is_anonymous'] !== 1 && $aspiration['nim']): ?>
                                    <div class="fs-8 text-muted">NIM <?= esc($aspiration['nim']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold text-gray-800"><?= esc($aspiration['subject']) ?></td>
                            <td class="fs-7"><?= esc($categories[$aspiration['category']] ?? ucfirst($aspiration['category'])) ?></td>
                            <td><span class="badge badge-light-<?= esc($statusColors[$aspiration['status']] ?? 'secondary') ?>"><?= esc($statuses[$aspiration['status']] ?? ucfirst($aspiration['status'])) ?></span></td>
                            <td>
                                <?php if ((int) $aspiration['is_published'] === 1): ?>
                                    <span class="badge badge-light-primary">Ditampilkan</span>
                                <?php else: ?>
                                    <span class="badge badge-light-secondary">Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= site_url('admin/aspirasi/' . $aspiration['id']) ?>" class="btn btn-sm btn-light-primary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($aspirations === []): ?>
                        <tr><td colspan="7" class="text-center text-muted py-10">Tidak ada aspirasi sesuai filter.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5"><?= $pager->links() ?></div>
    </div>
</div>
<?= $this->endSection() ?>
