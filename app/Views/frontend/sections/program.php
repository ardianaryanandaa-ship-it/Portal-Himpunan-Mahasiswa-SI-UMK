<!--begin::Programs Section-->
<?php
$fallbackPrograms = [
    ['Kompetisi Utama', 'Insys Competition', 'Kompetisi utama dan agenda terbesar dalam rangkaian INSYS FEST untuk mengasah kapabilitas teknologi mahasiswa.'],
    ['Desain Digital', 'UI/UX Competition', 'Kompetisi perancangan antarmuka dan pengalaman pengguna berbasis studi kasus industri digital.'],
    ['Kewirausahaan', 'Business Plan Competition (BPC)', 'Kompetisi rancangan model bisnis rintisan (startup) teknologi inovatif.'],
    ['Kebersamaan', 'Insys Fun Game', 'Kegiatan interaktif dan turnamen e-sport untuk membangun kebersamaan dan kekeluargaan mahasiswa Sistem Informasi.'],
];

$programsList = ! empty($workPrograms) ? $workPrograms : [];
$initialPrograms = ! empty($programsList) ? array_slice($programsList, 0, 6) : [];
$remainingPrograms = ! empty($programsList) && count($programsList) > 6 ? array_slice($programsList, 6) : [];

$statusMap = [
    'ongoing' => ['warning', 'Sedang Berjalan'],
    'planned' => ['primary', 'Direncanakan'],
    'done'    => ['success', 'Selesai'],
];

