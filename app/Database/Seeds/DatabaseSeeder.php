<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Data contoh portal HIMA SI.
 *
 * Seeder ini idempotent: data dicek berdasarkan kunci unik (slug, username,
 * nama divisi, judul program, NIM pendaftar, dan subjek aspirasi) sebelum
 * ditambahkan. Menjalankan ulang seeder tidak membuat data ganda.
 */
class DatabaseSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = 'Himasi123!';

    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $roleIds = $this->seedRoles($now);
        $userIds = $this->seedUsers($roleIds, $now);

        $divisionIds = $this->seedDivisions($now);
        $this->seedMembers($divisionIds, $now);

        $this->seedNews($userIds['superadmin'], $now);
        $this->seedGalleries($userIds['kominfo'], $now);
        $this->seedWorkPrograms($divisionIds, $now);
        $this->seedEvents($userIds['panitia'], $now);

        $periodIds = $this->seedRecruitment($userIds['pengurusinti'], $now);
        $this->seedApplications($periodIds, $now);

        $this->seedAspirations($now);
    }

    /**
     * @return array<string, int>
     */
    private function seedRoles(string $now): array
    {
        $roles = [
            'super-admin'   => ['Super Admin', 'Akses penuh ke seluruh sistem'],
            'pengurus-inti' => ['Pengurus Inti', 'Ketua, Wakil, Sekretaris, dan Bendahara'],
            'kominfo'       => ['Kominfo', 'Pengelola konten website, berita, dan galeri'],
            'panitia'       => ['Panitia Kegiatan', 'Pengelola event dan peserta kegiatan'],
        ];

        $ids = [];
        foreach ($roles as $slug => [$name, $description]) {
            $ids[$slug] = $this->insertIfMissing('roles', ['slug' => $slug], [
                'name'        => $name,
                'slug'        => $slug,
                'description' => $description,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        return $ids;
    }

    /**
     * @param array<string, int> $roleIds
     *
     * @return array<string, int>
     */
    private function seedUsers(array $roleIds, string $now): array
    {
        $users = [
            'superadmin'   => ['superadmin', 'superadmin@himasi.test', 'Super Admin HIMA SI', 'super-admin'],
            'pengurusinti' => ['pengurusinti', 'pengurus@himasi.test', 'Ketua HIMA SI', 'pengurus-inti'],
            'kominfo'      => ['kominfo', 'kominfo@himasi.test', 'Koordinator Kominfo', 'kominfo'],
            'panitia'      => ['panitia', 'panitia@himasi.test', 'Koordinator Panitia', 'panitia'],
        ];

        $ids = [];
        foreach ($users as $key => [$username, $email, $fullName, $role]) {
            $existing = $this->db->table('users')
                ->select('id')
                ->where('username', $username)
                ->get(1)
                ->getRowArray();

            if ($existing !== null) {
                $this->db->table('users')->where('id', $existing['id'])->update([
                    'role_id'    => $roleIds[$role],
                    'is_active'  => 1,
                    'updated_at' => $now,
                ]);
                $ids[$key] = (int) $existing['id'];

                continue;
            }

            $ids[$key] = $this->insertIfMissing('users', ['username' => $username], [
                'role_id'    => $roleIds[$role],
                'username'   => $username,
                'email'      => $email,
                'password'   => password_hash(self::DEFAULT_PASSWORD, PASSWORD_DEFAULT),
                'full_name'  => $fullName,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return $ids;
    }

    /**
     * @return array<string, int>
     */
    private function seedDivisions(string $now): array
    {
        $divisions = [
            'bph'   => ['Badan Pengurus Harian', 'Mengoordinasikan seluruh divisi dan kebijakan organisasi.', 0],
            'psdm'  => ['PSDM', 'Pengembangan Sumber Daya Mahasiswa.', 1],
            'kaka'  => ['KAKA', 'Kajian Keilmuan dan pengembangan wawasan akademik.', 2],
            'hublu' => ['HUBLU', 'Hubungan Luar dan kemitraan dengan pihak eksternal.', 3],
            'mikat' => ['MIKAT', 'Minat dan Bakat mahasiswa.', 4],
            'ekraf' => ['EKRAF', 'Ekonomi Kreatif dan kewirausahaan mahasiswa.', 5],
        ];

        $ids = [];
        foreach ($divisions as $key => [$name, $description, $sortOrder]) {
            $ids[$key] = $this->insertIfMissing('divisions', ['name' => $name], [
                'name'        => $name,
                'description' => $description,
                'sort_order'  => $sortOrder,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        return $ids;
    }

    /**
     * @param array<string, int> $divisionIds
     */
    private function seedMembers(array $divisionIds, string $now): void
    {
        $members = [
            ['bph', 'Ahmad Fauzan', 'Ketua Umum', 1],
            ['bph', 'Nadia Putri', 'Wakil Ketua', 2],
            ['bph', 'Rizky Ramadhan', 'Sekretaris', 3],
            ['bph', 'Salsabila Zahra', 'Bendahara', 4],
            ['psdm', 'Dimas Prakoso', 'Koordinator Divisi', 1],
            ['psdm', 'Ayu Lestari', 'Anggota', 2],
            ['kaka', 'Fajar Nugroho', 'Koordinator Divisi', 1],
            ['kaka', 'Intan Permata', 'Anggota', 2],
            ['hublu', 'Bagas Saputra', 'Koordinator Divisi', 1],
            ['hublu', 'Citra Maharani', 'Anggota', 2],
            ['mikat', 'Yoga Pratama', 'Koordinator Divisi', 1],
            ['mikat', 'Dewi Anggraini', 'Anggota', 2],
            ['ekraf', 'Raka Wijaya', 'Koordinator Divisi', 1],
            ['ekraf', 'Maya Safitri', 'Anggota', 2],
        ];

        foreach ($members as [$division, $name, $position, $sortOrder]) {
            $this->insertIfMissing('members', [
                'division_id' => $divisionIds[$division],
                'name'        => $name,
            ], [
                'division_id' => $divisionIds[$division],
                'name'        => $name,
                'position'    => $position,
                'period'      => '2025/2026',
                'sort_order'  => $sortOrder,
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    private function seedNews(int $authorId, string $now): void
    {
        $news = [
            [
                'title'        => 'Workshop Web Modern & REST API untuk Mahasiswa Sistem Informasi',
                'slug'         => 'workshop-web-modern-rest-api',
                'excerpt'      => 'Pelatihan hands-on membangun aplikasi web modern dan REST API bersama praktisi industri.',
                'content'      => '<p>HIMA SI menyelenggarakan workshop pengembangan web modern yang diikuti lebih dari 100 mahasiswa. Materi mencakup dasar HTML, CSS, JavaScript, hingga perancangan REST API menggunakan framework populer.</p><h2>Belajar Langsung dari Praktisi</h2><p>Peserta mendapatkan pendampingan langsung dari alumni dan praktisi industri sehingga mampu menyelesaikan proyek mini secara berkelompok.</p>',
                'thumbnail'    => 'assets/media/stock/600x400/img-1.jpg',
                'status'       => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
            [
                'title'        => 'Delegasi Mahasiswa SI Raih Juara Hackathon Nasional',
                'slug'         => 'delegasi-mahasiswa-si-juara-hackathon-nasional',
                'excerpt'      => 'Inovasi aplikasi smart agriculture berbasis IoT mengantar tim meraih juara pada hackathon nasional.',
                'content'      => '<p>Tim mahasiswa Sistem Informasi berhasil meraih juara pada hackathon nasional dengan gagasan aplikasi smart agriculture berbasis Internet of Things.</p><p>Karya tersebut dinilai mampu menjawab kebutuhan petani lokal melalui pemantauan kelembapan tanah dan otomatisasi irigasi.</p>',
                'thumbnail'    => 'assets/media/stock/600x400/img-2.jpg',
                'status'       => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'title'        => 'Open Recruitment Pengurus HIMA SI Periode 2026/2027',
                'slug'         => 'open-recruitment-pengurus-hima-si-2026-2027',
                'excerpt'      => 'Kesempatan bagi mahasiswa aktif Sistem Informasi untuk bergabung dan mengembangkan kepemimpinan.',
                'content'      => '<p>HIMA SI membuka rekrutmen pengurus untuk periode 2026/2027. Mahasiswa aktif Program Studi Sistem Informasi dapat mendaftar melalui halaman rekrutmen di portal ini.</p><p>Seleksi meliputi penilaian berkas, wawancara, dan masa orientasi pengurus.</p>',
                'thumbnail'    => 'assets/media/stock/600x400/img-3.jpg',
                'status'       => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
            ],
        ];

        foreach ($news as $item) {
            $item['created_by'] = $authorId;
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            $this->insertIfMissing('news', ['slug' => $item['slug']], $item);
        }
    }

    private function seedGalleries(int $authorId, string $now): void
    {
        $galleries = [
            ['Workshop Web Modern', 'assets/media/stock/600x600/img-23.jpg', 'Dokumentasi workshop pengembangan web modern.', date('Y-m-d', strtotime('-2 days')), 1],
            ['Seminar Nasional Teknologi', 'assets/media/stock/600x600/img-22.jpg', 'Suasana seminar nasional yang dihadiri mahasiswa lintas kampus.', date('Y-m-d', strtotime('-20 days')), 2],
            ['Temu Akrab Angkatan', 'assets/media/stock/600x600/img-21.jpg', 'Kegiatan temu akrab dan sharing antar angkatan.', date('Y-m-d', strtotime('-40 days')), 3],
            ['Bakti Sosial Digital', 'assets/media/stock/600x600/img-20.jpg', 'Program pengabdian masyarakat berbasis literasi digital.', date('Y-m-d', strtotime('-60 days')), 4],
            ['Company Visit', 'assets/media/stock/600x600/img-11.jpg', 'Kunjungan industri untuk memperluas wawasan mahasiswa.', date('Y-m-d', strtotime('-80 days')), 5],
            ['Kompetisi UI/UX', 'assets/media/stock/600x600/img-12.jpg', 'Ajang kompetisi desain antarmuka dan pengalaman pengguna.', date('Y-m-d', strtotime('-95 days')), 6],
        ];

        foreach ($galleries as [$title, $image, $description, $eventDate, $sortOrder]) {
            $data = [
                'title'       => $title,
                'image'       => $image,
                'description' => $description,
                'event_date'  => $eventDate,
                'is_active'   => 1,
                'sort_order'  => $sortOrder,
                'created_by'  => $authorId,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            if ($this->db->fieldExists('deleted_at', 'galleries')) {
                $data['deleted_at'] = null;
            }

            $this->insertIfMissing('galleries', ['title' => $title], $data);
        }
    }

    /**
     * @param array<string, int> $divisionIds
     */
    private function seedWorkPrograms(array $divisionIds, string $now): void
    {
        $programs = [
            ['Insys Competition 2027', 'Kompetisi teknologi tahunan bagi pelajar dan mahasiswa.', '+60 days', 'ongoing', 'kaka'],
            ['Workshop UI/UX Fundamental', 'Pelatihan desain antarmuka untuk pemula.', '+30 days', 'planned', 'psdm'],
            ['Bakti Sosial Digital Desa Binaan', 'Pendampingan literasi digital bagi masyarakat desa binaan.', '-20 days', 'done', 'hublu'],
            ['Company Visit ke Perusahaan Teknologi', 'Kunjungan industri dan sesi karier bersama praktisi.', '+90 days', 'planned', 'ekraf'],
            ['Insys Fun Game', 'Kegiatan kebersamaan antar angkatan mahasiswa Sistem Informasi.', '+45 days', 'planned', 'mikat'],
        ];

        foreach ($programs as [$title, $description, $target, $status, $division]) {
            $this->insertIfMissing('work_programs', ['title' => $title], [
                'division_id' => $divisionIds[$division],
                'title'       => $title,
                'description' => $description,
                'target_date' => date('Y-m-d', strtotime($target)),
                'status'      => $status,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    private function seedEvents(int $authorId, string $now): void
    {
        $events = [
            [
                'title'                 => 'Workshop Web Modern & REST API',
                'slug'                  => 'workshop-web-modern-rest-api',
                'description'           => '<p>Pelatihan intensif membangun aplikasi web modern dan REST API. Peserta akan membuat proyek mini secara berkelompok bersama mentor.</p>',
                'poster'                => 'assets/media/stock/600x400/img-1.jpg',
                'location'              => 'Lab Komputer Gedung F, Universitas Muria Kudus',
                'start_at'              => date('Y-m-d 09:00:00', strtotime('+14 days')),
                'end_at'                => date('Y-m-d 15:00:00', strtotime('+14 days')),
                'registration_deadline' => date('Y-m-d 23:59:59', strtotime('+10 days')),
                'quota'                 => 100,
                'status'                => 'published',
            ],
            [
                'title'                 => 'Seminar Nasional AI & Data',
                'slug'                  => 'seminar-nasional-ai-data',
                'description'           => '<p>Seminar nasional membahas penerapan kecerdasan buatan dan analitik data di industri. Terbuka untuk mahasiswa dan umum.</p>',
                'poster'                => 'assets/media/stock/600x400/img-2.jpg',
                'location'              => 'Auditorium Universitas Muria Kudus',
                'start_at'              => date('Y-m-d 08:30:00', strtotime('+28 days')),
                'end_at'                => date('Y-m-d 12:30:00', strtotime('+28 days')),
                'registration_deadline' => date('Y-m-d 23:59:59', strtotime('+21 days')),
                'quota'                 => 150,
                'status'                => 'published',
            ],
            [
                'title'                 => 'Temu Akrab & Alumni Career Talk',
                'slug'                  => 'temu-akrab-alumni-career-talk',
                'description'           => '<p>Temu akrab lintas angkatan serta sesi berbagi kiat sukses berkarir di industri teknologi bersama alumni.</p>',
                'poster'                => 'assets/media/stock/600x400/img-3.jpg',
                'location'              => 'Hall Gedung Rektorat Lt. 4, Universitas Muria Kudus',
                'start_at'              => date('Y-m-d 13:00:00', strtotime('+45 days')),
                'end_at'                => date('Y-m-d 16:00:00', strtotime('+45 days')),
                'registration_deadline' => date('Y-m-d 23:59:59', strtotime('+38 days')),
                'quota'                 => 120,
                'status'                => 'published',
            ],
        ];

        foreach ($events as $item) {
            $item['created_by'] = $authorId;
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            $this->insertIfMissing('events', ['slug' => $item['slug']], $item);
        }
    }

    /**
     * @return array<string, int>
     */
    private function seedRecruitment(int $authorId, string $now): array
    {
        $periods = [
            'pengurus' => [
                'title'        => 'Open Recruitment Pengurus HIMA SI 2026/2027',
                'slug'         => 'open-recruitment-pengurus-hima-si-2026-2027',
                'description'  => '<p>Rekrutmen pengurus HIMA SI periode 2026/2027 terbuka bagi mahasiswa aktif Program Studi Sistem Informasi.</p>',
                'requirements' => '<ul><li>Mahasiswa aktif Sistem Informasi.</li><li>IPK minimal 3.00.</li><li>Bersedia mengikuti seluruh tahapan seleksi.</li></ul>',
                'start_date'   => date('Y-m-d', strtotime('-3 days')),
                'end_date'     => date('Y-m-d', strtotime('+27 days')),
                'quota'        => 40,
                'status'       => 'published',
            ],
            'panitia' => [
                'title'        => 'Rekrutmen Panitia Insys Competition 2027',
                'slug'         => 'rekrutmen-panitia-insys-competition-2027',
                'description'  => '<p>Bergabunglah menjadi panitia Insys Competition 2027 dan dapatkan pengalaman manajemen acara berskala nasional.</p>',
                'requirements' => '<ul><li>Mahasiswa aktif semester 2 ke atas.</li><li>Mampu bekerja dalam tim.</li><li>Bersedia meluangkan waktu selama persiapan acara.</li></ul>',
                'start_date'   => date('Y-m-d', strtotime('+7 days')),
                'end_date'     => date('Y-m-d', strtotime('+37 days')),
                'quota'        => 30,
                'status'       => 'published',
            ],
        ];

        $ids = [];
        foreach ($periods as $key => $item) {
            $item['created_by'] = $authorId;
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            $ids[$key] = $this->insertIfMissing('recruitment_periods', ['slug' => $item['slug']], $item);
        }

        return $ids;
    }

    /**
     * @param array<string, int> $periodIds
     */
    private function seedApplications(array $periodIds, string $now): void
    {
        $applications = [
            ['pengurus', 'Aulia Rahma', '202311001', 'aulia.rahma@example.test', '081234567801', 'Saya ingin berkontribusi mengembangkan program kerja HIMA SI.', 'pending'],
            ['pengurus', 'Bima Aditya', '202311002', 'bima.aditya@example.test', '081234567802', 'Saya tertarik memperkuat divisi kajian keilmuan.', 'accepted'],
            ['panitia', 'Cindy Larasati', '202311003', 'cindy.larasati@example.test', '081234567803', 'Saya ingin belajar manajemen acara berskala besar.', 'pending'],
        ];

        foreach ($applications as [$period, $name, $nim, $email, $phone, $motivation, $status]) {
            $this->insertIfMissing('recruitment_applications', [
                'period_id' => $periodIds[$period],
                'nim'       => $nim,
            ], [
                'period_id'     => $periodIds[$period],
                'name'          => $name,
                'nim'           => $nim,
                'email'         => $email,
                'phone'         => $phone,
                'study_program' => 'Sistem Informasi',
                'motivation'    => $motivation,
                'cv'            => null,
                'status'        => $status,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }

    private function seedAspirations(string $now): void
    {
        $aspirations = [
            [
                'name'           => 'Ahmad Rizky Pratama',
                'nim'            => '202211001',
                'email'          => 'rizky@example.test',
                'phone'          => '081234567811',
                'category'       => 'kegiatan',
                'subject'        => 'Tempat Belajar Soft Skill Terbaik',
                'message'        => 'Aktif di HIMA SI mengajarkan saya cara memimpin tim, problem solving dalam tekanan, dan membangun relasi kerja yang solid.',
                'is_anonymous'   => 0,
                'status'         => 'followed_up',
                'is_published'   => 1,
                'published_name' => 'Ahmad Rizky Pratama',
                'published_role' => 'Mahasiswa Sistem Informasi Angkatan 2022',
            ],
            [
                'name'           => 'Siti Nurhaliza',
                'nim'            => '202011002',
                'email'          => 'siti@example.test',
                'phone'          => '081234567812',
                'category'       => 'akademik',
                'subject'        => 'Workshop Sangat Relevan dengan Industri',
                'message'        => 'Materi bootcamp koding dan UI/UX yang diadakan HIMA SI sangat aplikatif dan membantu saya ketika melamar magang di perusahaan teknologi.',
                'is_anonymous'   => 0,
                'status'         => 'followed_up',
                'is_published'   => 1,
                'published_name' => 'Siti Nurhaliza',
                'published_role' => 'Alumni Sistem Informasi',
            ],
            [
                'name'           => null,
                'nim'            => null,
                'email'          => null,
                'phone'          => null,
                'category'       => 'organisasi',
                'subject'        => 'Solid, Terbuka, dan Kolaboratif',
                'message'        => 'Sebagai mahasiswa baru, saya merasa sangat dirangkul oleh para senior. Suasana kekeluargaan di HIMA SI luar biasa hangat.',
                'is_anonymous'   => 1,
                'status'         => 'read',
                'is_published'   => 1,
                'published_name' => 'Penyumbang Anonim',
                'published_role' => 'Mahasiswa Sistem Informasi Angkatan 2025',
            ],
        ];

        foreach ($aspirations as $item) {
            $item['published_at'] = date('Y-m-d H:i:s', strtotime('-' . (count($aspirations) * 2) . ' days'));
            $item['created_at']   = $now;
            $item['updated_at']   = $now;

            $this->insertIfMissing('aspirations', ['subject' => $item['subject']], $item);
        }
    }

    /**
     * @param array<string, mixed> $where
     * @param array<string, mixed> $data
     */
    private function insertIfMissing(string $table, array $where, array $data): int
    {
        if (! $this->db->tableExists($table)) {
            return 0;
        }

        $builder = $this->db->table($table)->where($where);
        if ($this->db->fieldExists('deleted_at', $table)) {
            $builder->where('deleted_at', null);
        }

        $existing = $builder->get(1)->getRowArray();
        if ($existing !== null) {
            return (int) ($existing['id'] ?? 0);
        }

        $data['created_at'] ??= date('Y-m-d H:i:s');
        if ($this->db->fieldExists('updated_at', $table)) {
            $data['updated_at'] ??= $data['created_at'];
        }

        $this->db->table($table)->insert($data);

        return (int) $this->db->insertID();
    }
}
