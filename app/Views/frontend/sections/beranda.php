<?php
$typedTexts = ['Masa Depan Teknologi', 'Generasi Unggul', 'Inovasi & Kreativitas', 'Prestasi & Kolaborasi'];
$heroHighlights = [
    ['HIMA SI', 'Organisasi mahasiswa'],
    ['UMK', 'Universitas Muria Kudus'],
    ['Sistem Informasi', 'Fakultas Teknik'],
    ['Berkarya bersama', 'Inovasi & kolaborasi'],
];
?>
<div class="hero-section-height w-100">
    <div class="hero-content">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot" aria-hidden="true"></span>
            <span>Himpunan Mahasiswa Sistem Informasi</span>
            <span class="hero-eyebrow-divider" aria-hidden="true"></span>
            <span>Universitas Muria Kudus</span>
        </div>

        <h1 class="hero-title">
            <span class="hero-title-line">Bersama Membangun</span>
            <span class="hero-title-line hero-title-line-secondary">
                <span>Generasi Digital &amp;</span>
                <span class="hero-title-highlight" id="kt_landing_hero_text"><?= esc($typedTexts[0]) ?></span>
            </span>
        </h1>

        <p class="hero-description">
            Ruang untuk belajar, berkarya, dan berkolaborasi dalam membangun masa depan digital yang berdampak.
        </p>

        <div class="hero-actions">
            <a href="#about" class="btn btn-primary" data-kt-scroll-toggle="true">
                Kenali HIMA SI
                <i class="ki-duotone ki-arrow-right fs-4 ms-2" aria-hidden="true">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
            <a href="#programs" class="btn hero-secondary-action" data-kt-scroll-toggle="true">
                Jelajahi Program
            </a>
        </div>
    </div>

    <div class="hero-highlights" aria-label="Tentang HIMA SI">
        <?php
        $highlightIcons = ['ki-people', 'ki-bank', 'ki-technology-4', 'ki-award'];
        foreach ($heroHighlights as $index => [$title, $description]):
            $icon = $highlightIcons[$index % count($highlightIcons)];
        ?>
            <div class="hero-highlight">
                <span class="hero-highlight-icon" aria-hidden="true">
                    <i class="ki-duotone <?= esc($icon) ?>">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </span>
                <span class="hero-highlight-copy">
                    <span class="hero-highlight-title"><?= esc($title) ?></span>
                    <span class="hero-highlight-description"><?= esc($description) ?></span>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

