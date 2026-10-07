<?php

namespace App\Http\Controllers;

use App\Models\PageSeo;
use App\Models\Service;

class CasablancaController extends Controller
{
    public function index()
    {
        return view('pages.sites.casa', ['services' => Service::where('is_active', true)->get(), 'seo' => PageSeo::for('casablanca')]);
    }

   
}