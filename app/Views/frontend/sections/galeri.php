<?php
$galleryFallback = [
    ['Semua Momen', 'assets/media/stock/600x600/img-23.jpg'],
    ['Semua Momen', 'assets/media/stock/600x600/img-22.jpg'],
    ['Semua Momen', 'assets/media/stock/600x600/img-21.jpg'],
    ['Semua Momen', 'assets/media/stock/600x600/img-20.jpg'],
    ['Workshop & Seminar', 'assets/media/stock/600x600/img-11.jpg'],
    ['Workshop & Seminar', 'assets/media/stock/600x600/img-12.jpg'],
    ['Workshop & Seminar', 'assets/media/stock/600x600/img-16.jpg'],
    ['Workshop & Seminar', 'assets/media/stock/600x600/img-15.jpg'],
    ['Kompetisi & Prestasi', 'assets/media/stock/600x600/img-15.jpg'],
    ['Kompetisi & Prestasi', 'assets/media/stock/600x600/img-22.jpg'],
    ['Kompetisi & Prestasi', 'assets/media/stock/600x600/img-21.jpg'],
    ['Kompetisi & Prestasi', 'assets/media/stock/600x600/img-14.jpg'],
    ['Makrab & Sosial', 'assets/media/stock/600x600/img-23.jpg'],
    ['Makrab & Sosial', 'assets/media/stock/600x600/img-12.jpg'],
    ['Makrab & Sosial', 'assets/media/stock/600x600/img-16.jpg'],
    ['Makrab & Sosial', 'assets/media/stock/600x600/img-20.jpg'],
];
?>
<div class="py-10 py-lg-20" id="portfolio">
    <div class="container">
        <div class="card" style="filter: drop-shadow(0px 0px 40px rgba(68, 81, 96, 0.08))">
            <div class="card-body p-lg-20">
                <div class="text-center mb-5 mb-lg-10">
                    <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                        Dokumentasi &amp; Jejak Karya
                    </span>
                    <h3 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 250}">
                        Galeri Aktivitas HIMA SI
                    </h3>
                    <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                        Momen-momen berharga dan kebersamaan dalam setiap agenda, kompetisi, dan program kerja HIMA SI UMK.
                    </div>
                </div>

                <?php if (! empty($galleryItems) || ! empty($galleries)): ?>
                    <div class="row g-6">
                        <?php if (! empty($galleryItems)): ?>
                            <?php foreach ($galleryItems as $galleryItem): ?>
                                <?php $imageUrl = base_url(ltrim($galleryItem['file_path'], '/')); ?>
                                <div class="col-sm-6 col-lg-3">
                                    <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up">
                                        <?php if ($galleryItem['media_type'] === 'image'): ?>
                                            <a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="landing-gallery">
                                                <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($galleryItem['caption'] ?: $galleryItem['gallery_title'], 'attr') ?>" class="w-100 h-200px object-fit-cover">
                                            </a>
                                        <?php else: ?>
                                            <video class="w-100 h-200px object-fit-cover" controls preload="metadata">
                                                <source src="<?= esc($imageUrl, 'attr') ?>">
                                            </video>
                                        <?php endif; ?>
                                        <div class="card-body p-5">
                                            <h4 class="fs-6 fw-bold text-gray-900 mb-2"><?= esc($galleryItem['gallery_title']) ?></h4>
                                            <?php if (! empty($galleryItem['caption'])): ?>
                                                <p class="text-muted fs-7 mb-0"><?= esc($galleryItem['caption']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($galleries as $gallery): ?>
                                <?php
                                $cover = trim((string) ($gallery['image'] ?? $gallery['cover_image'] ?? ''));
                                $imageUrl = $cover !== '' ? base_url(ltrim($cover, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
                                ?>
                                <div class="col-sm-6 col-lg-3">
                                    <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up">
                                        <a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="landing-gallery">
                                            <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($gallery['title'], 'attr') ?>" class="w-100 h-200px object-fit-cover">
                                        </a>
                                        <div class="card-body p-5">
                                            <h4 class="fs-5 fw-bold text-gray-900 mb-2"><?= esc($gallery['title']) ?></h4>
                                            <?php if (! empty($gallery['event_date'])): ?>
                                                <span class="text-muted fs-7 d-block mb-3"><?= esc(date('d M Y', strtotime($gallery['event_date']))) ?></span>
                                            <?php endif; ?>
                                            <?php if (! empty($gallery['description'])): ?>
                                                <p class="text-muted fs-7 mb-0"><?= nl2br(esc($gallery['description'])) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php elseif (! $hasGalleryRecords): ?>
                    <?php if ($galleryFallback !== []): ?>
                        <div class="row g-6">
                            <?php foreach ($galleryFallback as [$category, $path]): ?>
                                <?php $imageUrl = base_url(ltrim($path, '/')); ?>
                                <div class="col-sm-6 col-lg-3">
                                    <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up">
                                        <a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="landing-gallery">
                                            <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($category, 'attr') ?>" class="w-100 h-200px object-fit-cover">
                                        </a>
                                        <div class="card-body p-5">
                                            <span class="text-gray-900 fw-bold"><?= esc($category) ?></span>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted mb-0">Belum ada galeri yang dipublikasikan.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-center text-muted mb-0">Belum ada galeri yang dipublikasikan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
