<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Libraries\LandingPageContent;

abstract class BaseFrontendController extends BaseController
{
    /**
     * Render halaman publik dengan konten landing page dan identitas organisasi.
     */
    protected function render(string $view, array $data = []): string
    {
        return view($view, array_merge([
            'landingPage'  => LandingPageContent::values(),
            'organization' => config('Organization'),
        ], $data));
    }
}
