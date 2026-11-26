<!--begin::News Section-->
<?php
$fallbackNews = [
    ['Akademik & IT', '18 Nov 2024', 'HIMA SI UMK Sukses Gelar Workshop Web Modern & REST API', 'Pelatihan hands-on intensif diikuti oleh lebih dari 100 mahasiswa untuk meningkatkan kapabilitas software engineering.', 'assets/media/stock/600x400/img-1.jpg'],
    ['Prestasi', '12 Nov 2024', 'Delegasi Mahasiswa SI Sabet Juara dalam Hackathon Nasional', 'Inovasi aplikasi smart agriculture berbasis IoT mengantarkan tim mahasiswa Sistem Informasi UMK meraih podium kejuaraan.', 'assets/media/stock/600x400/img-2.jpg'],
    ['Organisasi', '05 Nov 2024', 'Open Recruitment Pengurus HIMA SI: Bersama Bertumbuh & Mengabdi', 'Kesempatan emas bagi seluruh mahasiswa aktif Sistem Informasi untuk mengasah kepemimpinan dan memperluas relasi.', 'assets/media/stock/600x400/img-3.jpg'],
];

$initialNews = ! empty($news) ? array_slice($news, 0, 3) : [];
$remainingNews = ! empty($news) && count($news) > 3 ? array_slice($news, 3) : [];
?>
<div class="py-10 py-lg-20 bg-light" id="news">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Kabar &amp; Informasi
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Berita &amp; Artikel Terkini
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Update terkini mengenai kegiatan organisasi, prestasi mahasiswa, dan informasi penting di lingkungan Sistem Informasi UMK.
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row News-->
        <?php if (! empty($initialNews)): ?>
            <!-- 3 Berita Utama Teratas -->
            <div class="row g-8">
                <?php foreach ($initialNews as $newsItem): ?>
                    <?php
                    $thumbnail = trim((string) ($newsItem['thumbnail'] ?? ''));
                    $excerpt = trim((string) ($newsItem['excerpt'] ?? ''));
                    if ($excerpt === '') {
                        $excerpt = mb_substr(strip_tags((string) $newsItem['content']), 0, 180);
                    }
                    $modalTarget = '#modalNews' . (int) $newsItem['id'];
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
                            <div class="overlay overflow-hidden">
                                <a href="<?= $modalTarget ?>" data-bs-toggle="modal">
                                    <img class="w-100 h-200px object-fit-cover" src="<?= esc($thumbnail !== '' ? base_url(ltrim($thumbnail, '/')) : base_url('assets/media/stock/600x400/img-1.jpg'), 'attr') ?>" alt="<?= esc($newsItem['title'], 'attr') ?>">
                                </a>
                            </div>
                            <div class="card-body p-6 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge badge-light-primary fs-8 fw-semibold">Berita</span>
                                        <span class="text-muted fs-7"><?= ! empty($newsItem['published_at']) ? esc(date('d M Y', strtotime($newsItem['published_at']))) : '' ?></span>
                                    </div>
                                    <h3 class="fs-4 fw-bold text-gray-900 mb-3">
                                        <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="text-gray-900 text-hover-primary"><?= esc($newsItem['title']) ?></a>
                                    </h3>
                                    <p class="text-muted fs-6 mb-4"><?= nl2br(esc($excerpt)) ?><?= mb_strlen($excerpt) >= 180 ? '...' : '' ?></p>
                                </div>
                                <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="link-primary fw-semibold fs-6 d-inline-flex align-items-center mt-auto pt-2">
                                    Baca Selengkapnya
                                    <i class="ki-duotone ki-arrow-right fs-5 ms-2"><span class="path1"></span><span class="path2"></span></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (! empty($remainingNews)): ?>
                <!-- Berita Tambahan yang Terbuka ke Bawah Saat Diklik -->
                <div class="collapse" id="moreNewsCollapse">
                    <div class="row g-8 mt-1">
                        <?php foreach ($remainingNews as $newsItem): ?>
                            <?php
                            $thumbnail = trim((string) ($newsItem['thumbnail'] ?? ''));
                            $excerpt = trim((string) ($newsItem['excerpt'] ?? ''));
                            if ($excerpt === '') {
                                $excerpt = mb_substr(strip_tags((string) $newsItem['content']), 0, 180);
                            }
                            $modalTarget = '#modalNews' . (int) $newsItem['id'];
                            ?>
                            <div class="col-lg-4 col-md-6">
                                <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
                                    <div class="overlay overflow-hidden">
                                        <a href="<?= $modalTarget ?>" data-bs-toggle="modal">
                                            <img class="w-100 h-200px object-fit-cover" src="<?= esc($thumbnail !== '' ? base_url(ltrim($thumbnail, '/')) : base_url('assets/media/stock/600x400/img-1.jpg'), 'attr') ?>" alt="<?= esc($newsItem['title'], 'attr') ?>">
                                        </a>
                                    </div>
                                    <div class="card-body p-6 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="badge badge-light-primary fs-8 fw-semibold">Berita</span>
                                                <span class="text-muted fs-7"><?= ! empty($newsItem['published_at']) ? esc(date('d M Y', strtotime($newsItem['published_at']))) : '' ?></span>
                                            </div>
                                            <h3 class="fs-4 fw-bold text-gray-900 mb-3">
                                                <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="text-gray-900 text-hover-primary"><?= esc($newsItem['title']) ?></a>
                                            </h3>
                                            <p class="text-muted fs-6 mb-4"><?= nl2br(esc($excerpt)) ?><?= mb_strlen($excerpt) >= 180 ? '...' : '' ?></p>
                                        </div>
                                        <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="link-primary fw-semibold fs-6 d-inline-flex align-items-center mt-auto pt-2">
                                            Baca Selengkapnya
                                            <i class="ki-duotone ki-arrow-right fs-5 ms-2"><span class="path1"></span><span class="path2"></span></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tombol Buka/Tutup Berita Lainnya ke Bawah -->
                <div class="text-center mt-12">
                    <button type="button" class="btn btn-primary px-8 py-3" id="btnToggleMoreNews" data-bs-toggle="collapse" data-bs-target="#moreNewsCollapse" aria-expanded="false" aria-controls="moreNewsCollapse">
                        <span class="btn-text">Lihat Berita Lainnya</span>
                        <i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
            <?php endif; ?>

        <?php elseif (! $hasNewsRecords): ?>
            <?php if ($fallbackNews !== []): ?>
                <?php $newsColors = ['primary', 'success', 'warning']; ?>
                <div class="row g-8">
                    <?php foreach ($fallbackNews as $index => [$category, $date, $title, $description, $image]): ?>
                        <?php
                        $color = $newsColors[$index % count($newsColors)];
                        $imageUrl = base_url(ltrim($image, '/'));
                        $modalTarget = '#modalFallbackNews' . $index;
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
                                <div class="overlay overflow-hidden">
                                    <a href="<?= $modalTarget ?>" data-bs-toggle="modal">
                                        <img class="w-100 h-200px object-fit-cover" src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($title, 'attr') ?>">
                                    </a>
                                </div>
                                <div class="card-body p-6 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <span class="badge badge-light-<?= esc($color) ?> fs-8 fw-semibold"><?= esc($category) ?></span>
                                            <span class="text-muted fs-7"><?= esc($date) ?></span>
                                        </div>
                                        <h3 class="fs-4 fw-bold text-gray-900 mb-3">
                                            <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="text-gray-900 text-hover-primary"><?= esc($title) ?></a>
                                        </h3>
                                        <p class="text-muted fs-6 mb-4"><?= nl2br(esc($description)) ?></p>
                                    </div>
                                    <a href="<?= $modalTarget ?>" data-bs-toggle="modal" class="link-primary fw-semibold fs-6 d-inline-flex align-items-center">
                                        Baca Selengkapnya
                                        <i class="ki-duotone ki-arrow-right fs-5 ms-2"><span class="path1"></span><span class="path2"></span></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted mb-0">Belum ada berita yang diterbitkan.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-center text-muted mb-0">Belum ada berita yang diterbitkan.</p>
        <?php endif; ?>
        <!--end::Row News-->
    </div>
    <!--end::Container-->
