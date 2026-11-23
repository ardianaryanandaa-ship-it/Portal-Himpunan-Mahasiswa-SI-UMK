<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\GalleryItemModel;
use App\Models\GalleryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GaleriController extends BaseController
{
    public static function publishedForLanding(): array
    {
        $galleries = model(GalleryModel::class)
            ->where('is_published', 1)
            ->where('deleted_at', null)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('event_date', 'DESC')
            ->findAll();

        $galleryItems = model(GalleryItemModel::class)
            ->select('gallery_items.*, galleries.title AS gallery_title')
            ->join('galleries', 'galleries.id = gallery_items.gallery_id')
            ->where('galleries.is_published', 1)
            ->where('galleries.deleted_at', null)
            ->where('gallery_items.deleted_at', null)
            ->orderBy('gallery_items.sort_order', 'ASC')
            ->orderBy('gallery_items.id', 'ASC')
            ->findAll();

        return [
            'galleries' => $galleries,
            'hasGalleryRecords' => $galleries !== [],
            'galleryItems' => $galleryItems,
        ];
    }

    private function galleryModel(): GalleryModel
    {
        return model(GalleryModel::class);
    }

    private function itemModel(): GalleryItemModel
    {
        return model(GalleryItemModel::class);
    }

    public function index()
    {
        $galleries = $this->galleryModel()->orderBy('sort_order', 'ASC')->orderBy('event_date', 'DESC')->findAll();
        foreach ($galleries as &$gallery) {
            $gallery['item_count'] = $this->itemModel()->where('gallery_id', $gallery['id'])->countAllResults();
        }

        return view('backend/galeri/index', [
            'title' => 'Kelola Galeri Aktivitas',
            'galleries' => $galleries,
        ]);
    }

    public function create()
    {
        return view('backend/galeri/form', [
            'title' => 'Tambah Galeri',
            'gallery' => null,
            'items' => [],
        ]);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|max_length[150]',
            'description' => 'permit_empty|max_length[5000]',
            'event_date' => 'permit_empty|valid_date',
            'sort_order' => 'permit_empty|integer',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali data galeri.');
        }

        $cover = $this->uploadFile('cover_image', ['jpg', 'jpeg', 'png', 'webp'], 5 * 1024 * 1024);
        if (is_string($cover) && str_starts_with($cover, 'ERROR:')) {
            return redirect()->back()->withInput()->with('error', substr($cover, 6));
        }

        $id = $this->galleryModel()->insert([
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'event_date' => $this->request->getPost('event_date') ?: null,
            'cover_image' => is_string($cover) ? $cover : null,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
        ], true);

        if (! $id) {
            return redirect()->back()->withInput()->with('error', 'Galeri gagal disimpan.');
        }

        return redirect()->to(site_url('admin/galeri/' . $id . '/edit'))->with('message', 'Galeri berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $gallery = $this->galleryModel()->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $items = $this->itemModel()
            ->where('gallery_id', $id)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('backend/galeri/form', [
            'title' => 'Edit Galeri',
            'gallery' => $gallery,
            'items' => $items,
        ]);
    }

    public function update(int $id)
    {
        $gallery = $this->galleryModel()->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $rules = [
            'title' => 'required|max_length[150]',
            'description' => 'permit_empty|max_length[5000]',
            'event_date' => 'permit_empty|valid_date',
            'sort_order' => 'permit_empty|integer',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali data galeri.');
        }

        $cover = $this->uploadFile('cover_image', ['jpg', 'jpeg', 'png', 'webp'], 5 * 1024 * 1024);
        if (is_string($cover) && str_starts_with($cover, 'ERROR:')) {
            return redirect()->back()->withInput()->with('error', substr($cover, 6));
        }

        $data = [
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'event_date' => $this->request->getPost('event_date') ?: null,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
        ];
        if (is_string($cover)) {
            $this->deletePublicFile($gallery['cover_image']);
            $data['cover_image'] = $cover;
        }

        if (! $this->galleryModel()->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Perubahan galeri gagal disimpan.');
        }

        return redirect()->back()->with('message', 'Galeri berhasil diperbarui.');
    }

    public function togglePublish(int $id)
    {
        $gallery = $this->galleryModel()->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $published = (int) $gallery['is_published'] === 1;
        $this->galleryModel()->update($id, ['is_published' => $published ? 0 : 1]);

        return redirect()->back()->with('message', $published ? 'Galeri dihentikan dari publikasi.' : 'Galeri berhasil dipublikasikan.');
    }

    public function delete(int $id)
    {
        $gallery = $this->galleryModel()->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $items = $this->itemModel()->where('gallery_id', $id)->findAll();
        foreach ($items as $item) {
            $this->itemModel()->delete($item['id']);
            $this->deletePublicFile($item['file_path']);
        }
        $this->deletePublicFile($gallery['cover_image']);
        $this->galleryModel()->delete($id);

        return redirect()->to(site_url('admin/galeri'))->with('message', 'Galeri berhasil dihapus.');
    }

    public function storeItem(int $id)
    {
        $gallery = $this->galleryModel()->find($id);
        if ($gallery === null) {
            throw new PageNotFoundException('Galeri tidak ditemukan.');
        }

        $file = $this->uploadFile('media', ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'webm'], 20 * 1024 * 1024);
        if (! is_string($file) || str_starts_with($file, 'ERROR:')) {
            return redirect()->back()->with('error', is_string($file) ? substr($file, 6) : 'Media wajib dipilih.');
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mediaType = in_array($extension, ['mp4', 'webm'], true) ? 'video' : 'image';
        $this->itemModel()->insert([
            'gallery_id' => $id,
            'file_path' => $file,
            'media_type' => $mediaType,
            'caption' => trim((string) $this->request->getPost('caption')) ?: null,
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
        ]);

        return redirect()->back()->with('message', 'Media berhasil ditambahkan.');
    }

    public function deleteItem(int $itemId)
    {
        $item = $this->itemModel()->find($itemId);
        if ($item === null) {
            throw new PageNotFoundException('Media tidak ditemukan.');
        }

        $this->itemModel()->delete($itemId);
        $this->deletePublicFile($item['file_path']);

        return redirect()->back()->with('message', 'Media berhasil dihapus.');
    }

    private function uploadFile(string $field, array $extensions, int $maxSize): ?string
    {
        $file = $this->request->getFile($field);
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }
        if (! in_array(strtolower($file->getExtension()), $extensions, true)) {
            return 'ERROR:Format file tidak didukung.';
        }
        if ($file->getSize() > $maxSize) {
            return 'ERROR:Ukuran file melebihi batas.';
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'gallery';
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = $file->getRandomName();
        $file->move($directory, $name);

        return 'uploads/gallery/' . $name;
    }

    private function deletePublicFile(?string $path): void
    {
        if (! $path) {
            return;
        }
        $absolute = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($path, '/'));
        if (is_file($absolute)) {
            unlink($absolute);
        }
    }
}
