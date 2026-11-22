<!--begin::Organization Section-->
<!-- Struktur pengurus disajikan sebagai daftar kartu ringkas agar mudah dibaca dan tetap profesional. -->
<?php
$bph = [
    ['Ketua', 'Memimpin organisasi dan mengoordinasikan arah kerja HIMA SI.'],
    ['Wakil Ketua', 'Mendampingi Ketua dan membantu koordinasi kegiatan organisasi.'],
    ['Bendahara 1', 'Membantu pengelolaan dan pencatatan keuangan organisasi.'],
    ['Bendahara 2', 'Mendukung administrasi keuangan dan penyusunan laporan.'],
    ['Sekre 1', 'Mendukung administrasi, persuratan, dan dokumentasi organisasi.'],
    ['Sekre 2', 'Membantu pengarsipan dan kebutuhan administrasi kegiatan.'],
];
$departments = [
    ['PSDM', 'Pengembangan Sumber Daya Mahasiswa', 'Berfokus pada pengembangan kapasitas, potensi, dan kebersamaan mahasiswa.'],
    ['KAKA', 'Kajian Keilmuan', 'Mendorong kegiatan kajian dan pengembangan wawasan keilmuan Sistem Informasi.'],
    ['HUBLU', 'Hubungan Luar', 'Menjalin komunikasi dan hubungan dengan pihak di luar HIMA SI.'],
    ['MIKAT', 'Minat dan Bakat', 'Mewadahi minat, bakat, kreativitas, dan kegiatan nonakademik mahasiswa.'],
    ['EKRAF', 'Ekonomi Kreatif', 'Mengembangkan kreativitas dan potensi ekonomi di lingkungan HIMA SI.'],
];
?>
<div class="py-12 py-lg-20 organization-section" id="team">
    <div class="container">
        <div class="text-center mb-12">
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Struktur Pengurus
            </span>
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Pengurus HIMA SI UMK
            </h2>
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Bersama menjalankan organisasi melalui kepemimpinan dan kolaborasi setiap departemen.
            </div>
        </div>

        <div class="organization-subheading mb-7">
            <div>
                <span class="organization-subheading-label">Pengurus Inti</span>
                <h3 class="fs-3 fw-bold text-gray-900 mb-1">Badan Pengurus Harian</h3>
            </div>
            <span class="text-muted fs-6">Enam pengurus yang mengoordinasikan jalannya organisasi.</span>
        </div>

        <?php
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
                <span class="organization-subheading-label">Lima Departemen</span>
                <h3 class="fs-3 fw-bold text-gray-900 mb-1">Departemen HIMA SI</h3>
            </div>
            <span class="text-muted fs-6">Bidang kerja yang mendukung pengembangan mahasiswa dan organisasi.</span>
        </div>

        <?php
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