$divisionColors = [
    'PSDM'  => 'primary',
    'KAKA'  => 'info',
    'HUBLU' => 'success',
    'MIKAT' => 'warning',
    'EKRAF' => 'danger',
];
?>
<div class="py-10 py-lg-20 bg-light" id="programs">
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Program Kerja Unggulan
            </span>
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Program Kerja HIMA SI
            </h2>
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Rangkaian program kerja strategis dan inovatif dari setiap divisi untuk mengembangkan potensi, keahlian, dan kekeluargaan mahasiswa Sistem Informasi UMK.
            </div>
        </div>
        <!--end::Heading-->

        <?php if (! empty($initialPrograms)): ?>
            <!-- 6 Program Pertama -->
            <div class="row g-6 justify-content-center">
                <?php foreach ($initialPrograms as $proker): ?>
                    <?php
                    $divName = $proker['division_name'] ?: 'Umum';
                    $divColor = $divisionColors[$divName] ?? 'primary';
                    [$statusColor, $statusLabel] = $statusMap[$proker['status']] ?? ['secondary', ucfirst((string) $proker['status'])];
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-flush h-100 p-7 border border-gray-200 bg-white shadow-sm hover-elevate-up d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <span class="badge badge-light-<?= esc($divColor) ?> fs-8 fw-bold px-3 py-2">
                                        <i class="ki-duotone ki-abstract-26 fs-7 text-<?= esc($divColor) ?> me-1"><span class="path1"></span><span class="path2"></span></i>
                                        Divisi <?= esc($divName) ?>
                                    </span>
                                    <span class="badge badge-light-<?= esc($statusColor) ?> fs-8 fw-semibold">
                                        <?= esc($statusLabel) ?>
                                    </span>
                                </div>
                                <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($proker['title']) ?></h3>
                                <p class="text-muted fs-6 mb-4"><?= nl2br(esc((string) ($proker['description'] ?: 'Program kerja resmi yang diselenggarakan untuk memfasilitasi pengembangan wawasan dan keahlian mahasiswa Sistem Informasi.'))) ?></p>
                            </div>
                            <?php if (! empty($proker['target_date'])): ?>
                                <div class="pt-3 border-top border-gray-100 d-flex align-items-center text-gray-500 fs-7">
                                    <i class="ki-duotone ki-calendar fs-6 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                    Target Pelaksanaan: <?= esc(date('d M Y', strtotime($proker['target_date']))) ?>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (! empty($remainingPrograms)): ?>
                <!-- Program Tambahan yang Terbuka ke Bawah Saat Diklik -->
                <div class="collapse" id="moreProgramsCollapse">
                    <div class="row g-6 mt-1 justify-content-center">
                        <?php foreach ($remainingPrograms as $proker): ?>
                            <?php
                            $divName = $proker['division_name'] ?: 'Umum';
                            $divColor = $divisionColors[$divName] ?? 'primary';
                            [$statusColor, $statusLabel] = $statusMap[$proker['status']] ?? ['secondary', ucfirst((string) $proker['status'])];
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <article class="card card-flush h-100 p-7 border border-gray-200 bg-white shadow-sm hover-elevate-up d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <span class="badge badge-light-<?= esc($divColor) ?> fs-8 fw-bold px-3 py-2">
                                                <i class="ki-duotone ki-abstract-26 fs-7 text-<?= esc($divColor) ?> me-1"><span class="path1"></span><span class="path2"></span></i>
                                                Divisi <?= esc($divName) ?>
                                            </span>
                                            <span class="badge badge-light-<?= esc($statusColor) ?> fs-8 fw-semibold">
                                                <?= esc($statusLabel) ?>
                                            </span>
                                        </div>
                                        <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($proker['title']) ?></h3>
                                        <p class="text-muted fs-6 mb-4"><?= nl2br(esc((string) ($proker['description'] ?: 'Program kerja resmi yang diselenggarakan untuk memfasilitasi pengembangan wawasan dan keahlian mahasiswa Sistem Informasi.'))) ?></p>
                                    </div>
                                    <?php if (! empty($proker['target_date'])): ?>
                                        <div class="pt-3 border-top border-gray-100 d-flex align-items-center text-gray-500 fs-7">
                                            <i class="ki-duotone ki-calendar fs-6 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                            Target Pelaksanaan: <?= esc(date('d M Y', strtotime($proker['target_date']))) ?>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tombol Buka/Tutup Program Lainnya ke Bawah -->
                <div class="text-center mt-12">
                    <button type="button" class="btn btn-primary px-8 py-3" id="btnToggleMorePrograms" data-bs-toggle="collapse" data-bs-target="#moreProgramsCollapse" aria-expanded="false" aria-controls="moreProgramsCollapse">
                        <span class="btn-text">Lihat Program Lainnya</span>
                        <i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
            <?php endif; ?>

        <?php elseif (! $hasProgramRecords): ?>
            <!-- Fallback Program Jika Database Kosong -->
            <div class="row g-6 justify-content-center">
                <?php foreach ($fallbackPrograms as $index => [$category, $title, $description]): ?>
                    <div class="col-lg-6">
                        <div class="card card-flush h-100 p-8 border border-gray-200 bg-white shadow-sm hover-elevate-up">
                            <span class="badge badge-light-primary fs-7 fw-bold px-3 py-2 align-self-start mb-5"><?= esc($category) ?></span>
                            <h3 class="fs-3 fw-bold text-gray-900 mb-3"><?= esc($title) ?></h3>
                            <p class="text-muted fs-6 mb-0"><?= nl2br(esc($description)) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted mb-0">Belum ada program kerja yang diterbitkan.</p>
        <?php endif; ?>
    </div>
</div>
<!--end::Programs Section-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnTogglePrograms = document.getElementById('btnToggleMorePrograms');
    const collapseProgramsEl = document.getElementById('moreProgramsCollapse');
    if (btnTogglePrograms && collapseProgramsEl) {
        collapseProgramsEl.addEventListener('show.bs.collapse', function () {
            btnTogglePrograms.innerHTML = '<span class="btn-text">Sembunyikan Program</span><i class="ki-duotone ki-up fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
        collapseProgramsEl.addEventListener('hide.bs.collapse', function () {
            btnTogglePrograms.innerHTML = '<span class="btn-text">Lihat Program Lainnya</span><i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
    }
});
</script>
