<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\AspirasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AspirasiController extends BaseController
{
    // Memuat model aspirasi agar seluruh aksi menggunakan satu akses database.
    private function model(): AspirasiModel
    {
        return model(AspirasiModel::class);
    }

    public function store()
    {
        // Menerima dan memvalidasi aspirasi yang dikirim dari landing page.
        helper(['form', 'url']);

        $rules = [
            'name'     => 'permit_empty|max_length[150]',
            'nim'      => 'permit_empty|max_length[30]',
            'email'    => 'permit_empty|valid_email|max_length[150]',
            'phone'    => 'permit_empty|max_length[30]',
            'category' => 'required|in_list[kegiatan,akademik,organisasi,lainnya]',
            'subject'  => 'required|max_length[150]',
            'message'  => 'required|max_length[5000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('aspiration_errors', $this->validator->getErrors());
        }

        $isAnonymous = (string) $this->request->getPost('is_anonymous') === '1';
        $model = model(AspirasiModel::class);
        $inserted = $model->insert([
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
            return redirect()->back()
                ->withInput()
                ->with('aspiration_error', 'Aspirasi belum dapat disimpan. Silakan coba lagi.');
        }

        return redirect()->to(site_url('/#aspirations'))
            ->with('aspiration_success', 'Terima kasih! Aspirasi Anda berhasil dikirim dan akan ditinjau oleh pengurus.');
    }

    public function index()
    {
        // Menampilkan daftar aspirasi beserta jumlah status untuk dashboard admin.
        $model = $this->model();
        $status = (string) $this->request->getGet('status');

        if (in_array($status, ['pending', 'read', 'resolved', 'rejected'], true)) {
            $model->where('status', $status);
        }

        return view('backend/aspirasi/index', [
            'title'        => 'Kelola Aspirasi',
            'aspirations'  => $model->orderBy('created_at', 'DESC')->findAll(),
            'filterStatus' => $status,
            'counts'       => [
                'all'       => $this->model()->countAllResults(),
                'pending'   => $this->model()->where('status', 'pending')->countAllResults(),
                'read'      => $this->model()->where('status', 'read')->countAllResults(),
                'resolved'  => $this->model()->where('status', 'resolved')->countAllResults(),
                'published' => $this->model()->where('is_published', 1)->countAllResults(),
            ],
        ]);
    }

    public function show(int $id)
    {
        // Menampilkan detail satu aspirasi untuk ditinjau atau diperbarui.
        $aspiration = $this->model()->find($id);
        if ($aspiration === null) {
            throw new PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        return view('backend/aspirasi/show', [
            'title'      => 'Detail Aspirasi',
            'aspiration' => $aspiration,
        ]);
    }

    public function updateStatus(int $id)
    {
        // Mengubah status penanganan aspirasi dan memeriksa nilai yang diterima.
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['pending', 'read', 'resolved', 'rejected'], true)) {
            return redirect()->back()->with('error', 'Status aspirasi tidak valid.');
        }

        $model = $this->model();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/aspirasi'))->with('error', 'Aspirasi tidak ditemukan.');
        }

        if (! $model->update($id, ['status' => $status])) {
            return redirect()->back()->with('error', 'Status aspirasi gagal diperbarui.');
        }

        return redirect()->back()->with('message', 'Status aspirasi berhasil diperbarui.');
    }

    public function togglePublish(int $id)
    {
        // Memilih apakah aspirasi ditampilkan atau dihentikan pada landing page.
        $model = $this->model();
        $aspiration = $model->find($id);
        if ($aspiration === null) {
            throw new PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        $published = (int) $aspiration['is_published'] === 1;
        $publishedName = trim((string) $this->request->getPost('published_name'));
        $publishedRole = trim((string) $this->request->getPost('published_role'));

        if (! $published && ($publishedName === '' || mb_strlen($publishedName) > 150 || mb_strlen($publishedRole) > 150)) {
            return redirect()->back()->with('error', 'Nama dan peran yang ditampilkan wajib diisi dengan benar.');
        }

        $data = [
            'is_published'   => $published ? 0 : 1,
            'published_at'   => $published ? null : date('Y-m-d H:i:s'),
            'published_name' => $published ? null : $publishedName,
            'published_role' => $published ? null : $publishedRole,
        ];

        if (! $model->update($id, $data)) {
            return redirect()->back()->with('error', 'Publikasi aspirasi gagal diperbarui.');
        }

        return redirect()->back()->with(
            'message',
            $published ? 'Aspirasi dihentikan dari publikasi.' : 'Aspirasi berhasil ditampilkan di landing page.'
        );
    }

    public function delete(int $id)
    {
        // Menghapus aspirasi secara permanen melalui tindakan admin.
        $model = $this->model();
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/aspirasi'))->with('error', 'Aspirasi tidak ditemukan.');
        }

        if (! $model->delete($id)) {
            return redirect()->back()->with('error', 'Aspirasi gagal dihapus.');
        }

        return redirect()->to(site_url('admin/aspirasi'))->with('message', 'Aspirasi berhasil dihapus.');
    }
}