</div>
<!--end::News Section-->

<!--begin::News Modals (Membaca Berita Langsung di Landing Page Tanpa Pindah Halaman)-->
<?php if (! empty($news)): ?>
    <?php foreach ($news as $newsItem): ?>
        <?php
        $thumbnail = trim((string) ($newsItem['thumbnail'] ?? ''));
        $imageUrl = $thumbnail !== '' ? base_url(ltrim($thumbnail, '/')) : base_url('assets/media/stock/600x400/img-1.jpg');
        ?>
        <div class="modal fade" id="modalNews<?= (int) $newsItem['id'] ?>" tabindex="-1" aria-labelledby="modalNewsLabel<?= (int) $newsItem['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header pb-4 border-0">
                        <div>
                            <span class="badge badge-light-primary fs-8 fw-semibold mb-2">Kabar HIMA SI</span>
                            <h3 class="modal-title fs-3 fw-bold text-gray-900" id="modalNewsLabel<?= (int) $newsItem['id'] ?>">
                                <?= esc($newsItem['title']) ?>
                            </h3>
                            <div class="text-muted fs-7 mt-2 d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                                <?= ! empty($newsItem['published_at']) ? esc(date('d F Y', strtotime($newsItem['published_at']))) : '' ?>
                            </div>
                        </div>
                        <div class="btn btn-sm btn-icon btn-active-color-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body py-4">
                        <?php if ($thumbnail !== ''): ?>
                            <div class="mb-6 text-center">
                                <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($newsItem['title'], 'attr') ?>" class="img-fluid rounded shadow-sm w-100 max-h-350px object-fit-cover">
                            </div>
                        <?php endif; ?>
                        <div class="fs-6 text-gray-700 lh-lg">
                            <?= \App\Libraries\HtmlSanitizer::clean((string) $newsItem['content']) ?>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php elseif (! $hasNewsRecords && $fallbackNews !== []): ?>
    <?php foreach ($fallbackNews as $index => [$category, $date, $title, $description, $image]): ?>
        <?php $imageUrl = base_url(ltrim($image, '/')); ?>
        <div class="modal fade" id="modalFallbackNews<?= $index ?>" tabindex="-1" aria-labelledby="modalFallbackLabel<?= $index ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header pb-4 border-0">
                        <div>
                            <span class="badge badge-light-primary fs-8 fw-semibold mb-2"><?= esc($category) ?></span>
                            <h3 class="modal-title fs-3 fw-bold text-gray-900" id="modalFallbackLabel<?= $index ?>">
                                <?= esc($title) ?>
                            </h3>
                            <div class="text-muted fs-7 mt-2 d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-5 me-1"><span class="path1"></span><span class="path2"></span></i>
                                <?= esc($date) ?>
                            </div>
                        </div>
                        <div class="btn btn-sm btn-icon btn-active-color-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-6 text-center">
                            <img src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($title, 'attr') ?>" class="img-fluid rounded shadow-sm w-100 max-h-350px object-fit-cover">
                        </div>
                        <div class="fs-6 text-gray-700 lh-lg">
                            <p><?= nl2br(esc($description)) ?></p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<!--end::News Modals-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnToggleMoreNews');
    const collapseEl = document.getElementById('moreNewsCollapse');
    if (btnToggle && collapseEl) {
        collapseEl.addEventListener('show.bs.collapse', function () {
            btnToggle.innerHTML = '<span class="btn-text">Sembunyikan Berita</span><i class="ki-duotone ki-up fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            btnToggle.innerHTML = '<span class="btn-text">Lihat Berita Lainnya</span><i class="ki-duotone ki-down fs-4 ms-2"><span class="path1"></span><span class="path2"></span></i>';
        });
    }
});
</script>
