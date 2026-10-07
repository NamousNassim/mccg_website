<?php

namespace App\Http\Controllers;

use App\Models\PageSeo;
use App\Models\Service;

class Dubaicontroller extends Controller
{
    public function index()
    {
        return view('pages.sites.dubai', ['services' => Service::where('is_active', true)->get(), 'seo' => PageSeo::for('dubai')]);
    }

   
}