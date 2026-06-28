@props(['article'])
<article class="reveal hover-lift group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm shadow-slate-900/[.02] hover:shadow-lg hover:shadow-slate-900/[.05]" data-reveal>
    <a href="{{ route('articles.show', $article) }}" class="block aspect-[16/9] overflow-hidden bg-surface">
        @if($article->featured_image)<img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-[1.025]" loading="lazy">@else<div class="relative grid h-full place-items-center bg-surface"><img src="{{ asset('images/logo.png') }}" alt="" class="w-44 opacity-40 transition duration-500 ease-out group-hover:scale-[1.025]" loading="lazy"></div>@endif
    </a>
    <div class="p-6">
        <div class="mb-4 flex items-center gap-3 text-xs uppercase tracking-wider text-slate-500"><span class="font-semibold text-coral">{{ $article->category?->name ?? 'Conseil' }}</span><span>—</span><time>{{ $article->published_at?->translatedFormat('d M Y') }}</time></div>
        <h3 class="mb-3 text-lg font-bold leading-snug text-charcoal transition-colors duration-300 group-hover:text-coral"><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
        <p class="mb-5 line-clamp-3 leading-7">{{ $article->excerpt }}</p>
        <a href="{{ route('articles.show', $article) }}" class="text-sm font-semibold text-coral">Lire l’article →</a>
    </div>
</article>
