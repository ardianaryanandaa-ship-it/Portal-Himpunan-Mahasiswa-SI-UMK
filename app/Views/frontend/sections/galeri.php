<!--begin::Gallery Section-->
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

$itemsList = ! empty($galleryItems) ? $galleryItems : (! empty($galleries) ? $galleries : []);
$initialItems = ! empty($itemsList) ? array_slice($itemsList, 0, 8) : [];
$remainingItems = ! empty($itemsList) && count($itemsList) > 8 ? array_slice($itemsList, 8) : [];

$fallbackInitial = ! empty($galleryFallback) ? array_slice($galleryFallback, 0, 8) : [];
$fallbackRemaining = ! empty($galleryFallback) && count($galleryFallback) > 8 ? array_slice($galleryFallback, 8) : [];

$renderGalleryCard = static function ($gallery) {
    $cover = trim((string) ($gallery['image'] ?? $gallery['cover_image'] ?? $gallery['file_path'] ?? ''));
    $imageUrl = $cover !== '' ? base_url(ltrim($cover, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
    $title = $gallery['title'] ?? $gallery['gallery_title'] ?? 'Dokumentasi HIMA SI';
    $caption = $gallery['caption'] ?? $gallery['description'] ?? '';
    ?>
    <div class="col-sm-6 col-lg-3">
        <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
            <a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="landing-gallery">
                <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($title, 'attr') ?>" class="w-100 h-200px object-fit-cover">
            </a>
            <div class="card-body p-5">
                <h4 class="fs-5 fw-bold text-gray-900 mb-2"><?= esc($title) ?></h4>
                <?php if (! empty($gallery['event_date'])): ?>
                    <span class="text-muted fs-7 d-block mb-3"><?= esc(date('d M Y', strtotime($gallery['event_date']))) ?></span>
                <?php endif; ?>
                <?php if (! empty($caption)): ?>
                    <p class="text-muted fs-7 mb-0"><?= esc(mb_strimwidth(strip_tags((string) $caption), 0, 100, '...')) ?></p>
                <?php endif; ?>
            </div>
        </article>
    </div>
    <?php
};

$renderFallbackCard = static function (array $item) {
    [$category, $path] = $item;
    $imageUrl = base_url(ltrim($path, '/'));
    ?>
    <div class="col-sm-6 col-lg-3">
        <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
            <a href="<?= esc($imageUrl, 'attr') ?>" data-fslightbox="landing-gallery">
                <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($category, 'attr') ?>" class="w-100 h-200px object-fit-cover">
            </a>
            <div class="card-body p-5">
                <span class="text-gray-900 fw-bold"><?= esc($category) ?></span>
            </div>
        </article>
    </div>
    <?php
};
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

                <?php if (! empty($initialItems)): ?>
                    <!-- 8 Foto Pertama -->
                    <div class="row g-6">
                        <?php foreach ($initialItems as $item): ?>
                            <?php $renderGalleryCard($item); ?>
                        <?php endforeach; ?>
                    </div>

                    <?php if (! empty($remainingItems)): ?>
                        <!-- Foto Tambahan yang Terbuka ke Bawah Saat Diklik -->
                        <div class="collapse" id="moreGalleriesCollapse">
                            <div class="row g-6 mt-1">
                                <?php foreach ($remainingItems as $item): ?>
                                    <?php $renderGalleryCard($item); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Tombol Buka/Tutup Galeri Lainnya ke Bawah -->
                        <div class="text-center mt-12">
                            <button type="button" class="btn btn-primary px-8 py-3" id="btnToggleMoreGalleries" data-bs-toggle="collapse" data-bs-target="#moreGalleriesCollapse" aria-expanded="false" aria-controls="moreGalleriesCollapse">
                                <span class="btn-text">Lihat Galeri Lainnya</span>
                                <i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>
                    <?php endif; ?>

                <?php elseif (! $hasGalleryRecords): ?>
                    <?php if ($fallbackInitial !== []): ?>
                        <!-- 8 Foto Fallback Pertama -->
                        <div class="row g-6">
                            <?php foreach ($fallbackInitial as $item): ?>
                                <?php $renderFallbackCard($item); ?>
                            <?php endforeach; ?>
                        </div>

                        <?php if (! empty($fallbackRemaining)): ?>
                            <!-- Sisa Foto Fallback yang Terbuka ke Bawah -->
                            <div class="collapse" id="moreGalleriesCollapse">
                                <div class="row g-6 mt-1">
                                    <?php foreach ($fallbackRemaining as $item): ?>
                                        <?php $renderFallbackCard($item); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="text-center mt-12">
                                <button type="button" class="btn btn-primary px-8 py-3" id="btnToggleMoreGalleries" data-bs-toggle="collapse" data-bs-target="#moreGalleriesCollapse" aria-expanded="false" aria-controls="moreGalleriesCollapse">
                                    <span class="btn-text">Lihat Galeri Lainnya</span>
                                    <i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </div>
                        <?php endif; ?>
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
<!--end::Gallery Section-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggleGalleries = document.getElementById('btnToggleMoreGalleries');
    const collapseGalleriesEl = document.getElementById('moreGalleriesCollapse');
    if (btnToggleGalleries && collapseGalleriesEl) {
        collapseGalleriesEl.addEventListener('show.bs.collapse', function () {
            btnToggleGalleries.innerHTML = '<span class="btn-text">Sembunyikan Galeri</span><i class="ki-duotone ki-up fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
            if (typeof refreshFsLightbox === 'function') {
                refreshFsLightbox();
            }
        });
        collapseGalleriesEl.addEventListener('hide.bs.collapse', function () {
            btnToggleGalleries.innerHTML = '<span class="btn-text">Lihat Galeri Lainnya</span><i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
    }
});
</script>
