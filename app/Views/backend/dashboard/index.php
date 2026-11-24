<?= $this->extend('backend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$cards = [
    [
        'label' => 'Aspirasi Baru',
        'value' => $stats['aspirations_pending'],
        'hint'  => 'Total ' . $stats['aspirations_all'] . ' aspirasi masuk',
        'icon'  => 'ki-messages',
        'color' => 'warning',
        'link'  => has_role('super-admin', 'pengurus-inti') ? site_url('admin/aspirasi?status=pending') : null,
    ],
    [
        'label' => 'Berita Terbit',
        'value' => $stats['news_published'],
        'hint'  => 'Konten berita publik',
        'icon'  => 'ki-notepad-edit',
        'color' => 'primary',
        'link'  => has_role('super-admin', 'kominfo') ? site_url('admin/berita') : null,
    ],
    [
        'label' => 'Event Mendatang',
        'value' => $stats['events_upcoming'],
        'hint'  => $stats['registrations'] . ' peserta terdaftar',
        'icon'  => 'ki-calendar',
        'color' => 'success',
        'link'  => has_role('super-admin', 'panitia', 'pengurus-inti') ? site_url('admin/event') : null,
    ],
    [
        'label' => 'Pendaftar Rekrutmen',
        'value' => $stats['recruitment_pending'],
        'hint'  => 'Menunggu seleksi',
        'icon'  => 'ki-people',
        'color' => 'info',
        'link'  => has_role('super-admin', 'pengurus-inti') ? site_url('admin/rekrutmen') : null,
    ],
];
?>

<div class="row g-5 mb-6">
    <?php foreach ($cards as $card): ?>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-flush h-100 shadow-sm">
                <div class="card-body p-6">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="admin-stat-icon bg-light-<?= esc($card['color']) ?>">
                            <i class="ki-duotone <?= esc($card['icon']) ?> fs-2 text-<?= esc($card['color']) ?>">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            </i>
                        </div>
                        <?php if ($card['link']): ?>
                            <a href="<?= esc($card['link'], 'attr') ?>" class="btn btn-sm btn-icon btn-light-primary" aria-label="Buka <?= esc($card['label'], 'attr') ?>">
                                <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="fs-2hx fw-bold text-gray-900"><?= esc((string) $card['value']) ?></div>
                    <div class="fw-semibold text-gray-700 mb-1"><?= esc($card['label']) ?></div>
                    <div class="text-muted fs-8"><?= esc($card['hint']) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-6">
    <div class="col-lg-7">
        <div class="card card-flush h-100">
            <div class="card-header border-0 pt-6">
                <h2 class="card-title fw-bold">Aspirasi Terbaru</h2>
                <?php if (has_role('super-admin', 'pengurus-inti')): ?>
                    <a href="<?= site_url('admin/aspirasi') ?>" class="btn btn-sm btn-light-primary">Lihat Semua</a>
                <?php endif; ?>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table class="table table-row-dashed gy-4 mb-0">
                        <thead>
                            <tr class="fw-bold fs-8 text-uppercase text-gray-500">
                                <th>Pengirim</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestAspirations as $aspiration): ?>
                                <?php
                                $statusMap = [
                                    'pending'     => ['warning', 'Menunggu'],
                                    'read'        => ['info', 'Dibaca'],
                                    'followed_up' => ['success', 'Ditindaklanjuti'],
                                ];
                                [$color, $label] = $statusMap[$aspiration['status']] ?? ['secondary', ucfirst($aspiration['status'])];
                                ?>
                                <tr>
                                    <td class="fw-semibold text-gray-800"><?= esc($aspiration['is_anonymous'] ? 'Anonim' : ($aspiration['name'] ?: 'Tanpa Nama')) ?></td>
                                    <td>
                                        <?php if (has_role('super-admin', 'pengurus-inti')): ?>
                                            <a href="<?= site_url('admin/aspirasi/' . $aspiration['id']) ?>" class="text-gray-900 text-hover-primary fw-semibold"><?= esc($aspiration['subject']) ?></a>
                                        <?php else: ?>
                                            <?= esc($aspiration['subject']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge badge-light-<?= esc($color) ?>"><?= esc($label) ?></span></td>
                                    <td class="text-muted fs-7"><?= esc(date('d/m/Y', strtotime($aspiration['created_at']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if ($latestAspirations === []): ?>
                                <tr><td colspan="4" class="text-center text-muted py-8">Belum ada aspirasi masuk.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-flush h-100">
            <div class="card-header border-0 pt-6">
                <h2 class="card-title fw-bold">Agenda Mendatang</h2>
                <?php if (has_role('super-admin', 'panitia')): ?>
                    <a href="<?= site_url('admin/event') ?>" class="btn btn-sm btn-light-primary">Kelola</a>
                <?php elseif (has_role('pengurus-inti')): ?>
                    <a href="<?= site_url('admin/event') ?>" class="btn btn-sm btn-light-primary">Lihat Peserta</a>
                <?php endif; ?>
            </div>
            <div class="card-body pt-2">
                <?php foreach ($upcomingEvents as $event): ?>
                    <div class="d-flex align-items-start gap-3 py-3 border-bottom border-gray-200">
                        <div class="badge badge-light-primary p-3 text-center" style="min-width:58px">
                            <span class="d-block fs-4 fw-bold"><?= esc(date('d', strtotime($event['start_at']))) ?></span>
                            <span class="fs-8"><?= esc(strtoupper(date('M', strtotime($event['start_at'])))) ?></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-gray-900"><?= esc($event['title']) ?></div>
                            <div class="text-muted fs-8"><?= esc($event['location']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ($upcomingEvents === []): ?>
                    <p class="text-muted text-center py-8 mb-0">Belum ada event mendatang.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
