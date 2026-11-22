<!--begin::Landing hero-->
<!-- Bagian hero menampilkan judul utama, deskripsi, tombol navigasi, dan sorotan HIMA SI. -->
<!-- Tinggi hero diperbesar agar foto bersama tetap dominan pada desktop dan seluler. -->
<?php
$typedTexts = ['Masa Depan Teknologi', 'Generasi Unggul', 'Inovasi & Kreativitas', 'Prestasi & Kolaborasi'];
$heroHighlights = [
    ['HIMA SI', 'Organisasi Mahasiswa'],
    ['UMK', 'Universitas Muria Kudus'],
    ['Sistem Informasi', 'Fakultas Teknik'],
    ['Inovatif & Unggul', 'Riset & Kolaborasi'],
];
?>
<div class="d-flex flex-column flex-center w-100 hero-section-height px-9">
    <!--begin::Heading-->
    <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
        <!--begin::Badge-->
        <div class="d-flex flex-center mb-5">
            <span class="badge badge-light-primary fs-7 fw-bold px-4 py-3 text-uppercase">
                Himpunan Mahasiswa Sistem Informasi &bull; Universitas Muria Kudus
            </span>
        </div>
        <!--end::Badge-->

        <!--begin::Title-->
        <!-- Judul dibagi menjadi dua baris agar posisi teks tetap stabil saat animasi berjalan. -->
        <h1 class="text-white lh-base fw-bold fs-2x fs-lg-3x mb-6 text-center">
            <span class="hero-title-line">Bersama Membangun</span>
            <span class="hero-title-line hero-title-line-secondary">
                <span class="text-white">Generasi Digital &amp;</span>
                <span class="text-primary d-inline-block" id="kt_landing_hero_text"><?= esc($typedTexts[0] ?? '') ?></span>
            </span>
        </h1>
        <!--end::Title-->

        <!--begin::Description-->
        <p class="text-white opacity-75 fs-4 fs-lg-3 mw-lg-750px mx-auto mb-10 text-center lh-lg">
            Wadah pengembangan potensi, kepemimpinan, riset teknologi, kreativitas, dan kolaborasi mahasiswa Sistem Informasi Fakultas Teknik Universitas Muria Kudus.
        </p>
        <!--end::Description-->

        <!--begin::Action-->
        <div class="d-flex flex-center flex-wrap gap-4 mb-15">
            <a href="#about" class="btn btn-primary fs-6 fw-semibold px-6 py-3" data-kt-scroll-toggle="true">
                <i class="ki-duotone ki-information-4 fs-4 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                Kenali Kami
            </a>

            <a href="#portfolio" class="btn btn-outline border-2 btn-outline-white fs-6 fw-semibold px-6 py-3" data-kt-scroll-toggle="true">
                <i class="ki-duotone ki-element-11 fs-4 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                Program Kerja
            </a>

            <a href="#achievements" class="btn btn-light-primary fs-6 fw-semibold px-6 py-3" data-kt-scroll-toggle="true">
                <i class="ki-duotone ki-calendar fs-4 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Lihat Kegiatan
            </a>
        </div>
        <!--end::Action-->
    </div>
    <!--end::Heading-->

    <!--begin::Clients/Highlights-->
    <div class="d-flex flex-center flex-wrap position-relative gap-4 px-5">
        <?php
        $highlightIcons = ['ki-people', 'ki-bank', 'ki-technology-4', 'ki-award'];
        foreach ($heroHighlights as $index => [$title, $description]):
            $icon = $highlightIcons[$index % count($highlightIcons)];
        ?>
        <!-- Item 1: Organisasi Mahasiswa -->
        <div class="d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-5 py-3 border border-white border-opacity-15 shadow-sm m-2">
            <div class="symbol symbol-40px symbol-circle me-3 bg-white bg-opacity-15 d-flex align-items-center justify-content-center">
                <i class="ki-duotone <?= esc($icon) ?> fs-2 text-white">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </div>
            <div class="text-start">
                <span class="text-white fw-bold fs-5 d-block"><?= esc($title) ?></span>
                <span class="text-white opacity-75 fs-7"><?= esc($description) ?></span>
            </div>
        </div>

        <?php endforeach; ?>
    </div>
    <!--end::Clients/Highlights-->
</div>
<!--end::Landing hero-->

