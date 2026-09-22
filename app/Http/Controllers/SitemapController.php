<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Service;
use App\Support\CanonicalUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(CanonicalUrl $canonicalUrl): Response
    {
        $pages = collect([
            'accueil',
            'a-propos',
            'services.index',
            'articles.index',
            'contact',
            'confidentialite',
            'conditions',
        ])->map(fn (string $routeName): array => [
            'loc' => $canonicalUrl->route($routeName),
            'lastmod' => null,
        ]);

        $services = Service::where('is_active', true)
            ->get()
            ->map(fn (Service $service): array => [
                'loc' => $canonicalUrl->route('services.show', $service),
                'lastmod' => $this->lastModified($service),
            ]);

        $articles = Article::published()
            ->get()
            ->map(fn (Article $article): array => [
                'loc' => $canonicalUrl->route('articles.show', $article),
                'lastmod' => $this->lastModified($article, $article->published_at),
            ]);

        return response()->view('sitemap', [
            'urls' => $pages->concat($services)->concat($articles),
        ])->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(CanonicalUrl $canonicalUrl): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: ".$canonicalUrl->route('sitemap')."\n";

        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    private function lastModified(Model $model, mixed $publishedAt = null): ?string
    {
        $lastModified = collect([$model->updated_at, $publishedAt])
            ->filter()
            ->sortByDesc(fn ($date): int => $date->getTimestamp())
            ->first();

        return $lastModified?->toAtomString();
    }
}
