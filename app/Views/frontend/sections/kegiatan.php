<!--begin::Events Section-->
<?php
$fallbackEvents = [
    ['15 DES', '2024', 'Pendaftaran Buka', 'Seminar Nasional', 'AI & The Future of Enterprise Information Systems', 'Membahas tren implementasi kecerdasan buatan dalam otomatisasi bisnis dan rekayasa data perusahaan modern.', 'Auditorium Universitas Muria Kudus'],
    ['22 DES', '2024', 'Segera Hadir', 'Workshop Desain', 'Hands-On UI/UX Design & Prototyping Figma', 'Pelatihan intensif praktik membuat wireframe, interactive prototype, dan design system profesional di Figma.', 'Lab Komputer Gedung F, FT UMK'],
    ['10 JAN', '2025', 'Mendatang', 'Temu Akrab & Sharing', 'SI Annual Gathering & Alumni Career Talk', 'Temu kangen lintas angkatan serta sesi berbagi kiat sukses berkarir di industri IT langsung dari para alumni berprestasi.', 'Hall Gedung Rektorat Lt. 4 UMK'],
];
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
        <?php if (! empty($events)): ?>
            <div class="row g-8">
                <?php foreach ($events as $event): ?>
                    <?php
                    $eventTypes = [
                        'seminar' => 'Seminar',
                        'workshop' => 'Workshop',
                        'lomba' => 'Lomba',
                        'rapat' => 'Rapat',
                        'pengabdian' => 'Pengabdian',
                        'lainnya' => 'Lainnya',
                    ];
                    $startTime = strtotime($event['start_datetime']);
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-flush h-100 border border-gray-200 overflow-hidden shadow-sm hover-elevate-up">
                            <div class="bg-primary text-white p-6 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fs-3 fw-boldest d-block text-white"><?= esc(strtoupper(date('d M', $startTime))) ?></span>
                                    <span class="fs-7 opacity-75"><?= esc(date('Y', $startTime)) ?></span>
                                </div>
                                <span class="badge badge-light-success fs-7 fw-bold">Mendatang</span>
                            </div>
                            <div class="card-body p-6">
                                <span class="badge badge-light-primary fs-8 fw-semibold mb-3"><?= esc($eventTypes[$event['event_type']] ?? 'Kegiatan') ?></span>
                                <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($event['title']) ?></h3>
                                <p class="text-muted fs-6 mb-4"><?= nl2br(esc((string) ($event['description'] ?? ''))) ?></p>
                                <div class="d-flex align-items-center text-gray-600 fs-7">
                                    <i class="ki-duotone ki-geolocation fs-5 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                    <?= esc($event['location']) ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
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

