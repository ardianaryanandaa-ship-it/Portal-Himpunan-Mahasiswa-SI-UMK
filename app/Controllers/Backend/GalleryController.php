<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Uploader;
use App\Models\GalleryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class GalleryController extends BaseController
{
    public static function publishedForLanding(): array
    {
        $galleries = model(GalleryModel::class)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('event_date', 'DESC')
            ->findAll();

        return [
            'galleries'         => $galleries,
            'hasGalleryRecords' => $galleries !== [],
            'galleryItems'      => [],
        ];
    }

    public function index()
    {
        $model = model(GalleryModel::class);

        return view('backend/galleries/index', [
            'title'     => 'Kelola Galeri',
            'galleries' => $model->orderBy('sort_order', 'ASC')->orderBy('event_date', 'DESC')->paginate(12, 'galeri'),
            'pager'     => $model->pager,
        ]);
    }

    public function create()
    {
        return view('backend/galleries/form', [
            'title'   => 'Tambah Galeri',
            'gallery' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(true), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $image = (new Uploader())->image($this->request->getFile('image'), 'galleries');
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        if ($image === null) {
            return redirect()->back()->withInput()->with('error', 'Gambar galeri wajib diunggah.');
        }

        model(GalleryModel::class)->insert([
            'title'       => trim((string) $this->request->getPost('title')),
            'image'       => $image,
            'description' => trim((string) $this->request->getPost('description')),
            'event_date'  => $this->request->getPost('event_date') ?: null,
            'is_active'   => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'created_by'  => (int) session('user_id'),
        ]);

        return redirect()->to(site_url('admin/galeri'))->with('message', 'Galeri berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $gallery = model(GalleryModel::class)->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        return view('backend/galleries/form', [
            'title'   => 'Edit Galeri',
            'gallery' => $gallery,
        ]);
    }

    public function update(int $id)
    {
        $model   = model(GalleryModel::class);
        $gallery = $model->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        if (! $this->validate($this->rules(false), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'event_date'  => $this->request->getPost('event_date') ?: null,
            'is_active'   => (int) $this->request->getPost('is_active') === 1 ? 1 : 0,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
        ];

        try {
            $image = (new Uploader())->image($this->request->getFile('image'), 'galleries');
            if ($image !== null) {
                $data['image'] = $image;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/galeri'))->with('message', 'Galeri berhasil diperbarui.');
    }

    public function toggleActive(int $id)
    {
        $model   = model(GalleryModel::class);
        $gallery = $model->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $model->update($id, ['is_active' => (int) $gallery['is_active'] === 1 ? 0 : 1]);

        return redirect()->back()->with('message', 'Status galeri berhasil diubah.');
    }

    public function delete(int $id)
    {
        $model = model(GalleryModel::class);
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/galeri'))->with('error', 'Galeri tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/galeri'))->with('message', 'Galeri berhasil dihapus.');
    }

    private function rules(bool $imageRequired): array
    {
        return [
            'title' => 'required|max_length[200]',
            'image' => $imageRequired ? 'uploaded[image]' : 'permit_empty',
            'event_date' => 'permit_empty|valid_date[Y-m-d]',
            'sort_order' => 'permit_empty|integer',
        ];
    }

    private function messages(): array
    {
        return [
            'title' => ['required' => 'Judul galeri wajib diisi.', 'max_length' => 'Judul galeri maksimal 200 karakter.'],
            'image' => ['uploaded' => 'Gambar galeri wajib diunggah.'],
            'event_date' => ['valid_date' => 'Tanggal kegiatan tidak valid.'],
            'sort_order' => ['integer' => 'Urutan harus berupa angka.'],
        ];
    }
}
