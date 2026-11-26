<!--begin::Events Section-->
<?php
$fallbackEvents = [
    ['15 DES', '2026', 'Pendaftaran Buka', 'Seminar Nasional', 'AI & The Future of Enterprise Information Systems', 'Membahas tren implementasi kecerdasan buatan dalam otomatisasi bisnis dan rekayasa data perusahaan modern.', 'Auditorium Universitas Muria Kudus'],
    ['22 DES', '2026', 'Segera Hadir', 'Workshop Desain', 'Hands-On UI/UX Design & Prototyping Figma', 'Pelatihan intensif praktik membuat wireframe, interactive prototype, dan design system profesional di Figma.', 'Lab Komputer Gedung F, FT UMK'],
    ['10 JAN', '2027', 'Mendatang', 'Temu Akrab & Sharing', 'SI Annual Gathering & Alumni Career Talk', 'Temu kangen lintas angkatan serta sesi berbagi kiat sukses berkarir di industri IT langsung dari para alumni berprestasi.', 'Hall Gedung Rektorat Lt. 4 UMK'],
];

$initialEvents = ! empty($events) ? array_slice($events, 0, 3) : [];
$remainingEvents = ! empty($events) && count($events) > 3 ? array_slice($events, 3) : [];
?>
<div class="py-10 py-lg-20" id="events">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Agenda &amp; Kegiatan
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Agenda Kegiatan Mendatang
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Jangan lewatkan kesempatan menambah wawasan, pengalaman, dan jejaring melalui kegiatan resmi HIMA SI UMK.
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row Events-->
        <?php if (! empty($initialEvents)): ?>
            <!-- 3 Event Pertama -->
            <div class="row g-8">
                <?php foreach ($initialEvents as $event): ?>
                    <?php
                    $startTime = ! empty($event['start_at']) ? strtotime($event['start_at']) : time();
                    $isUpcoming = $startTime > time();
                    $modalTarget = '#modalEvent' . (int) $event['id'];
                    $excerpt = trim(strip_tags((string) ($event['description'] ?? '')));
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-flush h-100 border border-gray-200 overflow-hidden shadow-sm hover-elevate-up d-flex flex-column justify-content-between">
                            <div>
                                <div class="bg-primary text-white p-6 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-calendar fs-2tx text-white me-3"><span class="path1"></span><span class="path2"></span></i>
                                        <div>
                                            <span class="fs-3 fw-boldest d-block text-white"><?= esc(strtoupper(date('d M', $startTime))) ?></span>
                                            <span class="fs-7 opacity-75">Tahun <?= esc(date('Y', $startTime)) ?></span>
                                        </div>
                                    </div>
                                    <span class="badge badge-light-<?= $isUpcoming ? 'success' : 'secondary' ?> fs-7 fw-bold">
                                        <?= $isUpcoming ? 'Mendatang' : 'Selesai' ?>
                                    </span>
                                </div>
                                <div class="card-body p-6">
                                    <span class="badge badge-light-primary fs-8 fw-semibold mb-3">Agenda HIMA SI</span>
                                    <h3 class="fs-4 fw-bold text-gray-900 mb-3">
                                        <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="text-gray-900 text-hover-primary"><?= esc($event['title']) ?></a>
                                    </h3>
                                    <p class="text-muted fs-6 mb-4"><?= esc(mb_substr($excerpt, 0, 150)) ?><?= mb_strlen($excerpt) >= 150 ? '...' : '' ?></p>
                                </div>
                            </div>
                            <div class="px-6 pb-6 pt-0">
                                <div class="d-flex align-items-center text-gray-600 fs-7 mb-4">
                                    <i class="ki-duotone ki-geolocation fs-5 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                    <span class="text-truncate"><?= esc($event['location'] ?? 'Kampus UMK') ?></span>
                                </div>
                                <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="btn btn-sm btn-light-primary w-100 fw-semibold">
                                    Detail &amp; Pendaftaran
                                    <i class="ki-duotone ki-arrow-right fs-6 ms-1"><span class="path1"></span><span class="path2"></span></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (! empty($remainingEvents)): ?>
                <!-- Event Tambahan yang Terbuka ke Bawah Saat Diklik -->
                <div class="collapse" id="moreEventsCollapse">
                    <div class="row g-8 mt-1">
                        <?php foreach ($remainingEvents as $event): ?>
                            <?php
                            $startTime = ! empty($event['start_at']) ? strtotime($event['start_at']) : time();
                            $isUpcoming = $startTime > time();
                            $modalTarget = '#modalEvent' . (int) $event['id'];
                            $excerpt = trim(strip_tags((string) ($event['description'] ?? '')));
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <article class="card card-flush h-100 border border-gray-200 overflow-hidden shadow-sm hover-elevate-up d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="bg-primary text-white p-6 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-calendar fs-2tx text-white me-3"><span class="path1"></span><span class="path2"></span></i>
                                                <div>
                                                    <span class="fs-3 fw-boldest d-block text-white"><?= esc(strtoupper(date('d M', $startTime))) ?></span>
                                                    <span class="fs-7 opacity-75">Tahun <?= esc(date('Y', $startTime)) ?></span>
                                                </div>
                                            </div>
                                            <span class="badge badge-light-<?= $isUpcoming ? 'success' : 'secondary' ?> fs-7 fw-bold">
                                                <?= $isUpcoming ? 'Mendatang' : 'Selesai' ?>
                                            </span>
                                        </div>
                                        <div class="card-body p-6">
                                            <span class="badge badge-light-primary fs-8 fw-semibold mb-3">Agenda HIMA SI</span>
                                            <h3 class="fs-4 fw-bold text-gray-900 mb-3">
                                                <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="text-gray-900 text-hover-primary"><?= esc($event['title']) ?></a>
                                            </h3>
                                            <p class="text-muted fs-6 mb-4"><?= esc(mb_substr($excerpt, 0, 150)) ?><?= mb_strlen($excerpt) >= 150 ? '...' : '' ?></p>
                                        </div>
                                    </div>
                                    <div class="px-6 pb-6 pt-0">
                                        <div class="d-flex align-items-center text-gray-600 fs-7 mb-4">
                                            <i class="ki-duotone ki-geolocation fs-5 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="text-truncate"><?= esc($event['location'] ?? 'Kampus UMK') ?></span>
                                        </div>
                                        <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="btn btn-sm btn-light-primary w-100 fw-semibold">
                                            Detail &amp; Pendaftaran
                                            <i class="ki-duotone ki-arrow-right fs-6 ms-1"><span class="path1"></span><span class="path2"></span></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tombol Buka/Tutup Agenda Lainnya ke Bawah -->
                <div class="text-center mt-12">
                    <button type="button" class="btn btn-primary px-8 py-3" id="btnToggleMoreEvents" data-bs-toggle="collapse" data-bs-target="#moreEventsCollapse" aria-expanded="false" aria-controls="moreEventsCollapse">
                        <span class="btn-text">Lihat Agenda Lainnya</span>
                        <i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
            <?php endif; ?>

        <?php elseif (! $hasEventRecords): ?>
            <?php if ($fallbackEvents !== []): ?>
                <?php
                $eventColors = ['primary', 'success', 'dark'];
                $eventBadgeColors = ['success', 'warning', 'info'];
                ?>
                <div class="row g-8">
                    <?php foreach ($fallbackEvents as $index => [$date, $year, $status, $category, $title, $description, $location]): ?>
                        <?php
                        $color = $eventColors[$index % count($eventColors)];
                        $statusColor = $eventBadgeColors[$index % count($eventBadgeColors)];
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="card card-flush h-100 border border-gray-200 overflow-hidden shadow-sm hover-elevate-up">
                                <div class="bg-<?= esc($color) ?> text-white p-6 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-calendar fs-2tx text-white me-3"><span class="path1"></span><span class="path2"></span></i>
                                        <div>
                                            <span class="fs-3 fw-boldest d-block text-white"><?= esc($date) ?></span>
                                            <span class="fs-7 opacity-75">Tahun <?= esc($year) ?></span>
                                        </div>
                                    </div>
                                    <span class="badge badge-light-<?= esc($statusColor) ?> fs-7 fw-bold"><?= esc($status) ?></span>
                                </div>
                                <div class="card-body p-6 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="badge badge-light-<?= esc($color) ?> fs-8 fw-semibold mb-3"><?= esc($category) ?></span>
                                        <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($title) ?></h3>
                                        <p class="text-muted fs-6 mb-4"><?= nl2br(esc($description)) ?></p>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center text-gray-600 fs-7 mb-4">
                                            <i class="ki-duotone ki-geolocation fs-5 text-<?= esc($color) ?> me-2"><span class="path1"></span><span class="path2"></span></i>
                                            <?= esc($location) ?>
                                        </div>
                                        <a href="#aspirations" class="btn btn-sm btn-light-<?= esc($color) ?> w-100 fw-semibold" data-kt-scroll-toggle="true">Info Selengkapnya</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted mb-0">Belum ada kegiatan mendatang yang dibuka.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-center text-muted mb-0">Belum ada kegiatan mendatang yang dibuka.</p>
        <?php endif; ?>
        <!--end::Row Events-->
    </div>
    <!--end::Container-->
