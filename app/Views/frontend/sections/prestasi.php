<!--begin::Achievements & Statistics Section-->
<div class="mt-sm-n10">
    <!--begin::Curve top-->
    <div class="landing-curve landing-dark-color">
        <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
        </svg>
    </div>
    <!--end::Curve top-->

    <!--begin::Wrapper-->
    <div class="pb-15 pt-18 landing-dark-bg">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mt-15 mb-18" id="achievements" data-kt-scroll-offset="{default: 100, lg: 150}">
                <!--begin::Badge-->
                <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                    <?= esc($landingPage['achievements_badge']) ?>
                </span>
                <!--end::Badge-->

                <!--begin::Title-->
                <h3 class="fs-2hx text-white fw-bold mb-5"><?= esc($landingPage['achievements_title']) ?></h3>
                <!--end::Title-->

                <!--begin::Description-->
                <div class="fs-5 text-gray-500 fw-semibold max-w-700px mx-auto">
                    <?= nl2br(esc($landingPage['achievements_description'])) ?>
                </div>
                <!--end::Description-->
            </div>
            <!--end::Heading-->

            <!--begin::Statistics-->
            <div class="d-flex flex-center">
                <!--begin::Items-->
                <div class="d-flex flex-wrap flex-center justify-content-lg-between mb-15 mx-auto w-xl-900px">
                    <!--begin::Item 1-->
                    <div class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain" style="background-image: url('<?= base_url('assets/media/svg/misc/octagon.svg') ?>')">
                        <i class="ki-duotone ki-award fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc((string) ($achievementCount ?: $landingPage['achievements_stat_fallback'])) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6"><?= esc($landingPage['achievements_stat_label']) ?></span>
                        </div>
                    </div>
                    <!--end::Item 1-->

                    <!--begin::Item 2-->
                    <div class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain" style="background-image: url('<?= base_url('assets/media/svg/misc/octagon.svg') ?>')">
                        <i class="ki-duotone ki-people fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc($landingPage['members_stat_value']) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6"><?= esc($landingPage['members_stat_label']) ?></span>
                        </div>
                    </div>
                    <!--end::Item 2-->

                    <!--begin::Item 3-->
                    <div class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain" style="background-image: url('<?= base_url('assets/media/svg/misc/octagon.svg') ?>')">
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
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc($landingPage['program_stat_value']) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6"><?= esc($landingPage['program_stat_label']) ?></span>
                        </div>
                    </div>
                    <!--end::Item 3-->

                    <!--begin::Item 4-->
                    <div class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain" style="background-image: url('<?= base_url('assets/media/svg/misc/octagon.svg') ?>')">
                        <i class="ki-duotone ki-handshake fs-2tx text-white mb-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="mb-0 text-center">
                            <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                                <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?= esc($landingPage['partner_stat_value']) ?>" data-kt-countup-suffix="+">0</div>
                            </div>
                            <span class="text-gray-500 fw-semibold fs-6"><?= esc($landingPage['partner_stat_label']) ?></span>
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
                <?= nl2br(esc($landingPage['achievements_quote'])) ?>
                <span class="fs-1 lh-1 text-primary">&rdquo;</span>
            </div>
            <!--end::Testimonial / Quote-->

            <!--begin::Author-->
            <div class="fs-4 fw-semibold text-gray-500 text-center">
                <span class="text-white fw-bold"><?= esc($landingPage['achievements_quote_author']) ?></span>,
                <span class="text-gray-500"><?= esc($landingPage['achievements_quote_affiliation']) ?></span>
            </div>
            <!--end::Author-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Wrapper-->

    <!--begin::Curve bottom-->
    <div class="landing-curve landing-dark-color">
        <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
        </svg>
    </div>
    <!--end::Curve bottom-->
</div>
<!--end::Achievements & Statistics Section-->

