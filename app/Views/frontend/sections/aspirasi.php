<!--begin::Aspirations Section-->
<!-- Menampilkan aspirasi publik, testimoni yang dipublikasikan, dan formulir pengiriman aspirasi. -->
<?php
$fallbackTestimonials = [
    ['Tempat Belajar Soft Skill Terbaik', 'Aktif di HIMA SI mengajarkan saya cara memimpin tim, problem solving dalam tekanan, dan membangun relasi kerja yang solid.', 'Ahmad Rizky Pratama', 'Mahasiswa SI Angkatan 2021'],
    ['Workshop Sangat Relevan Industri', 'Materi bootcamp koding dan UI/UX yang diadakan HIMA SI sangat aplikatif dan membantu saya ketika melamar magang di tech company.', 'Siti Nurhaliza', 'Alumni Sistem Informasi UMK'],
    ['Solid, Terbuka, & Kolaboratif', 'Sebagai mahasiswa baru, saya merasa sangat dirangkul oleh para senior. Suasana kekeluargaan di HIMA SI UMK luar biasa hangat!', 'Bagas Dwi Saputra', 'Mahasiswa SI Angkatan 2023'],
];
?>
<div class="py-10 py-lg-20" id="aspirations">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-15">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Aspirasi &amp; Testimoni
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" id="clients" data-kt-scroll-offset="{default: 125, lg: 150}">
                Suara Mahasiswa &amp; Alumni
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Ruang keterbukaan untuk mendengarkan kesan, ide konstruktif, dan aspirasi demi kemajuan iklim akademik serta organisasi HIMA SI UMK.
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row Testimonials-->
        <!-- Testimoni dipakai dari aspirasi yang dipublikasikan, jika kosong memakai data statis sebagai fallback. -->
        <?php $testimonialColors = ['primary', 'success', 'warning']; ?>
        <div class="row g-lg-10 mb-10 mb-lg-18">
            <?php
            $testimonialItems = [];
            foreach (($publishedAspirations ?? []) as $aspiration) {
                $testimonialItems[] = [
                    $aspiration['subject'],
                    $aspiration['message'],
                    $aspiration['published_name'] ?: ($aspiration['is_anonymous'] ? 'Penyumbang Anonim' : ($aspiration['name'] ?: 'Mahasiswa')),
                    $aspiration['published_role'] ?: 'Aspirasi ' . ucfirst($aspiration['category']),
                ];
            }
            if ($testimonialItems === []) {
                $testimonialItems = $fallbackTestimonials;
            }
            ?>
            <?php foreach ($testimonialItems as $index => [$title, $description, $name, $role]): ?>
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
                    <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-3 py-2">KOTAK ASPIRASI ONLINE</span>
                    <h3 class="fs-2hx fw-bold text-gray-900 mb-4">Punya Ide atau Masukan untuk HIMA SI?</h3>
                    <p class="fs-6 text-gray-600 mb-6">
                        Sampaikan kritik, ide program kerja, saran fasilitas laboratorium, maupun aspirasi lainnya secara terbuka atau anonim. Setiap masukan sangat berharga bagi kami.
                    </p>
                    <div class="d-flex align-items-center text-gray-700 fs-6">
                        <i class="ki-duotone ki-shield-tick fs-2 text-success me-3"><span class="path1"></span><span class="path2"></span></i>
                        Kerahasiaan data dan pesan Anda terjamin aman.
                    </div>
                </div>
                <div class="col-lg-7">
                    <?php if ($message = session()->getFlashdata('aspiration_success')): ?>
                        <div class="alert alert-success"><?= esc($message) ?></div>
                    <?php endif; ?>
                    <?php if ($errors = session()->getFlashdata('aspiration_errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <div><?= esc($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($message = session()->getFlashdata('aspiration_error')): ?>
                        <div class="alert alert-danger"><?= esc($message) ?></div>
                    <?php endif; ?>
                    <form id="form-aspirasi" method="post" action="<?= site_url('aspirasi') ?>">
                        <?= csrf_field() ?>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="aspiration-name" class="form-label fs-7 fw-bold text-gray-700">Nama (Opsional)</label>
                                <input id="aspiration-name" name="name" type="text" maxlength="150" class="form-control form-control-solid" value="<?= esc(old('name')) ?>" placeholder="Nama Anda..." />
                            </div>
                            <div class="col-md-6">
                                <label for="aspiration-nim" class="form-label fs-7 fw-bold text-gray-700">NIM (Opsional)</label>
                                <input id="aspiration-nim" name="nim" type="text" maxlength="30" class="form-control form-control-solid" value="<?= esc(old('nim')) ?>" placeholder="Nomor induk mahasiswa..." />
                            </div>
                            <div class="col-md-6">
                                <label for="aspiration-email" class="form-label fs-7 fw-bold text-gray-700">Email (Opsional)</label>
                                <input id="aspiration-email" name="email" type="email" maxlength="150" class="form-control form-control-solid" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" />
                            </div>
                            <div class="col-md-6">
                                <label for="aspiration-phone" class="form-label fs-7 fw-bold text-gray-700">Nomor Telepon (Opsional)</label>
                                <input id="aspiration-phone" name="phone" type="tel" maxlength="30" class="form-control form-control-solid" value="<?= esc(old('phone')) ?>" placeholder="08..." />
                            </div>
                            <div class="col-md-6">
                                <label for="aspiration-category" class="form-label fs-7 fw-bold text-gray-700">Kategori Aspirasi</label>
                                <select id="aspiration-category" name="category" class="form-select form-select-solid" required>
                                    <?php $category = old('category', 'kegiatan'); ?>
                                    <option value="kegiatan" <?= $category === 'kegiatan' ? 'selected' : '' ?>>Kegiatan &amp; Acara</option>
                                    <option value="akademik" <?= $category === 'akademik' ? 'selected' : '' ?>>Akademik &amp; Fasilitas</option>
                                    <option value="organisasi" <?= $category === 'organisasi' ? 'selected' : '' ?>>Saran untuk Organisasi</option>
                                    <option value="lainnya" <?= $category === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="aspiration-subject" class="form-label fs-7 fw-bold text-gray-700">Judul Aspirasi</label>
                                <input id="aspiration-subject" name="subject" type="text" maxlength="150" class="form-control form-control-solid" value="<?= esc(old('subject')) ?>" required placeholder="Ringkasan aspirasi..." />
                            </div>
                            <div class="col-12">
                                <label for="aspiration-message" class="form-label fs-7 fw-bold text-gray-700">Pesan Aspirasi &amp; Masukan</label>
                                <textarea id="aspiration-message" name="message" class="form-control form-control-solid" rows="4" maxlength="5000" placeholder="Tuliskan aspirasi atau ide Anda di sini..." required><?= esc(old('message')) ?></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is-anonymous" name="is_anonymous" value="1" <?= old('is_anonymous') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-gray-700" for="is-anonymous">Kirim sebagai aspirasi anonim</label>
                                </div>
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

