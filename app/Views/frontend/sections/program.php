<!--begin::Programs Section-->
<?php
$programs = [
    ['Kompetisi Utama', 'Insys Competition', 'Kompetisi utama dan acara terbesar dalam rangkaian INSYS FEST.'],
    ['Desain Digital', 'UI/UX Competition', 'Kompetisi perancangan antarmuka dan pengalaman pengguna.'],
    ['Kewirausahaan', 'BPC', 'Bisnis Plan Competition untuk gagasan dan rencana bisnis.'],
    ['Kebersamaan', 'Insys Fun Game', 'Kegiatan permainan untuk membangun kebersamaan dan semangat sportif.'],
];
?>
<div class="py-10 py-lg-20 bg-light" id="programs">
    <div class="container">
        <div class="text-center mb-12">
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Program Unggulan
            </span>
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                INSYS FEST
            </h2>
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Festival Sistem Informasi yang menghadirkan kompetisi, kreativitas, dan kebersamaan dalam satu rangkaian acara.
            </div>
        </div>

        <?php
        $programColors = ['primary', 'info', 'success', 'warning'];
        $featuredProgram = array_shift($programs);
        ?>
        <div class="row g-6 justify-content-center">
            <?php if ($featuredProgram !== null): ?>
                <?php [$category, $title, $description] = $featuredProgram; ?>
                <div class="col-lg-6">
                    <div class="card card-flush h-100 p-8 border border-primary shadow-sm hover-elevate-up">
                        <div class="d-flex align-items-center justify-content-between mb-6">
                            <span class="badge badge-light-primary fs-7 fw-bold px-3 py-2"><?= esc($category) ?></span>
                            <span class="badge badge-primary fs-8">Program Unggulan</span>
                        </div>
                        
                        <h3 class="fs-3 fw-bold text-gray-900 mb-3"><?= esc($title) ?></h3>
                        <p class="text-muted fs-6 mb-0"><?= nl2br(esc($description)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($programs !== []): ?>
                <div class="<?= $featuredProgram === null ? 'col-12' : 'col-lg-6' ?>">
                    <div class="row g-6 h-100">
                        <?php foreach ($programs as $index => [$category, $title, $description]): ?>
                            <?php
                            $color = $programColors[($index + 1) % count($programColors)];
                            $columnClass = $index === count($programs) - 1 && count($programs) % 2 === 1 ? 'col-sm-12' : 'col-sm-6';
                            ?>
                            <div class="<?= $columnClass ?>">
                                <div class="card card-flush h-100 p-6 border border-gray-200 hover-elevate-up">
                                    <span class="badge badge-light-<?= esc($color) ?> fs-7 fw-bold px-3 py-2 align-self-start mb-5"><?= esc($category) ?></span>
                                    <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($title) ?></h3>
                                    <p class="text-muted fs-6 mb-0"><?= nl2br(esc($description)) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--end::Programs Section-->
