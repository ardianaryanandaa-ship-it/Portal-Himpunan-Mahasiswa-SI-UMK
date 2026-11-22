<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\HtmlSanitizer;
use App\Libraries\Slugger;
use App\Libraries\Uploader;
use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class NewsController extends BaseController
{
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $status  = (string) $this->request->getGet('status');

        $model = model(NewsModel::class);
        if ($keyword !== '') {
            $model->groupStart()->like('title', $keyword)->orLike('excerpt', $keyword)->groupEnd();
        }
        if (in_array($status, ['draft', 'published'], true)) {
            $model->where('status', $status);
        }

        return view('backend/news/index', [
            'title'   => 'Kelola Berita',
            'news'    => $model->orderBy('created_at', 'DESC')->paginate(10, 'news'),
            'pager'   => $model->pager,
            'keyword' => $keyword,
            'status'  => $status,
        ]);
    }

    public function create()
    {
        return view('backend/news/form', [
            'title' => 'Tambah Berita',
            'news'  => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = model(NewsModel::class);
        $title = trim((string) $this->request->getPost('title'));
        $data  = [
            'title'        => $title,
            'slug'         => Slugger::unique($model, $title),
            'excerpt'      => trim((string) $this->request->getPost('excerpt')),
            'content'      => HtmlSanitizer::clean((string) $this->request->getPost('content')),
            'status'       => $this->request->getPost('status') === 'published' ? 'published' : 'draft',
            'published_at' => $this->request->getPost('status') === 'published' ? date('Y-m-d H:i:s') : null,
            'created_by'   => (int) session('user_id'),
        ];

        try {
            $thumbnail = (new Uploader())->image($this->request->getFile('thumbnail'), 'news');
            if ($thumbnail !== null) {
                $data['thumbnail'] = $thumbnail;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->insert($data);

        return redirect()->to(site_url('admin/berita'))->with('message', 'Berita berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $news = model(NewsModel::class)->find($id);
        if ($news === null) {
            throw new PageNotFoundException('Berita tidak ditemukan.');
        }

        return view('backend/news/form', [
            'title' => 'Edit Berita',
            'news'  => $news,
        ]);
    }

    public function update(int $id)
    {
        $model = model(NewsModel::class);
        $news  = $model->find($id);
        if ($news === null) {
            throw new PageNotFoundException('Berita tidak ditemukan.');
        }

        if (! $this->validate($this->rules(), $this->messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = trim((string) $this->request->getPost('title'));
        $data  = [
            'title'   => $title,
            'slug'    => Slugger::unique($model, $title, $id),
            'excerpt' => trim((string) $this->request->getPost('excerpt')),
            'content' => HtmlSanitizer::clean((string) $this->request->getPost('content')),
            'status'  => $this->request->getPost('status') === 'published' ? 'published' : 'draft',
        ];

        if ($data['status'] === 'published' && empty($news['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        try {
            $thumbnail = (new Uploader())->image($this->request->getFile('thumbnail'), 'news');
            if ($thumbnail !== null) {
                $data['thumbnail'] = $thumbnail;
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/berita'))->with('message', 'Berita berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $model = model(NewsModel::class);
        if ($model->find($id) === null) {
            return redirect()->to(site_url('admin/berita'))->with('error', 'Berita tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(site_url('admin/berita'))->with('message', 'Berita berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'title'   => 'required|max_length[200]',
            'excerpt' => 'permit_empty|max_length[1000]',
            'content' => 'required',
            'status'  => 'required|in_list[draft,published]',
        ];
    }

    private function messages(): array
    {
        return [
            'title' => ['required' => 'Judul berita wajib diisi.', 'max_length' => 'Judul berita maksimal 200 karakter.'],
            'content' => ['required' => 'Isi berita wajib diisi.'],
            'status' => ['required' => 'Status berita wajib dipilih.', 'in_list' => 'Status berita tidak valid.'],
        ];
    }
}
