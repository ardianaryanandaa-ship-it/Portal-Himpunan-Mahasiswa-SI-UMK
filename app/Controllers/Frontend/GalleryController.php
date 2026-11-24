<?php

namespace App\Controllers\Frontend;

use App\Models\GalleryModel;

class GalleryController extends BaseFrontendController
{
    public function index()
    {
        $model = model(GalleryModel::class);

        return $this->render('frontend/pages/gallery', [
            'title'     => 'Galeri - ' . config('Organization')->name,
            'galleries' => $model
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('event_date', 'DESC')
                ->paginate(12, 'galeri'),
            'pager'     => $model->pager,
        ]);
    }
}
