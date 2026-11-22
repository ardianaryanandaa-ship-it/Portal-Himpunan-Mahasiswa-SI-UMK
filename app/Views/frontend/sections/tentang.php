<!--begin::About Section-->
<div class="py-10 py-lg-20" id="about">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                <?= esc($landingPage['about_badge']) ?>
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                <?= esc($landingPage['about_title']) ?>
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                <?= nl2br(esc($landingPage['about_description'])) ?>
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row-->
        <?php
        $aboutStyles = [
            ['ki-technology-4', 'primary', 2],
            ['ki-people', 'success', 5],
            ['ki-abstract-26', 'warning', 2],
        ];
        ?>
        <div class="row w-100 gy-10 mb-10 mb-lg-18">
            <?php foreach ($landingPage['about_cards_items'] as $index => [$title, $description]): ?>
                <?php [$icon, $color, $iconPaths] = $aboutStyles[$index % count($aboutStyles)]; ?>
                <div class="col-md-4 px-5">
                    <div class="card card-flush h-100 p-8 text-center border border-gray-200 hover-elevate-up shadow-sm">
                        <div class="d-flex flex-center mb-7">
                            <span class="badge badge-circle badge-light-<?= esc($color) ?> fw-bold p-7 fs-2">
                                <i class="ki-duotone <?= esc($icon) ?> fs-2tx text-<?= esc($color) ?>">
                                    <?php for ($path = 1; $path <= $iconPaths; $path++): ?>
                                        <span class="path<?= $path ?>"></span>
                                    <?php endfor; ?>
                                </i>
                            </span>
                        </div>
                        <div class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($title) ?></div>
                        <div class="fw-semibold fs-6 text-muted"><?= nl2br(esc($description)) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--end::Row-->

        <!--begin::Highlight Box-->
        <div class="card bg-light-primary border-0 rounded-4 p-8 p-lg-12 shadow-sm">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-6 mb-lg-0">
                    <h3 class="fs-2x fw-bold text-gray-900 mb-3"><?= esc($landingPage['about_highlight_title']) ?></h3>
                    <p class="fs-5 text-gray-700 fw-semibold mb-0">
                        <?= nl2br(esc($landingPage['about_highlight_description'])) ?>
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#vision-mission" class="btn btn-primary px-6 py-3 fw-semibold" data-kt-scroll-toggle="true">
                        Pelajari Visi &amp; Misi
                        <i class="ki-duotone ki-arrow-right fs-4 ms-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Highlight Box-->
    </div>
    <!--end::Container-->
</div>
<!--end::About Section-->

