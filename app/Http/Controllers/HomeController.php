<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PageSeo;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.accueil', [
            'services' => Service::where('is_active', true)->latest()->take(6)->get(),
            'articles' => Article::published()->with('category')->latest('published_at')->take(3)->get(),
            'seo' => PageSeo::for('accueil'),
        ]);
    }

    public function about()
    {
        return view('pages.a-propos', ['seo' => PageSeo::for('a-propos')]);
    }

    public function privacy()
    {
        return view('pages.confidentialite', ['seo' => PageSeo::for('confidentialite')]);
    }

    public function terms()
    {
        return view('pages.conditions', ['seo' => PageSeo::for('conditions')]);
    }
}