</div>
<!--end::Events Section-->

<!--begin::Events Modals (Detail Agenda Langsung di Landing Page)-->
<?php if (! empty($events)): ?>
    <?php foreach ($events as $event): ?>
        <?php
        $startTime = ! empty($event['start_at']) ? strtotime($event['start_at']) : time();
        $poster = trim((string) ($event['poster'] ?? ''));
        $posterUrl = $poster !== '' ? base_url(ltrim($poster, '/')) : '';
        $isUpcoming = $startTime > time();
        ?>
        <div class="modal fade" id="modalEvent<?= (int) $event['id'] ?>" tabindex="-1" aria-labelledby="modalEventLabel<?= (int) $event['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header pb-4 border-0">
                        <div>
                            <span class="badge badge-light-primary fs-8 fw-semibold mb-2">Agenda Kegiatan HIMA SI</span>
                            <h3 class="modal-title fs-3 fw-bold text-gray-900" id="modalEventLabel<?= (int) $event['id'] ?>">
                                <?= esc($event['title']) ?>
                            </h3>
                            <div class="text-muted fs-7 mt-2 d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                                <?= esc(date('d F Y, H:i', $startTime)) ?> WIB
                            </div>
                        </div>
                        <div class="btn btn-sm btn-icon btn-active-color-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body py-4">
                        <?php if ($posterUrl !== ''): ?>
                            <div class="mb-6 text-center">
                                <img src="<?= esc($posterUrl, 'attr') ?>" alt="<?= esc($event['title'], 'attr') ?>" class="img-fluid rounded shadow-sm w-100 max-h-350px object-fit-cover">
                            </div>
                        <?php endif; ?>

                        <div class="row g-4 mb-6">
                            <div class="col-sm-6">
                                <div class="bg-light rounded p-4 h-100">
                                    <div class="text-muted fs-8 mb-1">Waktu Pelaksanaan</div>
                                    <div class="fw-semibold text-gray-900 fs-7">
                                        <?= esc(date('d F Y, H:i', $startTime)) ?> WIB
                                        <?php if (! empty($event['end_at'])): ?>
                                            <br><small class="text-muted">s/d <?= esc(date('d F Y, H:i', strtotime($event['end_at']))) ?> WIB</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="bg-light rounded p-4 h-100">
                                    <div class="text-muted fs-8 mb-1">Lokasi Kegiatan</div>
                                    <div class="fw-semibold text-gray-900 fs-7"><?= esc($event['location'] ?? 'Kampus UMK') ?></div>
                                </div>
                            </div>
                            <?php if (! empty($event['quota'])): ?>
                                <div class="col-sm-6">
                                    <div class="bg-light rounded p-4 h-100">
                                        <div class="text-muted fs-8 mb-1">Kuota Peserta</div>
                                        <div class="fw-semibold text-gray-900 fs-7"><?= (int) $event['quota'] ?> Peserta</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (! empty($event['registration_deadline'])): ?>
                                <div class="col-sm-6">
                                    <div class="bg-light rounded p-4 h-100">
                                        <div class="text-muted fs-8 mb-1">Batas Pendaftaran</div>
                                        <div class="fw-semibold text-danger fs-7"><?= esc(date('d/m/Y H:i', strtotime($event['registration_deadline']))) ?> WIB</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="fs-6 text-gray-700 lh-lg">
                            <h4 class="fs-6 fw-bold text-gray-900 mb-2">Deskripsi Kegiatan</h4>
                            <?= \App\Libraries\HtmlSanitizer::clean((string) ($event['description'] ?? '')) ?>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <?php if ($isUpcoming): ?>
                            <a href="<?= site_url('agenda/' . esc($event['slug'], 'attr')) ?>" class="btn btn-primary">
                                Formulir Pendaftaran Peserta
                                <i class="ki-duotone ki-arrow-up-right fs-5 ms-1"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<!--end::Events Modals-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggleEvents = document.getElementById('btnToggleMoreEvents');
    const collapseEventsEl = document.getElementById('moreEventsCollapse');
    if (btnToggleEvents && collapseEventsEl) {
        collapseEventsEl.addEventListener('show.bs.collapse', function () {
            btnToggleEvents.innerHTML = '<span class="btn-text">Sembunyikan Agenda</span><i class="ki-duotone ki-up fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
        collapseEventsEl.addEventListener('hide.bs.collapse', function () {
            btnToggleEvents.innerHTML = '<span class="btn-text">Lihat Agenda Lainnya</span><i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
    }
});
</script>
