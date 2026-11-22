<!--begin::Aspirations Section-->
<div class="py-10 py-lg-20" id="aspirations">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-15">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                <?= esc($landingPage['testimonials_badge']) ?>
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" id="clients" data-kt-scroll-offset="{default: 125, lg: 150}">
                <?= esc($landingPage['testimonials_title']) ?>
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                <?= nl2br(esc($landingPage['testimonials_description'])) ?>
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row Testimonials-->
        <?php $testimonialColors = ['primary', 'success', 'warning']; ?>
        <div class="row g-lg-10 mb-10 mb-lg-18">
            <?php foreach ($landingPage['testimonial_rows_items'] as $index => [$title, $description, $name, $role]): ?>
                <?php $color = $testimonialColors[$index % count($testimonialColors)]; ?>
                <div class="col-lg-4">
                    <div class="card card-flush h-100 p-8 border border-gray-200 shadow-sm hover-elevate-up d-flex flex-column justify-content-between">
                        <div class="mb-6">
                            <div class="rating mb-4">
                                <?php for ($star = 0; $star < 5; $star++): ?>
                                    <div class="rating-label me-1 checked"><i class="ki-duotone ki-star fs-5 text-warning"></i></div>
                                <?php endfor; ?>
                            </div>
                            <h4 class="fs-4 fw-bold text-gray-900 mb-3">&ldquo;<?= esc($title) ?>&rdquo;</h4>
                            <p class="text-muted fs-6 mb-0"><?= nl2br(esc($description)) ?></p>
                        </div>
                        <div class="d-flex align-items-center pt-4 border-top border-gray-100">
                            <div class="symbol symbol-circle symbol-50px me-4">
                                <div class="symbol-label bg-light-<?= esc($color) ?>">
                                    <i class="ki-duotone ki-user fs-2 text-<?= esc($color) ?>"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-900 fw-bold fs-6 d-block"><?= esc($name) ?></span>
                                <span class="text-muted fs-7"><?= esc($role) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--end::Row Testimonials-->

        <!--begin::Form Aspirasi Kotak Saran-->
        <div class="card card-flush border border-gray-200 rounded-4 p-8 p-lg-12 shadow-sm">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-8 mb-lg-0">
                    <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-3 py-2"><?= esc($landingPage['aspiration_badge']) ?></span>
                    <h3 class="fs-2hx fw-bold text-gray-900 mb-4"><?= esc($landingPage['aspiration_title']) ?></h3>
                    <p class="fs-6 text-gray-600 mb-6">
                        <?= nl2br(esc($landingPage['aspiration_description'])) ?>
                    </p>
                    <div class="d-flex align-items-center text-gray-700 fs-6">
                        <i class="ki-duotone ki-shield-tick fs-2 text-success me-3"><span class="path1"></span><span class="path2"></span></i>
                        <?= esc($landingPage['aspiration_privacy']) ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form onsubmit="event.preventDefault(); alert('Terima kasih! Aspirasi Anda telah berhasil dikirim ke pengurus HIMA SI.');">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fs-7 fw-bold text-gray-700">Nama (Boleh Dikosongkan / Anonim)</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Nama Anda..." />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fs-7 fw-bold text-gray-700">Kategori Aspirasi</label>
                                <select class="form-select form-select-solid">
                                    <option value="kegiatan">Kegiatan &amp; Acara</option>
                                    <option value="akademik">Akademik &amp; Fasilitas</option>
                                    <option value="organisasi">Saran untuk Organisasi</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fs-7 fw-bold text-gray-700">Pesan Aspirasi &amp; Masukan</label>
                                <textarea class="form-control form-control-solid" rows="4" placeholder="Tuliskan aspirasi atau ide Anda di sini..." required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-8 py-3 fw-semibold">
                                    <i class="ki-duotone ki-send fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                                    Kirim Aspirasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Form Aspirasi Kotak Saran-->
    </div>
    <!--end::Container-->
</div>
<!--end::Aspirations Section-->

