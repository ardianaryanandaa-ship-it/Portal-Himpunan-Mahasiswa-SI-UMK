<!--
    Konten statis halaman Tentang Kami: sejarah, visi, dan misi organisasi.
    Teks sengaja disimpan di view/partial agar mudah disunting tanpa mengubah .env atau database.
-->
<div class="row g-10 align-items-center mb-12">
    <div class="col-lg-6">
        <span class="badge badge-light-primary fs-8 fw-bold text-uppercase mb-3 px-4 py-2">Sejarah Singkat</span>
        <h2 class="page-section-title mb-4">Tumbuh Bersama Mahasiswa Sistem Informasi</h2>
        <div class="article-content">
            <p>
                <?= esc($organization->fullName) ?> (<?= esc($organization->name) ?>) adalah organisasi kemahasiswaan
                di lingkungan Program Studi <?= esc($organization->programStudy) ?>, <?= esc($organization->faculty) ?>,
                <?= esc($organization->university) ?>. Himpunan ini lahir dari semangat mahasiswa Sistem Informasi untuk
                memiliki wadah bersama dalam mengembangkan kompetensi akademik, kepemimpinan, dan pengabdian.
            </p>
            <p>
                Sejak awal berdiri, <?= esc($organization->name) ?> berperan sebagai jembatan antara mahasiswa, program studi,
                alumni, dan dunia industri. Berbagai kegiatan seperti pelatihan teknologi, kompetisi, seminar, bakti sosial,
                serta program pengembangan minat dan bakat terus diselenggarakan setiap periode kepengurusan.
            </p>
            <p class="mb-0">
                Pada periode <?= esc($organization->period) ?>, <?= esc($organization->name) ?> berkomitmen menjadi organisasi
                yang adaptif, transparan, dan kolaboratif dengan mengedepankan nilai kekeluargaan serta profesionalisme.
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm overflow-hidden">
            <img src="<?= base_url('assets/media/stock/600x400/img-20.jpg') ?>" alt="Kegiatan <?= esc($organization->name, 'attr') ?>" class="w-100" style="height:360px;object-fit:cover">
            <div class="card-body p-6 bg-light-primary">
                <div class="d-flex align-items-center gap-4">
                    <span class="symbol symbol-50px">
                        <span class="symbol-label bg-primary">
                            <i class="ki-duotone ki-abstract-26 fs-2x text-white"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                    </span>
                    <div>
                        <strong class="d-block text-gray-900 fs-5"><?= esc($organization->tagline) ?></strong>
                        <span class="text-muted fs-7"><?= esc($organization->university) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-8 mb-12">
    <div class="col-lg-6">
        <div class="card h-100 border border-gray-200">
            <div class="card-body p-7 p-lg-9">
                <span class="badge badge-light-success fs-8 fw-bold text-uppercase mb-4 px-4 py-2">Visi</span>
                <h3 class="fs-4 fw-bold text-gray-900 mb-4">Visi Kami</h3>
                <p class="text-muted fs-6 mb-0">
                    Menjadi organisasi kemahasiswaan yang unggul, profesional, inovatif, dan berdaya saing tinggi dalam
                    pengembangan teknologi informasi serta mencetak lulusan berjiwa kepemimpinan yang berakhlak mulia.
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100 border border-gray-200">
            <div class="card-body p-7 p-lg-9">
                <span class="badge badge-light-warning fs-8 fw-bold text-uppercase mb-4 px-4 py-2">Misi</span>
                <h3 class="fs-4 fw-bold text-gray-900 mb-4">Misi Kami</h3>
                <ol class="text-muted fs-6 ps-4 mb-0 d-flex flex-column gap-3">
                    <li>Menyelenggarakan pelatihan, workshop, dan mentoring teknologi terkini guna menunjang kurikulum perkuliahan.</li>
                    <li>Mengembangkan tata kelola himpunan yang transparan, akuntabel, solid, dan berlandaskan asas kekeluargaan.</li>
                    <li>Memfasilitasi minat dan bakat mahasiswa untuk berkompetisi dan berprestasi di tingkat regional maupun nasional.</li>
                    <li>Membangun relasi aktif dengan industri, alumni, asosiasi profesi, dan masyarakat.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row g-6">
    <?php
    $values = [
        ['icon' => 'ki-abstract-26', 'color' => 'primary', 'title' => 'Keilmuan & Teknologi', 'text' => 'Mendorong penguasaan rekayasa sistem informasi, data, kecerdasan buatan, dan pengembangan perangkat lunak.'],
        ['icon' => 'ki-profile-user', 'color' => 'success', 'title' => 'Kepemimpinan & Karakter', 'text' => 'Membina jiwa kepemimpinan, manajemen organisasi, komunikasi efektif, dan integritas profesional.'],
        ['icon' => 'ki-people', 'color' => 'warning', 'title' => 'Kolaborasi & Pengabdian', 'text' => 'Menjalin kemitraan strategis serta menghadirkan program pengabdian masyarakat berbasis teknologi digital.'],
    ];
    ?>
    <?php foreach ($values as $value): ?>
        <div class="col-md-4">
            <div class="card h-100 border border-gray-200">
                <div class="card-body p-6">
                    <span class="symbol symbol-45px mb-4">
                        <span class="symbol-label bg-light-<?= esc($value['color']) ?>">
                            <i class="ki-duotone <?= esc($value['icon']) ?> fs-2x text-<?= esc($value['color']) ?>"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        </span>
                    </span>
                    <h3 class="fs-6 fw-bold text-gray-900 mb-2"><?= esc($value['title']) ?></h3>
                    <p class="text-muted fs-7 mb-0"><?= esc($value['text']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
