<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\AspirasiModel;

class AspirasiController extends BaseController
{
    private function model(): AspirasiModel
    {
        return model(AspirasiModel::class);
    }

    public function index()
    {
        $model = $this->model();
        $status = (string) $this->request->getGet('status');

        if (in_array($status, ['pending', 'read', 'resolved', 'rejected'], true)) {
            $model->where('status', $status);
        }

        $countsModel = $this->model();
        return view('backend/aspirasi/index', [
            'title'        => 'Kelola Aspirasi',
            'aspirations'  => $model->orderBy('created_at', 'DESC')->findAll(),
            'filterStatus' => $status,
            'counts'       => [
                'all'       => $countsModel->countAllResults(),
                'pending'   => $this->model()->where('status', 'pending')->countAllResults(),
                'read'      => $this->model()->where('status', 'read')->countAllResults(),
                'resolved'  => $this->model()->where('status', 'resolved')->countAllResults(),
                'published' => $this->model()->where('is_published', 1)->countAllResults(),
            ],
        ]);
    }

    public function show(int $id)
    {
        $aspiration = $this->model()->find($id);
        if ($aspiration === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        return view('backend/aspirasi/show', [
            'title'      => 'Detail Aspirasi',
            'aspiration' => $aspiration,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['pending', 'read', 'resolved', 'rejected'], true)) {
            return redirect()->back()->with('error', 'Status aspirasi tidak valid.');
        }

        $model = $this->model();
        if (! $model->update($id, ['status' => $status])) {
            return redirect()->back()->with('error', 'Status aspirasi gagal diperbarui.');
        }

        return redirect()->back()->with('message', 'Status aspirasi berhasil diperbarui.');
    }

    public function togglePublish(int $id)
    {
        $model = $this->model();
        $aspiration = $model->find($id);
        if ($aspiration === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Aspirasi tidak ditemukan.');
        }

        $published = (int) $aspiration['is_published'] === 1;
        $data = [
            'is_published' => $published ? 0 : 1,
            'published_at' => $published ? null : date('Y-m-d H:i:s'),
            'published_name' => $published ? null : trim((string) $this->request->getPost('published_name')),
            'published_role' => $published ? null : trim((string) $this->request->getPost('published_role')),
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
        if (! $this->model()->delete($id)) {
            return redirect()->back()->with('error', 'Aspirasi gagal dihapus.');
        }

        return redirect()->to(site_url('admin/aspirasi'))->with('message', 'Aspirasi berhasil dihapus.');
    }
}
