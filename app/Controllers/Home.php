<?php

namespace App\Controllers;

use App\Controllers\Backend\GalleryController;
use App\Libraries\LandingPageContent;
use App\Models\AspirasiModel;
use App\Models\EventModel;
use App\Models\NewsModel;
use App\Models\WorkProgramModel;

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

        $latestNews = model(NewsModel::class)
            ->where('status', 'published')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->where('deleted_at', null)
            ->orderBy('published_at', 'DESC')
            ->findAll();

        $events = model(EventModel::class)
            ->where('status', 'published')
            ->where('deleted_at', null)
            ->orderBy('start_at', 'ASC')
            ->findAll();

        $workPrograms = model(WorkProgramModel::class)
            ->withDivision()
            ->orderBy('work_programs.target_date', 'ASC')
            ->orderBy('work_programs.id', 'ASC')
            ->findAll();

        return view('frontend/pages/home', [
            'title' => 'Beranda - HIMA SI',
            'news' => $latestNews,
            'hasNewsRecords' => ! empty($latestNews),
            'events' => $events,
            'hasEventRecords' => ! empty($events),
            'workPrograms' => $workPrograms,
            'hasProgramRecords' => ! empty($workPrograms),
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