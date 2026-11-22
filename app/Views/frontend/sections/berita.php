<!--begin::News Section-->
<div class="py-10 py-lg-20 bg-light" id="news">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                <?= esc($landingPage['news_badge']) ?>
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                <?= esc($landingPage['news_title']) ?>
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                <?= nl2br(esc($landingPage['news_description'])) ?>
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row News-->
        <?php if (! empty($news)): ?>
            <div class="row g-8">
                <?php foreach ($news as $newsItem): ?>
                    <?php
                    $thumbnail = trim((string) ($newsItem['thumbnail'] ?? ''));
                    $excerpt = trim((string) ($newsItem['excerpt'] ?? ''));
                    if ($excerpt === '') {
                        $excerpt = mb_substr(strip_tags((string) $newsItem['content']), 0, 180);
                    }
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
                            <div class="overlay overflow-hidden">
                                <img class="w-100 h-200px object-fit-cover" src="<?= esc($thumbnail !== '' ? base_url(ltrim($thumbnail, '/')) : base_url('assets/media/stock/600x400/img-1.jpg'), 'attr') ?>" alt="<?= esc($newsItem['title'], 'attr') ?>">
                            </div>
                            <div class="card-body p-6">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge badge-light-primary fs-8 fw-semibold">Berita</span>
                                    <span class="text-muted fs-7"><?= ! empty($newsItem['published_at']) ? esc(date('d M Y', strtotime($newsItem['published_at']))) : '' ?></span>
                                </div>
                                <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($newsItem['title']) ?></h3>
                                <p class="text-muted fs-6 mb-0"><?= nl2br(esc($excerpt)) ?></p>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (! $hasNewsRecords): ?>
            <?php if ($landingPage['news_fallback_rows_items'] !== []): ?>
                <?php $newsColors = ['primary', 'success', 'warning']; ?>
                <div class="row g-8">
                    <?php foreach ($landingPage['news_fallback_rows_items'] as $index => [$category, $date, $title, $description, $image]): ?>
                        <?php
                        $color = $newsColors[$index % count($newsColors)];
                        $imageUrl = base_url(ltrim($image, '/'));
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <article class="card card-flush h-100 border border-gray-200 overflow-hidden hover-elevate-up shadow-sm">
                                <div class="overlay overflow-hidden">
                                    <img class="w-100 h-200px object-fit-cover" src="<?= esc($imageUrl, 'attr') ?>" alt="<?= esc($title, 'attr') ?>">
                                </div>
                                <div class="card-body p-6 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <span class="badge badge-light-<?= esc($color) ?> fs-8 fw-semibold"><?= esc($category) ?></span>
                                            <span class="text-muted fs-7"><?= esc($date) ?></span>
                                        </div>
                                        <h3 class="fs-4 fw-bold text-gray-900 mb-3"><?= esc($title) ?></h3>
                                        <p class="text-muted fs-6 mb-4"><?= nl2br(esc($description)) ?></p>
                                    </div>
                                    <a href="#aspirations" class="link-primary fw-semibold fs-6 d-inline-flex align-items-center" data-kt-scroll-toggle="true">
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

