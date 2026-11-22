<!--begin::Achievements & Statistics Section-->
<?php
$achievementFallback = 30;
$memberCount = 500;
$programCount = 25;
$partnerCount = 12;
?>
<div class="achievements-section position-relative overflow-hidden">
    <!--begin::Wrapper-->
    <div class="py-16 py-lg-20 landing-dark-bg achievements-wrapper">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mt-15 mb-18" id="achievements" data-kt-scroll-offset="{default: 100, lg: 150}">
                <!--begin::Badge-->
                <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                    Prestasi &amp; Jejak Langkah
                </span>
                <!--end::Badge-->

                <!--begin::Title-->
                <h3 class="fs-2hx text-white fw-bold mb-5">Bukti Nyata Kinerja &amp; Capaian</h3>
                <!--end::Title-->

                <!--begin::Description-->
                <div class="fs-5 text-gray-500 fw-semibold max-w-700px mx-auto">
                    Dedikasi segenap pengurus dan mahasiswa Sistem Informasi Universitas Muria Kudus yang tercermin dalam angka dan prestasi membanggakan.
                </div>
                <!--end::Description-->
            </div>
            <!--end::Heading-->

            <!--begin::Statistics-->
            <div class="d-flex flex-center">
                <!--begin::Items-->
                <div class="d-flex flex-wrap flex-center justify-content-lg-between mb-15 mx-auto w-xl-900px">
                    <!--begin::Item 1-->
                    <div class="achievement-stat d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3">
                        <i class="ki-duotone ki-award fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc((string) ($achievementCount ?: $achievementFallback)) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6">Prestasi Lomba</span>
                        </div>
                    </div>
                    <!--end::Item 1-->

                    <!--begin::Item 2-->
                    <div class="achievement-stat d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3">
                        <i class="ki-duotone ki-people fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc((string) $memberCount) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6">Mahasiswa Aktif</span>
                        </div>
                    </div>
                    <!--end::Item 2-->

                    <!--begin::Item 3-->
                    <div class="achievement-stat d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3">
                        <i class="ki-duotone ki-calendar-tick fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc((string) $programCount) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6">Program Kerja</span>
                        </div>
                    </div>
                    <!--end::Item 3-->

                    <!--begin::Item 4-->
                    <div class="achievement-stat d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3">
                        <i class="ki-duotone ki-handshake fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc((string) $partnerCount) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6">Mitra &amp; Relasi</span>
                        </div>
                    </div>
                    <!--end::Item 4-->
                </div>
                <!--end::Items-->
            </div>
            <!--end::Statistics-->

            <?php if (! empty($achievements)): ?>
                <div class="row g-6 mb-15">
                    <?php foreach ($achievements as $achievement): ?>
                        <?php $photo = trim((string) ($achievement['photo'] ?? '')); ?>
                        <div class="col-md-6 col-lg-3">
                            <article class="card card-flush h-100 bg-white text-gray-900 shadow-sm overflow-hidden">
                                <?php if ($photo !== ''): ?>
                                    <img src="<?= esc(base_url(ltrim($photo, '/')), 'attr') ?>" alt="<?= esc($achievement['title'], 'attr') ?>" class="w-100 h-150px object-fit-cover">
                                <?php endif; ?>
                                <div class="card-body p-6">
                                    <span class="badge badge-light-primary mb-3"><?= esc(ucfirst($achievement['level'])) ?></span>
                                    <h4 class="fs-5 fw-bold text-gray-900 mb-2"><?= esc($achievement['title']) ?></h4>
                                    <p class="text-muted fs-7 mb-2"><?= esc($achievement['competition_name']) ?></p>
                                    <p class="text-gray-600 fs-7 mb-2"><?= esc($achievement['participant_names']) ?></p>
                                    <span class="text-muted fs-8"><?= esc(date('d M Y', strtotime($achievement['achieved_date']))) ?></span>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!--begin::Testimonial / Quote-->
            <div class="fs-2 fw-semibold text-gray-400 text-center mb-4 max-w-800px mx-auto">
                <span class="fs-1 lh-1 text-primary">&ldquo;</span>
                HIMA SI adalah wadah terbaik bagi mahasiswa untuk tidak hanya belajar kode dan sistem, tetapi juga mengasah jiwa kepemimpinan, integritas, dan kepedulian sosial.
                <span class="fs-1 lh-1 text-primary">&rdquo;</span>
            </div>
            <!--end::Testimonial / Quote-->

            <!--begin::Author-->
            <div class="fs-4 fw-semibold text-gray-500 text-center">
                <span class="text-white fw-bold">Program Studi Sistem Informasi</span>,
                <span class="text-gray-500">Fakultas Teknik Universitas Muria Kudus</span>
            </div>
            <!--end::Author-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Wrapper-->

</div>
<!--end::Achievements & Statistics Section-->

