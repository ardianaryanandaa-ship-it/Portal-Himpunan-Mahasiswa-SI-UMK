<?php

namespace App\Controllers\Frontend;

class PageController extends BaseFrontendController
{
    public function about()
    {
        return $this->render('frontend/pages/about', [
            'title' => 'Tentang Kami - ' . config('Organization')->name,
        ]);
    }

    public function contact()
    {
        return $this->render('frontend/pages/contact', [
            'title' => 'Kontak - ' . config('Organization')->name,
        ]);
    }
}
