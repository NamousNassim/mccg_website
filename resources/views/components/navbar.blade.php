<header class="site-navbar sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur" data-navbar>
    <div class="container-site flex h-16 items-center justify-between sm:h-20">
        <a href="{{ route('accueil') }}" class="block h-12 w-[170px] overflow-hidden sm:h-14 sm:w-[200px]" aria-label="MCCG — Accueil">
            <img src="{{ asset('images/logo.png') }}" alt="MCCG" class="w-[180px] max-w-none -translate-x-1 -translate-y-[23px] sm:w-[210px] sm:-translate-y-[27px]" width="310" height="163">
        </a>
        <nav class="hidden items-center gap-7 text-[13px] font-semibold text-slate-600 lg:flex" aria-label="Navigation principale">
            <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
            <a class="nav-link {{ request()->routeIs('a-propos') ? 'active' : '' }}" href="{{ route('a-propos') }}">À propos</a>
            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
            <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">Articles</a>
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            <x-button-primary :href="route('contact', ['objet' => 'consultation'])" class="!px-5 !py-3">Nous consulter</x-button-primary>
        </nav>
        <button id="menu-toggle" type="button" class="grid size-11 place-items-center rounded-md border border-slate-200 text-charcoal focus:outline-none focus:ring-2 focus:ring-coral/30 lg:hidden" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>
    <nav id="mobile-menu" class="mobile-menu-panel absolute inset-x-0 top-full border-t border-slate-100 bg-white shadow-lg lg:hidden" aria-hidden="true">
        <div class="container-site flex max-h-[calc(100dvh-4rem)] flex-col gap-1 overflow-y-auto py-4 font-heading font-semibold text-charcoal sm:max-h-[calc(100dvh-5rem)]">
            <a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('accueil') }}">Accueil</a><a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('a-propos') }}">À propos</a>
            <a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('services.index') }}">Services</a><a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('articles.index') }}">Articles</a>
            <a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('contact') }}">Contact</a><x-button-primary :href="route('contact', ['objet' => 'consultation'])" class="mt-3 w-full text-center">Nous consulter</x-button-primary>
        </div>
    </nav>
</header>
