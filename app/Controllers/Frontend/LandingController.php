<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Controllers\Backend\AspirasiController;
use App\Controllers\Backend\GaleriController;

class LandingController extends BaseController
{
    public function index(): string
    {
        return view('frontend/pages/home', array_merge([
            'title' => 'Beranda - HIMA SI',
            'news' => [],
            'hasNewsRecords' => false,
            'events' => [],
            'hasEventRecords' => false,
            'achievements' => [],
            'achievementCount' => 0,
            'faqs' => [],
            'hasFaqRecords' => false,
            'publishedAspirations' => AspirasiController::publishedForLanding(),
        ], GaleriController::publishedForLanding()));
    }
}
