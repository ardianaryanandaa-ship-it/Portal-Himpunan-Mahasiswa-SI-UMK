<!--begin::Vision Mission Section-->
<?php
$missions = [
    ['Eksplorasi Keilmuan', 'Menyelenggarakan pelatihan, workshop, dan mentoring teknologi terkini guna menunjang kurikulum perkuliahan.'],
    ['Integritas Organisasi', 'Mengembangkan tata kelola himpunan yang transparan, akuntabel, solid, dan berlandaskan asas kekeluargaan.'],
    ['Inovasi & Prestasi', 'Memfasilitasi minat dan bakat mahasiswa untuk berkompetisi dan berprestasi di tingkat regional maupun nasional.'],
    ['Sinergi Kemitraan', 'Membangun relasi aktif dengan industri, alumni, asosiasi profesi (seperti Permikomnas), dan masyarakat.'],
];
?>
<div class="py-10 py-lg-20 bg-light" id="vision-mission">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-15">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Visi &amp; Misi
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Landasan &amp; Komitmen Kami
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Prinsip dan arah strategis yang menjadi pedoman HIMA SI UMK dalam menjalankan amanah organisasi dan pengabdian.
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Content Row-->
        <div class="row g-8">
            <!--begin::Visi Col-->
            <div class="col-lg-5">
                <div class="card h-100 p-8 p-lg-12 bg-primary text-white rounded-4 shadow-sm position-relative overflow-hidden">
                    <div class="position-absolute end-0 bottom-0 opacity-10 me-n10 mb-n10">
                        <i class="ki-duotone ki-compass text-white" style="font-size: 200px;">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <div class="d-flex align-items-center mb-6">
                        <div class="symbol symbol-50px symbol-circle bg-white bg-opacity-20 me-4 d-flex align-items-center justify-content-center">
                            <i class="ki-duotone ki-eye fs-2x text-white">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </div>
                        <h3 class="fs-2x fw-bold text-white mb-0">Visi Kami</h3>
                    </div>
                    <p class="fs-4 text-white opacity-90 lh-lg fw-medium mb-0">
                        &ldquo;Menjadi organisasi kemahasiswaan yang unggul, profesional, inovatif, dan berdaya saing tinggi dalam pengembangan teknologi informasi serta mencetak lulusan berjiwa kepemimpinan yang berakhlak mulia.&rdquo;
                    </p>
                </div>
            </div>
            <!--end::Visi Col-->

            <!--begin::Misi Col-->
            <div class="col-lg-7">
                <div class="row g-5">
                    <?php
                    $missionColors = ['primary', 'success', 'warning', 'danger'];
                    foreach ($missions as $index => [$title, $description]):
                        $color = $missionColors[$index % count($missionColors)];
                    ?>
                        <div class="col-md-6">
                            <div class="card h-100 p-6 bg-body rounded-4 border border-gray-200 shadow-sm hover-elevate-up">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="badge badge-light-<?= esc($color) ?> fw-bold fs-5 px-3 py-2 me-3"><?= esc(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                                    <h4 class="fs-5 fw-bold text-gray-900 mb-0"><?= esc($title) ?></h4>
                                </div>
                                <p class="text-gray-600 fs-6 mb-0"><?= nl2br(esc($description)) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!--end::Misi Col-->
        </div>
        <!--end::Content Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::Vision Mission Section-->

