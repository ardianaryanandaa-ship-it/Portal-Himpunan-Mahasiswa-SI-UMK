<?php

namespace App\Controllers;

<<<<<<< HEAD
=======
use App\Controllers\Backend\GalleryController;
use App\Libraries\LandingPageContent;
>>>>>>> origin/nando
use App\Models\AspirasiModel;

class Home extends BaseController
{
    public function index(): string
    {
        $publishedAspirations = model(AspirasiModel::class)
            ->where('is_published', 1)
            ->where('deleted_at', null)
            ->orderBy('published_at', 'DESC')
            ->findAll(3);
        $galleryData = GalleryController::publishedForLanding();

        return view('frontend/pages/home', [
            'title' => 'Beranda - HIMA SI',
            'news' => [],
            'hasNewsRecords' => false,
            'events' => [],
            'hasEventRecords' => false,
            'achievements' => [],
            'achievementCount' => 0,
            'galleries' => $galleryData['galleries'],
            'hasGalleryRecords' => $galleryData['hasGalleryRecords'],
            'galleryItems' => $galleryData['galleryItems'],
            'faqs' => [],
            'hasFaqRecords' => false,
            'publishedAspirations' => $publishedAspirations,
        ]);
    }
}