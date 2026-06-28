<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        return response()->view('sitemap', [
            'pages' => [route('accueil'), route('a-propos'), route('services.index'), route('articles.index'), route('contact'), route('confidentialite'), route('conditions')],
            'services' => Service::where('is_active', true)->get(),
            'articles' => Article::published()->get(),
        ])->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: ".route('sitemap')."\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}
