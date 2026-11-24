<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\AspirasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AspirasiController extends BaseController
{
<<<<<<< HEAD
    public static function publishedForLanding(): array
    {
        return model(AspirasiModel::class)
            ->where('is_published', 1)
            ->where('deleted_at', null)
            ->orderBy('published_at', 'DESC')
            ->findAll(3);
    }

    // Memuat model aspirasi agar seluruh aksi menggunakan satu akses database.
=======
    private const STATUSES = [
        'pending'     => 'Menunggu',
        'read'        => 'Dibaca',
        'followed_up' => 'Ditindaklanjuti',
    ];

    private const CATEGORIES = [
        'kegiatan'  => 'Kegiatan & Acara',
        'akademik'  => 'Akademik & Fasilitas',
        'organisasi'=> 'Saran untuk Organisasi',
        'lainnya'   => 'Lainnya',
    ];

>>>>>>> origin/nando
    private function model(): AspirasiModel
    {
        return model(AspirasiModel::class);
    }

    public function store()
    {
        $throttlerKey = 'public-aspirasi-' . sha1($this->request->getIPAddress());
        if (! service('throttler')->check($throttlerKey, 5, 300)) {
            return redirect()->back()->withInput()
                ->with('aspiration_error', 'Terlalu banyak pengiriman dari jaringan ini. Coba lagi beberapa menit lagi.');
        }

        $rules = [
            'name'     => 'permit_empty|max_length[150]',
            'nim'      => 'permit_empty|max_length[30]',
            'email'    => 'permit_empty|valid_email|max_length[150]',
            'phone'    => 'permit_empty|max_length[30]',
            'category' => 'required|in_list[' . implode(',', array_keys(self::CATEGORIES)) . ']',
            'subject'  => 'required|max_length[150]',
            'message'  => 'required|max_length[5000]',
        ];
        $messages = [
            'category' => ['required' => 'Kategori aspirasi wajib dipilih.', 'in_list' => 'Kategori aspirasi tidak valid.'],
            'subject'  => ['required' => 'Judul aspirasi wajib diisi.', 'max_length' => 'Judul aspirasi maksimal 150 karakter.'],
            'message'  => ['required' => 'Pesan aspirasi wajib diisi.', 'max_length' => 'Pesan aspirasi maksimal 5000 karakter.'],
            'email'    => ['valid_email' => 'Format email tidak valid.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('aspiration_errors', $this->validator->getErrors());
        }

        $isAnonymous = (string) $this->request->getPost('is_anonymous') === '1';
        $inserted    = $this->model()->insert([
            'name'         => $isAnonymous ? null : trim((string) $this->request->getPost('name')),
            'nim'          => trim((string) $this->request->getPost('nim')),
            'email'        => trim((string) $this->request->getPost('email')),
            'phone'        => trim((string) $this->request->getPost('phone')),
            'category'     => (string) $this->request->getPost('category'),
            'subject'      => trim((string) $this->request->getPost('subject')),
            'message'      => trim((string) $this->request->getPost('message')),
            'is_anonymous' => $isAnonymous ? 1 : 0,
            'status'       => 'pending',
            'is_published' => 0,
        ]);

        if (! $inserted) {
            return redirect()->back()->withInput()
                ->with('aspiration_error', 'Aspirasi belum dapat disimpan. Silakan coba lagi.');
        }

        return redirect()->to(site_url('landing#aspirations'))
            ->with('aspiration_success', 'Terima kasih! Aspirasi Anda berhasil dikirim dan akan ditinjau oleh pengurus.');
    }

    public function index()
    {
        $keyword  = trim((string) $this->request->getGet('q'));
        $status   = (string) $this->request->getGet('status');
        $category = (string) $this->request->getGet('category');

        $model = $this->model();
        if ($keyword !== '') {
            $model->groupStart()
                ->like('subject', $keyword)
                ->orLike('message', $keyword)
                ->orLike('name', $keyword)
                ->orLike('nim', $keyword)
                ->groupEnd();
        }
        if (array_key_exists($status, self::STATUSES)) {
            $model->where('status', $status);
        }
        if (array_key_exists($category, self::CATEGORIES)) {
            $model->where('category', $category);
        }

        $aspirations = $model->orderBy('created_at', 'DESC')->paginate(10, 'aspirasi');

        return view('backend/aspirasi/index', [
            'title'        => 'Kelola Aspirasi',
            'aspirations'  => $aspirations,
            'pager'        => $model->pager,
            'keyword'      => $keyword,
            'filterStatus' => $status,
            'filterCategory' => $category,
            'statuses'     => self::STATUSES,
            'categories'   => self::CATEGORIES,
            'counts'       => [
                'all'         => $this->model()->countAllResults(),
                'pending'     => $this->model()->where('status', 'pending')->countAllResults(),
                'read'        => $this->model()->where('status', 'read')->countAllResults(),
                'followed_up' => $this->model()->where('status', 'followed_up')->countAllResults(),
                'published'   => $this->model()->where('is_published', 1)->countAllResults(),
            ],
        ]);
    }

    public function show(int $id)
    {
        $aspiration = $this->model()->find($id);
        if ($aspiration === null) {
            throw new PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        return view('backend/aspirasi/show', [
            'title'      => 'Detail Aspirasi',
            'aspiration' => $aspiration,
            'statuses'   => self::STATUSES,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! array_key_exists($status, self::STATUSES)) {
            return redirect()->back()->with('error', 'Status aspirasi tidak valid.');
        }

        $model = $this->model();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/aspirasi'))->with('error', 'Aspirasi tidak ditemukan.');
        }

        $model->update($id, ['status' => $status]);

        return redirect()->back()->with('message', 'Status aspirasi berhasil diperbarui.');
    }

    public function togglePublish(int $id)
    {
        $model      = $this->model();
        $aspiration = $model->find($id);
        if ($aspiration === null) {
            throw new PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        $published = (int) $aspiration['is_published'] === 1;

        if ($published) {
            $model->update($id, [
                'is_published'   => 0,
                'published_at'   => null,
                'published_name' => null,
                'published_role' => null,
            ]);

            return redirect()->back()->with('message', 'Aspirasi dihentikan dari publikasi.');
        }

        $publishedName = trim((string) $this->request->getPost('published_name'));
        $publishedRole = trim((string) $this->request->getPost('published_role'));

        if ($publishedName === '') {
            $publishedName = (int) $aspiration['is_anonymous'] === 1
                ? 'Penyumbang Anonim'
                : ($aspiration['name'] ?: 'Mahasiswa');
        }
        if ($publishedRole === '') {
            $publishedRole = 'Aspirasi ' . (self::CATEGORIES[$aspiration['category']] ?? ucfirst($aspiration['category']));
        }

        if (mb_strlen($publishedName) > 150 || mb_strlen($publishedRole) > 150) {
            return redirect()->back()->with('error', 'Nama atau peran yang ditampilkan terlalu panjang.');
        }

        $model->update($id, [
            'is_published'   => 1,
            'published_at'   => date('Y-m-d H:i:s'),
            'published_name' => $publishedName,
            'published_role' => $publishedRole,
        ]);

        return redirect()->back()->with('message', 'Aspirasi berhasil ditampilkan di landing page.');
    }

    public function delete(int $id)
    {
        $model = $this->model();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/aspirasi'))->with('error', 'Aspirasi tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/aspirasi'))->with('message', 'Aspirasi berhasil dihapus.');
    }

    public function export()
    {
        $keyword  = trim((string) $this->request->getGet('q'));
        $status   = (string) $this->request->getGet('status');
        $category = (string) $this->request->getGet('category');

        $model = $this->model();
        if ($keyword !== '') {
            $model->groupStart()
                ->like('subject', $keyword)
                ->orLike('message', $keyword)
                ->orLike('name', $keyword)
                ->orLike('nim', $keyword)
                ->groupEnd();
        }
        if (array_key_exists($status, self::STATUSES)) {
            $model->where('status', $status);
        }
        if (array_key_exists($category, self::CATEGORIES)) {
            $model->where('category', $category);
        }

        $rows = $model->orderBy('created_at', 'DESC')->findAll();

        $handle = fopen('php://temp', 'w+');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['ID', 'Tanggal', 'Nama', 'NIM', 'Email', 'Telepon', 'Kategori', 'Subjek', 'Pesan', 'Status', 'Ditampilkan']);

        foreach ($rows as $row) {
            fputcsv($handle, [
                $row['id'],
                $row['created_at'],
                $row['is_anonymous'] ? 'Anonim' : $row['name'],
                $this->csvValue($row['nim']),
                $this->csvValue($row['email']),
                $this->csvValue($row['phone']),
                self::CATEGORIES[$row['category']] ?? $row['category'],
                $this->csvValue($row['subject']),
                $this->csvValue($row['message']),
                self::STATUSES[$row['status']] ?? $row['status'],
                $row['is_published'] ? 'Ya' : 'Tidak',
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle) ?: '';
        fclose($handle);

        return service('response')
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="aspirasi-' . date('Ymd-His') . '.csv"')
            ->setBody($content);
    }

    private function csvValue(?string $value): string
    {
        $value = (string) $value;

        // Cegah formula injection saat CSV dibuka di spreadsheet.
        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
            $value = "'" . $value;
        }

        return $value;
    }
}
