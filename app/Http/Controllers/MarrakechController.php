<?php

namespace App\Http\Controllers;

use App\Models\PageSeo;
use App\Models\Service;

class MarrakechController extends Controller
{
    public function index()
    {
        return view('pages.sites.marrakech', ['services' => Service::where('is_active', true)->get(), 'seo' => PageSeo::for('marrakech')]);
    }

   
}