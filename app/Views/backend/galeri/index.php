<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet">
<style>
    #tabel-galeri .gallery-cover-wrap {
        display: block;
        flex: 0 0 50px;
        width: 50px;
        min-width: 50px;
        max-width: 50px;
        height: 50px;
        min-height: 50px;
        max-height: 50px;
        overflow: hidden;
    }

    #tabel-galeri .gallery-cover {
        display: block;
        width: 50px;
        min-width: 50px;
        max-width: 50px;
        height: 50px;
        min-height: 50px;
        max-height: 50px;
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <h2 class="card-title fw-bold">Galeri Aktivitas HIMA SI</h2>
        <div class="card-toolbar">
            <a href="<?= site_url('admin/galeri/tambah') ?>" class="btn btn-primary">Tambah Galeri</a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table id="tabel-galeri" class="table table-row-dashed align-middle gy-5">
                <thead>
                    <tr class="fw-bold fs-7 text-uppercase text-gray-500">
                        <th>Galeri</th>
                        <th>Tanggal</th>
                        <th>Media</th>
                        <th>Status</th>
                        <th>Urutan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($galleries as $gallery): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if (! empty($gallery['cover_image'])): ?>
                                        <span class="symbol symbol-50px gallery-cover-wrap me-4 flex-shrink-0">
                                            <img src="<?= base_url($gallery['cover_image']) ?>" alt="" class="gallery-cover">
                                        </span>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-gray-900"><?= esc($gallery['title']) ?></div>
                                        <?php if (! empty($gallery['description'])): ?>
                                            <div class="fs-7 text-muted"><?= esc(substr($gallery['description'], 0, 80)) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td data-order="<?= ! empty($gallery['event_date']) ? esc($gallery['event_date'], 'attr') : '' ?>"><?= ! empty($gallery['event_date']) ? esc(date('d/m/Y', strtotime($gallery['event_date']))) : '-' ?></td>
                            <td><?= (int) $gallery['item_count'] ?> media</td>
                            <td>
                                <?php if ((int) $gallery['is_published'] === 1): ?>
                                    <span class="badge badge-light-success">Dipublikasikan</span>
                                <?php else: ?>
                                    <span class="badge badge-light-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td><?= (int) $gallery['sort_order'] ?></td>
                            <td class="text-end">
                                <form action="<?= site_url('admin/galeri/' . $gallery['id'] . '/publish') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm <?= (int) $gallery['is_published'] === 1 ? 'btn-light-warning' : 'btn-light-success' ?>">
                                        <?= (int) $gallery['is_published'] === 1 ? 'Sembunyikan' : 'Publikasikan' ?>
                                    </button>
                                </form>
                                <a href="<?= site_url('admin/galeri/' . $gallery['id'] . '/edit') ?>" class="btn btn-sm btn-light-primary">Edit</a>
                                <form action="<?= site_url('admin/galeri/' . $gallery['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus galeri beserta seluruh media?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-light-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
    const table = document.querySelector('#tabel-galeri');
    if (!table) return;

    new DataTable(table, {
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            infoFiltered: '(difilter dari _MAX_ data)',
            zeroRecords: 'Data galeri tidak ditemukan',
            emptyTable: 'Belum ada galeri aktivitas',
            paginate: {
                first: 'Pertama',
                previous: 'Sebelumnya',
                next: 'Berikutnya',
                last: 'Terakhir'
            }
        },
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [],
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });
});
</script>
<?= $this->endSection() ?>
