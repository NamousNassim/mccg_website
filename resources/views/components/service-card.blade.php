@props(['service'])
<article class="reveal hover-lift group flex h-full flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-900/[.02] hover:border-coral/40 hover:shadow-lg hover:shadow-slate-900/[.05] sm:p-7" data-reveal>
    <div class="service-icon mb-6 grid size-11 place-items-center rounded-lg border border-coral/20 text-coral sm:mb-7 sm:size-12">
        @switch($service->icon)
            @case('calculator')
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2" stroke-width="1.5"/><path stroke-linecap="round" stroke-width="1.5" d="M8 7h8v3H8zM8.5 14h.01m3.49 0h.01m3.49 0h.01M8.5 17.5h.01m3.49 0h.01m3.49 0h.01"/></svg>
                @break
            @case('scale')
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v18M5 6h14M4 6l-2 7a4 4 0 0 0 8 0L8 6m8 0-2 7a4 4 0 0 0 8 0l-2-7M8 21h8"/></svg>
                @break
            @case('check')
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3 4.5 6v5.25c0 4.6 3.2 8.9 7.5 9.75 4.3-.85 7.5-5.15 7.5-9.75V6L12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m8.5 12 2.25 2.25L15.5 9.5"/></svg>
                @break
            @case('users')
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 20v-1.5a4.5 4.5 0 0 0-4.5-4.5h-3A4.5 4.5 0 0 0 4 18.5V20m6-10a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7.5 3a3 3 0 0 1 2.5 3v1m-4-9.75a3 3 0 0 1 0 5.5"/></svg>
                @break
            @case('building')
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 3h8l4 4v14H6V3Z M14 3v5h4M9 12h6M9 15h4"/><circle cx="16.5" cy="17.5" r="2.5" fill="white" stroke-width="1.5"/></svg>
                @break
            @default
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 19.5h16M6.5 16V9m5.5 7V5m5.5 11v-4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m7 6 4-3 3 2 4-3"/></svg>
        @endswitch
    </div>
    <h3 class="mb-3 text-lg font-bold text-charcoal">{{ $service->title }}</h3>
    <p class="mb-7 grow leading-7 text-slate-600">{{ $service->short_description }}</p>
    <a href="{{ route('services.show', $service) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-coral hover:text-coral-dark">En savoir plus <span class="service-link-arrow" aria-hidden="true">→</span></a>
</article>
