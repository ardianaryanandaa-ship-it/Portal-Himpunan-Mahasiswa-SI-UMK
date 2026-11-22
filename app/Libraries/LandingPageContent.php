<?php

namespace App\Libraries;

class LandingPageContent
{
    public const SETTING_GROUP = 'landing_page';

    private const ITEM_TABLES = [
        'hero_typed_texts' => 'landing_page_hero_typed_texts',
        'hero_highlights' => 'landing_page_hero_highlights',
        'about_cards' => 'landing_page_about_cards',
        'mission_rows' => 'landing_page_missions',
        'organization_bph_rows' => 'landing_page_bph',
        'organization_department_rows' => 'landing_page_departments',
        'program_rows' => 'landing_page_program_items',
        'events_fallback_rows' => 'landing_page_event_examples',
        'testimonial_rows' => 'landing_page_testimonial_items',
    ];

    private const GROUPS = [
        'hero' => [
            'label' => 'Hero / Beranda',
            'fields' => [
                'hero_badge' => ['label' => 'Label organisasi', 'type' => 'text', 'default' => 'Himpunan Mahasiswa Sistem Informasi • Universitas Muria Kudus'],
                'hero_title_lead' => ['label' => 'Judul utama baris pertama', 'type' => 'text', 'default' => 'Bersama Membangun'],
                'hero_title_secondary' => ['label' => 'Judul utama baris kedua', 'type' => 'text', 'default' => 'Generasi Digital &'],
                'hero_typed_texts' => ['label' => 'Teks bergantian', 'type' => 'textarea', 'default' => "Masa Depan Teknologi\nGenerasi Unggul\nInovasi & Kreativitas\nPrestasi & Kolaborasi", 'help' => 'Satu kalimat per baris.'],
                'hero_description' => ['label' => 'Deskripsi hero', 'type' => 'textarea', 'default' => 'Wadah pengembangan potensi, kepemimpinan, riset teknologi, kreativitas, dan kolaborasi mahasiswa Sistem Informasi Fakultas Teknik Universitas Muria Kudus.'],
                'hero_button_about' => ['label' => 'Tombol tentang kami', 'type' => 'text', 'default' => 'Kenali Kami'],
                'hero_button_programs' => ['label' => 'Tombol program kerja', 'type' => 'text', 'default' => 'Program Kerja'],
                'hero_button_events' => ['label' => 'Tombol kegiatan', 'type' => 'text', 'default' => 'Lihat Kegiatan'],
                'hero_highlights' => ['label' => 'Sorotan hero', 'type' => 'textarea', 'default' => "HIMA SI|Organisasi Mahasiswa\nUMK|Universitas Muria Kudus\nSistem Informasi|Fakultas Teknik\nInovatif & Unggul|Riset & Kolaborasi", 'help' => 'Satu item per baris dengan format: Judul|Keterangan.', 'row_columns' => 2],
            ],
        ],
        'about' => [
            'label' => 'Tentang Kami',
            'fields' => [
                'about_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Tentang Kami'],
                'about_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Mengenal HIMA SI UMK'],
                'about_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Himpunan Mahasiswa Sistem Informasi (HIMA SI) merupakan organisasi kemahasiswaan di tingkat Program Studi Sistem Informasi, Fakultas Teknik, Universitas Muria Kudus.'],
                'about_cards' => ['label' => 'Kartu tentang kami', 'type' => 'textarea', 'default' => "Keilmuan & Teknologi|Mendukung peningkatan kompetensi akademik, penguasaan rekayasa sistem informasi, data, kecerdasan buatan, dan pengembangan perangkat lunak.\nKepemimpinan & Karakter|Membina jiwa kepemimpinan, manajemen organisasi, komunikasi efektif, dan integritas profesional mahasiswa agar siap bersaing global.\nKolaborasi & Pengabdian|Menjalin kemitraan strategis dengan industri, perguruan tinggi, serta menghadirkan program pengabdian masyarakat berbasis teknologi digital.", 'help' => 'Satu kartu per baris dengan format: Judul|Deskripsi.', 'row_columns' => 2],
                'about_highlight_title' => ['label' => 'Judul kotak sorotan', 'type' => 'text', 'default' => 'Rumah Bersama Mahasiswa Sistem Informasi'],
                'about_highlight_description' => ['label' => 'Deskripsi kotak sorotan', 'type' => 'textarea', 'default' => 'HIMA SI UMK berdiri dengan semangat kekeluargaan, profesionalisme, dan integritas tinggi untuk mendorong setiap insan mahasiswa mencapai prestasi terbaiknya selama menempuh pendidikan di Universitas Muria Kudus.'],
            ],
        ],
        'vision' => [
            'label' => 'Visi & Misi',
            'fields' => [
                'vision_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Visi & Misi'],
                'vision_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Landasan & Komitmen Kami'],
                'vision_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Prinsip dan arah strategis yang menjadi pedoman HIMA SI UMK dalam menjalankan amanah organisasi dan pengabdian.'],
                'vision_heading' => ['label' => 'Judul visi', 'type' => 'text', 'default' => 'Visi Kami'],
                'vision_statement' => ['label' => 'Isi visi', 'type' => 'textarea', 'default' => 'Menjadi organisasi kemahasiswaan yang unggul, profesional, inovatif, dan berdaya saing tinggi dalam pengembangan teknologi informasi serta mencetak lulusan berjiwa kepemimpinan yang berakhlak mulia.'],
                'mission_rows' => ['label' => 'Daftar misi', 'type' => 'textarea', 'default' => "Eksplorasi Keilmuan|Menyelenggarakan pelatihan, workshop, dan mentoring teknologi terkini guna menunjang kurikulum perkuliahan.\nIntegritas Organisasi|Mengembangkan tata kelola himpunan yang transparan, akuntabel, solid, dan berlandaskan asas kekeluargaan.\nInovasi & Prestasi|Memfasilitasi minat dan bakat mahasiswa untuk berkompetisi dan berprestasi di tingkat regional maupun nasional.\nSinergi Kemitraan|Membangun relasi aktif dengan industri, alumni, asosiasi profesi (seperti Permikomnas), dan masyarakat.", 'help' => 'Satu misi per baris dengan format: Judul|Deskripsi.', 'row_columns' => 2],
            ],
        ],
        'organization' => [
            'label' => 'Struktur Pengurus',
            'fields' => [
                'organization_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Struktur Pengurus'],
                'organization_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Pengurus HIMA SI UMK'],
                'organization_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Bersama menjalankan organisasi melalui kepemimpinan dan kolaborasi setiap departemen.'],
                'organization_bph_title' => ['label' => 'Judul badan pengurus harian', 'type' => 'text', 'default' => 'Badan Pengurus Harian'],
                'organization_bph_description' => ['label' => 'Deskripsi badan pengurus harian', 'type' => 'text', 'default' => 'Enam pengurus yang mengoordinasikan jalannya organisasi.'],
                'organization_bph_rows' => ['label' => 'Posisi badan pengurus harian', 'type' => 'textarea', 'default' => "Ketua|Memimpin organisasi dan mengoordinasikan arah kerja HIMA SI.\nWakil Ketua|Mendampingi Ketua dan membantu koordinasi kegiatan organisasi.\nBendahara 1|Membantu pengelolaan dan pencatatan keuangan organisasi.\nBendahara 2|Mendukung administrasi keuangan dan penyusunan laporan.\nSekre 1|Mendukung administrasi, persuratan, dan dokumentasi organisasi.\nSekre 2|Membantu pengarsipan dan kebutuhan administrasi kegiatan.", 'help' => 'Satu posisi per baris dengan format: Jabatan|Deskripsi.', 'row_columns' => 2],
                'organization_department_badge' => ['label' => 'Label departemen', 'type' => 'text', 'default' => 'Lima Departemen'],
                'organization_department_title' => ['label' => 'Judul departemen', 'type' => 'text', 'default' => 'Departemen HIMA SI'],
                'organization_department_description' => ['label' => 'Deskripsi departemen', 'type' => 'text', 'default' => 'Bidang kerja yang mendukung pengembangan mahasiswa dan organisasi.'],
                'organization_department_rows' => ['label' => 'Daftar departemen', 'type' => 'textarea', 'default' => "PSDM|Pengembangan Sumber Daya Mahasiswa|Berfokus pada pengembangan kapasitas, potensi, dan kebersamaan mahasiswa.\nKAKA|Kajian Keilmuan|Mendorong kegiatan kajian dan pengembangan wawasan keilmuan Sistem Informasi.\nHUBLU|Hubungan Luar|Menjalin komunikasi dan hubungan dengan pihak di luar HIMA SI.\nMIKAT|Minat dan Bakat|Mewadahi minat, bakat, kreativitas, dan kegiatan nonakademik mahasiswa.\nEKRAF|Ekonomi Kreatif|Mengembangkan kreativitas dan potensi ekonomi di lingkungan HIMA SI.", 'help' => 'Satu departemen per baris dengan format: Singkatan|Nama|Deskripsi.', 'row_columns' => 3],
            ],
        ],
        'programs' => [
            'label' => 'Program Unggulan',
            'fields' => [
                'programs_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Program Unggulan'],
                'programs_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'INSYS FEST'],
                'programs_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Festival Sistem Informasi yang menghadirkan kompetisi, kreativitas, dan kebersamaan dalam satu rangkaian acara.'],
                'program_rows' => ['label' => 'Daftar program', 'type' => 'textarea', 'default' => "Kompetisi Utama|Insys Competition|Kompetisi utama dan acara terbesar dalam rangkaian INSYS FEST.\nDesain Digital|UI/UX Competition|Kompetisi perancangan antarmuka dan pengalaman pengguna.\nKewirausahaan|BPC|Bisnis Plan Competition untuk gagasan dan rencana bisnis.\nKebersamaan|Insys Fun Game|Kegiatan permainan untuk membangun kebersamaan dan semangat sportif.", 'help' => 'Satu program per baris dengan format: Kategori|Nama|Deskripsi.', 'row_columns' => 3],
            ],
        ],
        'events' => [
            'label' => 'Judul Bagian Kegiatan',
            'fields' => [
                'events_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Agenda & Kegiatan'],
                'events_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Agenda Kegiatan Mendatang'],
                'events_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Jangan lewatkan kesempatan menambah wawasan, pengalaman, dan jejaring melalui kegiatan resmi HIMA SI UMK.'],
                'events_fallback_rows' => ['label' => 'Contoh kegiatan saat belum ada data kegiatan', 'type' => 'textarea', 'default' => "15 DES|2024|Pendaftaran Buka|Seminar Nasional|AI & The Future of Enterprise Information Systems|Membahas tren implementasi kecerdasan buatan dalam otomatisasi bisnis dan rekayasa data perusahaan modern.|Auditorium Universitas Muria Kudus\n22 DES|2024|Segera Hadir|Workshop Desain|Hands-On UI/UX Design & Prototyping Figma|Pelatihan intensif praktik membuat wireframe, interactive prototype, dan design system profesional di Figma.|Lab Komputer Gedung F, FT UMK\n10 JAN|2025|Mendatang|Temu Akrab & Sharing|SI Annual Gathering & Alumni Career Talk|Temu kangen lintas angkatan serta sesi berbagi kiat sukses berkarir di industri IT langsung dari para alumni berprestasi.|Hall Gedung Rektorat Lt. 4 UMK", 'help' => 'Satu kegiatan per baris dengan format: Tanggal|Tahun|Status|Kategori|Judul|Deskripsi|Lokasi.', 'row_columns' => 7],
            ],
        ],
        'achievements' => [
            'label' => 'Judul Bagian Prestasi',
            'fields' => [
                'achievements_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Prestasi & Jejak Langkah'],
                'achievements_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Bukti Nyata Kinerja & Capaian'],
                'achievements_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Dedikasi segenap pengurus dan mahasiswa Sistem Informasi Universitas Muria Kudus yang tercermin dalam angka dan prestasi membanggakan.'],
                'achievements_stat_fallback' => ['label' => 'Angka awal prestasi jika belum ada data', 'type' => 'number', 'rules' => 'required|integer|greater_than_equal_to[0]', 'default' => '30'],
                'achievements_stat_label' => ['label' => 'Label jumlah prestasi', 'type' => 'text', 'default' => 'Prestasi Lomba'],
                'members_stat_value' => ['label' => 'Angka mahasiswa aktif', 'type' => 'number', 'rules' => 'required|integer|greater_than_equal_to[0]', 'default' => '500'],
                'members_stat_label' => ['label' => 'Label mahasiswa aktif', 'type' => 'text', 'default' => 'Mahasiswa Aktif'],
                'program_stat_value' => ['label' => 'Angka program kerja', 'type' => 'number', 'rules' => 'required|integer|greater_than_equal_to[0]', 'default' => '25'],
                'program_stat_label' => ['label' => 'Label program kerja', 'type' => 'text', 'default' => 'Program Kerja'],
                'partner_stat_value' => ['label' => 'Angka mitra dan relasi', 'type' => 'number', 'rules' => 'required|integer|greater_than_equal_to[0]', 'default' => '12'],
                'partner_stat_label' => ['label' => 'Label mitra dan relasi', 'type' => 'text', 'default' => 'Mitra & Relasi'],
                'achievements_quote' => ['label' => 'Kutipan prestasi', 'type' => 'textarea', 'default' => 'HIMA SI adalah wadah terbaik bagi mahasiswa untuk tidak hanya belajar kode dan sistem, tetapi juga mengasah jiwa kepemimpinan, integritas, dan kepedulian sosial.'],
                'achievements_quote_author' => ['label' => 'Afiliasi kutipan', 'type' => 'text', 'default' => 'Program Studi Sistem Informasi'],
                'achievements_quote_affiliation' => ['label' => 'Fakultas kutipan', 'type' => 'text', 'default' => 'Fakultas Teknik Universitas Muria Kudus'],
            ],
        ],
        'gallery' => [
            'label' => 'Judul Bagian Galeri',
            'fields' => [
                'gallery_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Dokumentasi & Jejak Karya'],
                'gallery_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Galeri Aktivitas HIMA SI'],
                'gallery_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Momen-momen berharga dan kebersamaan dalam setiap agenda, kompetisi, dan program kerja HIMA SI UMK.'],
                'gallery_fallback_rows' => ['label' => 'Contoh gambar saat belum ada data galeri', 'type' => 'textarea', 'default' => "Semua Momen|assets/media/stock/600x600/img-23.jpg\nSemua Momen|assets/media/stock/600x600/img-22.jpg\nSemua Momen|assets/media/stock/600x600/img-21.jpg\nSemua Momen|assets/media/stock/600x600/img-20.jpg\nWorkshop & Seminar|assets/media/stock/600x600/img-11.jpg\nWorkshop & Seminar|assets/media/stock/600x600/img-12.jpg\nWorkshop & Seminar|assets/media/stock/600x600/img-16.jpg\nWorkshop & Seminar|assets/media/stock/600x600/img-15.jpg\nKompetisi & Prestasi|assets/media/stock/600x600/img-15.jpg\nKompetisi & Prestasi|assets/media/stock/600x600/img-22.jpg\nKompetisi & Prestasi|assets/media/stock/600x600/img-21.jpg\nKompetisi & Prestasi|assets/media/stock/600x600/img-14.jpg\nMakrab & Sosial|assets/media/stock/600x600/img-23.jpg\nMakrab & Sosial|assets/media/stock/600x600/img-12.jpg\nMakrab & Sosial|assets/media/stock/600x600/img-16.jpg\nMakrab & Sosial|assets/media/stock/600x600/img-20.jpg", 'help' => 'Satu gambar per baris dengan format: Kategori|Path relatif dari public/.', 'row_columns' => 2],
            ],
        ],
        'news' => [
            'label' => 'Judul Bagian Berita',
            'fields' => [
                'news_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Kabar & Informasi'],
                'news_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Berita & Artikel Terkini'],
                'news_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Update terkini mengenai kegiatan organisasi, prestasi mahasiswa, dan informasi penting di lingkungan Sistem Informasi UMK.'],
                'news_fallback_rows' => ['label' => 'Contoh berita saat belum ada data berita', 'type' => 'textarea', 'default' => "Akademik & IT|18 Nov 2024|HIMA SI UMK Sukses Gelar Workshop Web Modern & REST API|Pelatihan hands-on intensif diikuti oleh lebih dari 100 mahasiswa untuk meningkatkan kapabilitas software engineering.|assets/media/stock/600x400/img-1.jpg\nPrestasi|12 Nov 2024|Delegasi Mahasiswa SI Sabet Juara dalam Hackathon Nasional|Inovasi aplikasi smart agriculture berbasis IoT mengantarkan tim mahasiswa Sistem Informasi UMK meraih podium kejuaraan.|assets/media/stock/600x400/img-2.jpg\nOrganisasi|05 Nov 2024|Open Recruitment Pengurus HIMA SI: Bersama Bertumbuh & Mengabdi|Kesempatan emas bagi seluruh mahasiswa aktif Sistem Informasi untuk mengasah kepemimpinan dan memperluas relasi.|assets/media/stock/600x400/img-3.jpg", 'help' => 'Satu berita per baris dengan format: Kategori|Tanggal|Judul|Ringkasan|Path gambar relatif dari public/.', 'row_columns' => 5],
            ],
        ],
        'testimonials' => [
            'label' => 'Aspirasi & Testimoni',
            'fields' => [
                'testimonials_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Aspirasi & Testimoni'],
                'testimonials_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Suara Mahasiswa & Alumni'],
                'testimonials_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Ruang keterbukaan untuk mendengarkan kesan, ide konstruktif, dan aspirasi demi kemajuan iklim akademik serta organisasi HIMA SI UMK.'],
                'testimonial_rows' => ['label' => 'Testimoni', 'type' => 'textarea', 'default' => "Tempat Belajar Soft Skill Terbaik|Aktif di HIMA SI mengajarkan saya cara memimpin tim, problem solving dalam tekanan, dan membangun relasi kerja yang solid.|Ahmad Rizky Pratama|Mahasiswa SI Angkatan 2021\nWorkshop Sangat Relevan Industri|Materi bootcamp koding dan UI/UX yang diadakan HIMA SI sangat aplikatif dan membantu saya ketika melamar magang di tech company.|Siti Nurhaliza|Alumni Sistem Informasi UMK\nSolid, Terbuka, & Kolaboratif|Sebagai mahasiswa baru, saya merasa sangat dirangkul oleh para senior. Suasana kekeluargaan di HIMA SI UMK luar biasa hangat!|Bagas Dwi Saputra|Mahasiswa SI Angkatan 2023", 'help' => 'Satu testimoni per baris dengan format: Judul|Isi|Nama|Peran.', 'row_columns' => 4],
                'aspiration_badge' => ['label' => 'Label kotak aspirasi', 'type' => 'text', 'default' => 'KOTAK ASPIRASI ONLINE'],
                'aspiration_title' => ['label' => 'Judul kotak aspirasi', 'type' => 'text', 'default' => 'Punya Ide atau Masukan untuk HIMA SI?'],
                'aspiration_description' => ['label' => 'Deskripsi kotak aspirasi', 'type' => 'textarea', 'default' => 'Sampaikan kritik, ide program kerja, saran fasilitas laboratorium, maupun aspirasi lainnya secara terbuka atau anonim. Setiap masukan sangat berharga bagi kami.'],
                'aspiration_privacy' => ['label' => 'Pesan privasi', 'type' => 'text', 'default' => 'Kerahasiaan data dan pesan Anda terjamin aman.'],
            ],
        ],
        'faq' => [
            'label' => 'Judul Bagian FAQ',
            'fields' => [
                'faq_badge' => ['label' => 'Label bagian', 'type' => 'text', 'default' => 'Tanya Jawab Umum'],
                'faq_title' => ['label' => 'Judul bagian', 'type' => 'text', 'default' => 'Pertanyaan yang Sering Diajukan (FAQ)'],
                'faq_description' => ['label' => 'Deskripsi bagian', 'type' => 'textarea', 'default' => 'Temukan jawaban atas berbagai pertanyaan umum seputar keanggotaan, kepengurusan, dan program kegiatan HIMA SI UMK.'],
                'faq_fallback_rows' => ['label' => 'FAQ contoh saat belum ada data FAQ', 'type' => 'textarea', 'default' => "Apa itu HIMA SI Universitas Muria Kudus?|HIMA SI (Himpunan Mahasiswa Sistem Informasi) adalah organisasi kemahasiswaan resmi di bawah naungan Program Studi Sistem Informasi, Fakultas Teknik, Universitas Muria Kudus. Himpunan ini berfungsi sebagai wadah aspirasi, peningkatan kompetensi teknologi, serta pembinaan karakter mahasiswa.\nSiapa saja yang otomatis menjadi anggota HIMA SI?|Seluruh mahasiswa aktif yang terdaftar di Program Studi Sistem Informasi Fakultas Teknik Universitas Muria Kudus secara otomatis adalah anggota HIMA SI dan berhak mengikuti seluruh program serta kegiatan yang diselenggarakan.\nBagaimana cara bergabung menjadi Pengurus HIMA SI?|Rekrutmen pengurus baru (Open Recruitment) diadakan setiap satu tahun sekali menjelang pergantian periode kepengurusan. Proses seleksi meliputi pendaftaran berkas administrasi, wawancara kepribadian/kompetensi divisi, dan masa magang pengurus.\nApa saja manfaat yang didapatkan dengan aktif berorganisasi di HIMA SI?|Anda akan mendapatkan pengalaman kepemimpinan riil, mengasah kemampuan kerja sama tim (teamwork), manajemen acara (event management), sertifikat keaktifan berorganisasi (SKPI), serta jaringan relasi luas dengan dosen, alumni, dan profesional industri IT.\nApakah workshop koding dan bootcamp terbuka untuk pemula?|Tentu saja! Sebagian besar pelatihan dan workshop koding yang kami adakan dirancang berjenjang dari level dasar (beginner-friendly) dengan didampingi mentor mahasiswa senior dan praktisi agar mudah dipahami oleh seluruh peserta.", 'help' => 'Satu FAQ per baris dengan format: Pertanyaan|Jawaban.', 'row_columns' => 2],
            ],
        ],
        'footer' => [
            'label' => 'Informasi Footer',
            'fields' => [
                'footer_contact_title' => ['label' => 'Judul informasi sekretariat', 'type' => 'text', 'default' => 'Basecamp HIMA SI UMK'],
                'footer_address' => ['label' => 'Alamat sekretariat', 'type' => 'textarea', 'default' => 'Gedung PKM Lantai 2, Kampus UMK Gondangmanis, PO BOX 53 Bae, Kudus, Jawa Tengah 59327'],
                'footer_email' => ['label' => 'Email resmi', 'type' => 'text', 'default' => 'himasi@umk.ac.id'],
                'footer_partnership_title' => ['label' => 'Judul kolaborasi', 'type' => 'text', 'default' => 'Kolaborasi & Kemitraan'],
                'footer_partnership_description' => ['label' => 'Deskripsi kolaborasi', 'type' => 'textarea', 'default' => 'Terbuka untuk kolaborasi event IT, workshop bersama, publikasi media partner, dan program sponsorship industri.'],
            ],
        ],
    ];

    private const ITEM_GROUPS = [
        'hero_typed_texts' => [
            'label' => 'Teks Bergantian Hero',
            'parent_group' => 'hero',
            'fields' => ['text' => ['label' => 'Teks', 'type' => 'text']],
        ],
        'hero_highlights' => [
            'label' => 'Sorotan Beranda',
            'parent_group' => 'hero',
            'fields' => [
                'title' => ['label' => 'Judul', 'type' => 'text'],
                'description' => ['label' => 'Keterangan', 'type' => 'textarea'],
            ],
        ],
        'about_cards' => [
            'label' => 'Kartu Tentang Kami',
            'parent_group' => 'about',
            'fields' => [
                'title' => ['label' => 'Judul', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
            ],
        ],
        'mission_rows' => [
            'label' => 'Daftar Misi',
            'parent_group' => 'vision',
            'fields' => [
                'title' => ['label' => 'Judul misi', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
            ],
        ],
        'organization_bph_rows' => [
            'label' => 'Badan Pengurus Harian',
            'parent_group' => 'organization',
            'fields' => [
                'position' => ['label' => 'Jabatan', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi tugas', 'type' => 'textarea'],
            ],
        ],
        'organization_department_rows' => [
            'label' => 'Departemen',
            'parent_group' => 'organization',
            'fields' => [
                'acronym' => ['label' => 'Singkatan', 'type' => 'text'],
                'name' => ['label' => 'Nama departemen', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
            ],
        ],
        'program_rows' => [
            'label' => 'Program Unggulan',
            'parent_group' => 'programs',
            'fields' => [
                'category' => ['label' => 'Kategori', 'type' => 'text'],
                'title' => ['label' => 'Nama program', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
            ],
        ],
        'events_fallback_rows' => [
            'label' => 'Contoh Kegiatan',
            'parent_group' => 'events',
            'fields' => [
                'date' => ['label' => 'Tanggal', 'type' => 'text'],
                'year' => ['label' => 'Tahun', 'type' => 'text'],
                'status' => ['label' => 'Status', 'type' => 'text'],
                'category' => ['label' => 'Kategori', 'type' => 'text'],
                'title' => ['label' => 'Judul', 'type' => 'text'],
                'description' => ['label' => 'Deskripsi', 'type' => 'textarea'],
                'location' => ['label' => 'Lokasi', 'type' => 'text'],
            ],
        ],
        'gallery_fallback_rows' => [
            'label' => 'Contoh Galeri',
            'parent_group' => 'gallery',
            'fields' => [
                'category' => ['label' => 'Kategori', 'type' => 'text'],
                'image_path' => ['label' => 'Path gambar', 'type' => 'text'],
            ],
        ],
        'news_fallback_rows' => [
            'label' => 'Contoh Berita',
            'parent_group' => 'news',
            'fields' => [
                'category' => ['label' => 'Kategori', 'type' => 'text'],
                'date' => ['label' => 'Tanggal', 'type' => 'text'],
                'title' => ['label' => 'Judul', 'type' => 'text'],
                'description' => ['label' => 'Ringkasan', 'type' => 'textarea'],
                'image_path' => ['label' => 'Path gambar', 'type' => 'text'],
            ],
        ],
        'testimonial_rows' => [
            'label' => 'Testimoni',
            'parent_group' => 'testimonials',
            'fields' => [
                'title' => ['label' => 'Judul', 'type' => 'text'],
                'description' => ['label' => 'Isi testimoni', 'type' => 'textarea'],
                'name' => ['label' => 'Nama', 'type' => 'text'],
                'role' => ['label' => 'Peran', 'type' => 'text'],
            ],
        ],
        'faq_fallback_rows' => [
            'label' => 'Contoh FAQ',
            'parent_group' => 'faq',
            'fields' => [
                'question' => ['label' => 'Pertanyaan', 'type' => 'text'],
                'answer' => ['label' => 'Jawaban', 'type' => 'textarea'],
            ],
        ],
    ];

    public static function fieldGroups(): array
    {
        $groups = self::GROUPS;
        foreach (self::ITEM_GROUPS as $fieldKey => $definition) {
            unset($groups[$definition['parent_group']]['fields'][$fieldKey]);
        }

        return $groups;
    }

    public static function itemDefinitions(): array
    {
        $definitions = self::ITEM_GROUPS;
        foreach (self::ITEM_TABLES as $section => $table) {
            $definitions[$section]['table'] = $table;
        }

        return $definitions;
    }

    public static function sectionTable(string $section): ?string
    {
        return array_key_exists($section, self::fieldGroups())
            ? 'landing_page_' . $section . '_settings'
            : null;
    }

    public static function editableItemDefinitions(): array
    {
        return array_diff_key(self::itemDefinitions(), array_flip([
            'news_fallback_rows',
            'gallery_fallback_rows',
            'faq_fallback_rows',
        ]));
    }

    public static function defaultItemRows(string $section, ?string $legacyValue = null): array
    {
        $definition = self::ITEM_GROUPS[$section] ?? null;
        if ($definition === null) {
            throw new \InvalidArgumentException('Daftar landing page tidak ditemukan: ' . $section);
        }

        $source = $legacyValue ?? self::GROUPS[$definition['parent_group']]['fields'][$section]['default'];
        $rows = self::parseRows($source, count($definition['fields']));

        return array_map(
            static fn (array $row): array => array_combine(array_keys($definition['fields']), $row),
            $rows
        );
    }

    public static function defaults(): array
    {
        $defaults = [];
        foreach (self::GROUPS as $group) {
            foreach ($group['fields'] as $key => $field) {
                $defaults[$key] = $field['default'];
            }
        }

        return $defaults;
    }

    public static function values(): array
    {
        $values = self::defaults();
        foreach (array_keys(self::itemDefinitions()) as $section) {
            $values[$section . '_items'] = array_map(
                'array_values',
                self::defaultItemRows($section)
            );
        }

        return $values;
    }

    public static function parseRows(string $value, int $columns): array
    {
        $rows = [];
        foreach (preg_split('/\r\n|\r|\n/', trim($value)) ?: [] as $line) {
            if (trim($line) === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, $columns));
            if (count($parts) === $columns) {
                $rows[] = $parts;
            }
        }

        return $rows;
    }
}
