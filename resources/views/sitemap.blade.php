<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($pages as $url)<url><loc>{{ $url }}</loc><changefreq>weekly</changefreq></url>@endforeach
@foreach($services as $service)<url><loc>{{ route('services.show', $service) }}</loc><lastmod>{{ $service->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq></url>@endforeach
@foreach($articles as $article)<url><loc>{{ route('articles.show', $article) }}</loc><lastmod>{{ $article->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq></url>@endforeach
</urlset>
