<?php

namespace App\Http\Controllers;

use App\Models\PageSeo;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', ['services' => Service::where('is_active', true)->get(), 'seo' => PageSeo::for('services')]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('services.show', compact('service'));
    }
}
