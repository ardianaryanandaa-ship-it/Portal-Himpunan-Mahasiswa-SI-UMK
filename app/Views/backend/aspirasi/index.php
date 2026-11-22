<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Notifikasi flash menampilkan hasil aksi tanpa menutup halaman daftar. -->
<?php if ($message = session()->getFlashdata('message')): ?>
    <div class="alert alert-success" role="status"><?= esc($message) ?></div>
<?php endif; ?>
<?php if ($message = session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert"><?= esc($message) ?></div>
<?php endif; ?>

<div class="row g-4 mb-6">
    <!-- Ringkasan jumlah aspirasi memudahkan pemantauan status dan publikasi. -->
    <?php
    $cards = [
        'all' => ['Semua', 'primary'],
        'pending' => ['Menunggu', 'warning'],
        'read' => ['Sudah Dibaca', 'info'],
        'resolved' => ['Selesai', 'success'],
        'published' => ['Ditampilkan', 'primary'],
    ];
    ?>
    <?php foreach ($cards as $key => [$label, $color]): ?>
        <div class="col-6 col-md">
            <div class="card card-flush h-100">
                <div class="card-body py-5">
                    <div class="text-<?= esc($color) ?> fs-2 fw-bold"><?= (int) $counts[$key] ?></div>
                    <div class="text-gray-700 fw-semibold"><?= esc($label) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <h2 class="card-title fw-bold">Daftar Aspirasi</h2>
        <div class="card-toolbar">
            <a href="<?= site_url('admin/aspirasi') ?>" class="btn btn-sm <?= $filterStatus === '' ? 'btn-primary' : 'btn-light' ?>">Semua</a>
            <?php foreach (['pending' => 'Menunggu', 'read' => 'Dibaca', 'resolved' => 'Selesai', 'rejected' => 'Ditolak'] as $value => $label): ?>
                <a href="<?= site_url('admin/aspirasi?status=' . $value) ?>" class="btn btn-sm ms-2 <?= $filterStatus === $value ? 'btn-primary' : 'btn-light' ?>"><?= esc($label) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table id="tabel-aspirasi" class="table table-row-dashed align-middle gy-5">
                <thead>
                    <tr class="fw-bold fs-7 text-uppercase text-gray-500">
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
                        $sender = $aspiration['is_anonymous'] ? 'Anonim' : ($aspiration['name'] ?: 'Tanpa Nama');
                        $statusLabels = [
                            'pending' => ['warning', 'Menunggu'],
                            'read' => ['info', 'Sudah Dibaca'],
                            'resolved' => ['success', 'Selesai'],
                            'rejected' => ['danger', 'Ditolak'],
                        ];
                        [$statusColor, $statusLabel] = $statusLabels[$aspiration['status']] ?? ['secondary', ucfirst($aspiration['status'])];
                        ?>
                        <tr>
                            <td class="text-gray-700"><?= esc(date('d/m/Y H:i', strtotime($aspiration['created_at']))) ?></td>
                            <td>
                                <div class="fw-bold text-gray-900"><?= esc($sender) ?></div>
                                <?php if (! $aspiration['is_anonymous'] && $aspiration['nim']): ?>
                                    <div class="fs-7 text-muted">NIM <?= esc($aspiration['nim']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($aspiration['subject']) ?></td>
                            <td><?= esc(ucfirst($aspiration['category'])) ?></td>
                            <td><span class="badge badge-light-<?= esc($statusColor) ?>"><?= esc($statusLabel) ?></span></td>
                            <td>
                                <?php if ($aspiration['is_published']): ?>
                                    <span class="badge badge-light-primary">Ditampilkan</span>
                                <?php else: ?>
                                    <span class="badge badge-light-secondary">Tidak Ditampilkan</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= site_url('admin/aspirasi/' . $aspiration['id']) ?>" class="btn btn-sm btn-light-primary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($aspirations === []): ?>
                        <tr><td colspan="7" class="text-center text-muted py-10">Belum ada aspirasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#tabel-aspirasi');
    if (!table) return;

    new DataTable(table, {
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            infoFiltered: '(difilter dari _MAX_ data)',
            zeroRecords: 'Data aspirasi tidak ditemukan',
            emptyTable: 'Belum ada aspirasi',
            paginate: {
                first: 'Pertama',
                previous: 'Sebelumnya',
                next: 'Berikutnya',
                last: 'Terakhir'
            }
        },
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: 6 }
        ]
    });
});
</script>
<?= $this->endSection() ?>
