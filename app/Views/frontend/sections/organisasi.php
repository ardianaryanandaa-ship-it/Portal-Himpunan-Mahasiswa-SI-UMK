<!--begin::Organization Section-->
<div class="py-10 py-lg-20" id="team">
    <div class="container">
        <div class="text-center mb-12">
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                <?= esc($landingPage['organization_badge']) ?>
            </span>
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                <?= esc($landingPage['organization_title']) ?>
            </h2>
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                <?= nl2br(esc($landingPage['organization_description'])) ?>
            </div>
        </div>

        <div class="text-center mb-8">
            <h3 class="fs-2 fw-bold text-gray-900 mb-2"><?= esc($landingPage['organization_bph_title']) ?></h3>
            <span class="text-muted fs-6"><?= esc($landingPage['organization_bph_description']) ?></span>
        </div>

        <?php
        $bph = $landingPage['organization_bph_rows_items'];
        ?>
        <div class="row g-6 justify-content-center mb-14">
            <?php foreach ($bph as $index => [$position, $description]): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card card-flush text-center p-6 border border-gray-200 h-100 hover-elevate-up shadow-sm">
                        <div class="symbol symbol-60px symbol-circle bg-light-primary text-primary mx-auto mb-5">
                            <span class="symbol-label fs-3 fw-bold text-primary"><?= esc(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                        </div>
                        <h4 class="text-gray-900 fw-bold fs-4 mb-2"><?= esc($position) ?></h4>
                        <span class="badge badge-light-primary fw-semibold fs-7 mb-4">BPH</span>
                        <p class="text-muted fs-7 mb-0"><?= esc($description) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mb-8">
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase"><?= esc($landingPage['organization_department_badge']) ?></span>
            <h3 class="fs-2 fw-bold text-gray-900 mb-2"><?= esc($landingPage['organization_department_title']) ?></h3>
            <span class="text-muted fs-6"><?= esc($landingPage['organization_department_description']) ?></span>
        </div>

        <?php
        $departments = $landingPage['organization_department_rows_items'];
        ?>
        <div class="row g-6 justify-content-center">
            <?php foreach ($departments as [$acronym, $name, $description]): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-flush p-6 border border-gray-200 h-100 hover-elevate-up">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-50px symbol-circle bg-light-primary me-4">
                                <span class="symbol-label text-primary fw-bold"><?= esc($acronym) ?></span>
                            </div>
                            <div>
                                <h4 class="fs-5 fw-bold text-gray-900 mb-1"><?= esc($acronym) ?></h4>
                                <span class="text-muted fs-7"><?= esc($name) ?></span>
                            </div>
                        </div>
                        <p class="text-gray-600 fs-6 mb-0"><?= esc($description) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--end::Organization Section-->
