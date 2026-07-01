@props(['title', 'text', 'icon' => 'target'])
<article class="reveal hover-lift group rounded-xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/[.03] hover:shadow-lg hover:shadow-slate-900/[.05] sm:p-7" data-reveal>
    <div class="feature-icon mb-5 grid size-11 place-items-center rounded-lg border border-coral/20 text-coral">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3a9 9 0 1 0 9 9M12 7a5 5 0 1 0 5 5M12 11a1 1 0 1 0 1 1m0-9v5h5"/></svg>
    </div>
    <h3 class="text-lg font-bold text-charcoal">{{ $title }}</h3>
    <p class="mt-3 leading-7 text-slate-600">{{ $text }}</p>
</article>
