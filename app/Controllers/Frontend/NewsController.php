<?php

namespace App\Controllers\Frontend;

use App\Libraries\HtmlSanitizer;
use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class NewsController extends BaseFrontendController
{
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        $model = model(NewsModel::class)
            ->where('status', 'published')
            ->where('published_at <=', date('Y-m-d H:i:s'));

        if ($keyword !== '') {
            $model->groupStart()->like('title', $keyword)->orLike('excerpt', $keyword)->groupEnd();
        }

        return $this->render('frontend/pages/news/index', [
            'title'   => 'Berita - ' . config('Organization')->name,
            'news'    => $model->orderBy('published_at', 'DESC')->paginate(9, 'berita'),
            'pager'   => $model->pager,
            'keyword' => $keyword,
        ]);
    }

    public function show(string $slug)
    {
        $news = model(NewsModel::class)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->first();

        if ($news === null) {
            throw new PageNotFoundException('Berita tidak ditemukan.');
        }

        $related = model(NewsModel::class)
            ->where('status', 'published')
            ->where('id !=', $news['id'])
            ->orderBy('published_at', 'DESC')
            ->findAll(3);

        return $this->render('frontend/pages/news/show', [
            'title'   => $news['title'] . ' - ' . config('Organization')->name,
            'news'    => $news,
            'related' => $related,
            'content' => HtmlSanitizer::clean((string) $news['content']),
        ]);
    }
}
