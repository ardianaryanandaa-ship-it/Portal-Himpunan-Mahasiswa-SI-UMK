<!--begin::FAQ Section-->
<?php
$fallbackFaqs = [
    ['Apa itu HIMA SI Universitas Muria Kudus?', 'HIMA SI (Himpunan Mahasiswa Sistem Informasi) adalah organisasi kemahasiswaan resmi di bawah naungan Program Studi Sistem Informasi, Fakultas Teknik, Universitas Muria Kudus. Himpunan ini berfungsi sebagai wadah aspirasi, peningkatan kompetensi teknologi, serta pembinaan karakter mahasiswa.'],
    ['Siapa saja yang otomatis menjadi anggota HIMA SI?', 'Seluruh mahasiswa aktif yang terdaftar di Program Studi Sistem Informasi Fakultas Teknik Universitas Muria Kudus secara otomatis adalah anggota HIMA SI dan berhak mengikuti seluruh program serta kegiatan yang diselenggarakan.'],
    ['Bagaimana cara bergabung menjadi Pengurus HIMA SI?', 'Rekrutmen pengurus baru (Open Recruitment) diadakan setiap satu tahun sekali menjelang pergantian periode kepengurusan. Proses seleksi meliputi pendaftaran berkas administrasi, wawancara kepribadian/kompetensi divisi, dan masa magang pengurus.'],
    ['Apa saja manfaat yang didapatkan dengan aktif berorganisasi di HIMA SI?', 'Anda akan mendapatkan pengalaman kepemimpinan riil, mengasah kemampuan kerja sama tim (teamwork), manajemen acara (event management), sertifikat keaktifan berorganisasi (SKPI), serta jaringan relasi luas dengan dosen, alumni, dan profesional industri IT.'],
    ['Apakah workshop koding dan bootcamp terbuka untuk pemula?', 'Tentu saja! Sebagian besar pelatihan dan workshop koding yang kami adakan dirancang berjenjang dari level dasar (beginner-friendly) dengan didampingi mentor mahasiswa senior dan praktisi agar mudah dipahami oleh seluruh peserta.'],
];
?>
<div class="py-10 py-lg-20 bg-light" id="faq">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Badge-->
            <span class="badge badge-light-primary fs-7 fw-bold mb-3 px-4 py-2 text-uppercase">
                Tanya Jawab Umum
            </span>
            <!--end::Badge-->

            <!--begin::Title-->
            <h2 class="fs-2hx text-gray-900 mb-5" data-kt-scroll-offset="{default: 100, lg: 150}">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h2>
            <!--end::Title-->

            <!--begin::Description-->
            <div class="fs-5 text-muted fw-semibold max-w-700px mx-auto">
                Temukan jawaban atas berbagai pertanyaan umum seputar keanggotaan, kepengurusan, dan program kegiatan HIMA SI UMK.
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->

        <!--begin::Row Accordion-->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!--begin::Accordion-->
                <div class="accordion accordion-flush" id="kt_accordion_faq">
                    <?php if (! empty($faqs)): ?>
                        <?php foreach ($faqs as $faq): ?>
                            <div class="accordion-item mb-4 rounded-3 border border-gray-200 bg-white shadow-sm overflow-hidden">
                                <h2 class="accordion-header" id="faq_header_<?= esc((string) $faq['id']) ?>">
                                    <button class="accordion-button fs-5 fw-bold text-gray-800 collapsed py-5 px-6" type="button" data-bs-toggle="collapse" data-bs-target="#faq_body_<?= esc((string) $faq['id']) ?>" aria-expanded="false" aria-controls="faq_body_<?= esc((string) $faq['id']) ?>">
                                        <i class="ki-duotone ki-question-2 fs-3 text-primary me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <?= esc($faq['question']) ?>
                                    </button>
                                </h2>
                                <div id="faq_body_<?= esc((string) $faq['id']) ?>" class="accordion-collapse collapse" aria-labelledby="faq_header_<?= esc((string) $faq['id']) ?>" data-bs-parent="#kt_accordion_faq">
                                    <div class="accordion-body text-gray-600 fs-6 pt-0 px-6 pb-6">
                                        <span class="badge badge-light-primary mb-3"><?= esc($faq['category']) ?></span>
                                        <div><?= nl2br(esc($faq['answer'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif (! $hasFaqRecords): ?>
                        <?php if ($fallbackFaqs !== []): ?>
                            <?php foreach ($fallbackFaqs as $index => [$question, $answer]): ?>
                                <?php $faqId = 'landing_faq_' . $index; ?>
                                <div class="accordion-item mb-4 rounded-3 border border-gray-200 bg-white shadow-sm overflow-hidden">
                                    <h2 class="accordion-header" id="<?= esc($faqId) ?>_header">
                                        <button class="accordion-button fs-5 fw-bold text-gray-800 collapsed py-5 px-6" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($faqId) ?>_body" aria-expanded="false" aria-controls="<?= esc($faqId) ?>_body">
                                            <i class="ki-duotone ki-question-2 fs-3 text-primary me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            <?= esc($question) ?>
                                        </button>
                                    </h2>
                                    <div id="<?= esc($faqId) ?>_body" class="accordion-collapse collapse" aria-labelledby="<?= esc($faqId) ?>_header" data-bs-parent="#kt_accordion_faq">
                                        <div class="accordion-body text-gray-600 fs-6 pt-0 px-6 pb-6"><?= nl2br(esc($answer)) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center text-muted py-5 mb-0">Belum ada FAQ aktif.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-5 mb-0">Belum ada FAQ aktif.</p>
                    <?php endif; ?>
                </div>
                <!--end::Accordion-->

                <!--begin::Help Banner-->
                <div class="card bg-white border border-gray-200 rounded-4 p-8 mt-10 shadow-sm text-center">
                    <h4 class="fs-4 fw-bold text-gray-900 mb-2">Masih Memiliki Pertanyaan Lain?</h4>
                    <p class="text-muted fs-6 mb-5">Pengurus kami siap membantu menjawab pertanyaan Anda melalui kanal komunikasi resmi kami.</p>
                    <div class="d-flex flex-center flex-wrap gap-3">
                        <a href="mailto:himasi@umk.ac.id" class="btn btn-sm btn-light-primary fw-semibold">
                            <i class="ki-duotone ki-sms fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                            himasi@umk.ac.id
                        </a>
                        <a href="#aspirations" class="btn btn-sm btn-primary fw-semibold" data-kt-scroll-toggle="true">
                            <i class="ki-duotone ki-messages fs-4 me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            Kirim Pertanyaan / Aspirasi
                        </a>
                    </div>
                </div>
                <!--end::Help Banner-->
            </div>
        </div>
        <!--end::Row Accordion-->
    </div>
    <!--end::Container-->
</div>
<!--end::FAQ Section-->

