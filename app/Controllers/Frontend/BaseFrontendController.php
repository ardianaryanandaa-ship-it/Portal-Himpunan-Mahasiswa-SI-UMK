<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

abstract class BaseFrontendController extends BaseController
{
    /**
     * Render halaman publik dengan identitas organisasi.
     */
    protected function render(string $view, array $data = []): string
    {
        return view($view, array_merge([
            'landingPage'  => [],
            'organization' => config('Organization'),
        ], $data));
    }
}
