<!--begin::Organization Section-->
<!-- Struktur pengurus disajikan sebagai daftar kartu ringkas agar mudah dibaca dan tetap profesional. -->
<div class="py-12 py-lg-20 organization-section" id="team">
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

        <div class="organization-subheading mb-7">
            <div>
                <span class="organization-subheading-label">Pengurus Inti</span>
                <h3 class="fs-3 fw-bold text-gray-900 mb-1"><?= esc($landingPage['organization_bph_title']) ?></h3>
            </div>
            <span class="text-muted fs-6"><?= esc($landingPage['organization_bph_description']) ?></span>
        </div>

        <?php
        $bph = $landingPage['organization_bph_rows_items'];
        ?>
        <div class="row g-4 g-lg-5 mb-12">
            <?php foreach ($bph as $index => [$position, $description]): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="organization-bph-card h-100">
                        <span class="organization-card-number"><?= esc(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                        <h4 class="text-gray-900 fw-bold fs-5 mb-2"><?= esc($position) ?></h4>
                        <p class="text-muted fs-7 mb-0"><?= esc($description) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="organization-subheading mb-7">
            <div>
                <span class="organization-subheading-label"><?= esc($landingPage['organization_department_badge']) ?></span>
                <h3 class="fs-3 fw-bold text-gray-900 mb-1"><?= esc($landingPage['organization_department_title']) ?></h3>
            </div>
            <span class="text-muted fs-6"><?= esc($landingPage['organization_department_description']) ?></span>
        </div>

        <?php
        $departments = $landingPage['organization_department_rows_items'];
        ?>
        <div class="row g-4">
            <?php foreach ($departments as [$acronym, $name, $description]): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="organization-department-card h-100">
                        <div class="organization-department-code"><?= esc($acronym) ?></div>
                        <h4 class="fs-5 fw-bold text-gray-900 mb-1"><?= esc($name) ?></h4>
                        <p class="text-muted fs-7 mb-0"><?= esc($description) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--end::Organization Section-->
