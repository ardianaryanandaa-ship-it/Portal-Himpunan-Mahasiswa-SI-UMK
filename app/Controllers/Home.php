<?php

namespace App\Controllers;

use App\Libraries\LandingPageContent;

class Home extends BaseController
{
    public function index()
    {
        return view('frontend/pages/home', [
            'title' => 'Beranda - HIMA SI',
            'landingPage' => LandingPageContent::values(),
            'news' => [],
            'hasNewsRecords' => false,
            'events' => [],
            'hasEventRecords' => false,
            'achievements' => [],
            'achievementCount' => 0,
            'galleries' => [],
            'hasGalleryRecords' => false,
            'galleryItems' => [],
            'faqs' => [],
            'hasFaqRecords' => false,
        ]);
    }
}