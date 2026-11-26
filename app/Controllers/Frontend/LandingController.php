<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Controllers\Home;

class LandingController extends BaseController
{
    public function index(): string
    {
        return (new Home())->index();
    }
}
