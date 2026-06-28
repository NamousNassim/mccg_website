<header class="site-navbar sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur" data-navbar>
    <div class="container-site flex h-20 items-center justify-between">
        <a href="{{ route('accueil') }}" class="block h-14 w-[200px] overflow-hidden" aria-label="MCCG — Accueil">
            <img src="{{ asset('images/logo.png') }}" alt="MCCG" class="w-[210px] max-w-none -translate-x-1 -translate-y-[27px]" width="310" height="163">
        </a>
        <nav class="hidden items-center gap-7 text-[13px] font-semibold text-slate-600 lg:flex" aria-label="Navigation principale">
            <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
            <a class="nav-link {{ request()->routeIs('a-propos') ? 'active' : '' }}" href="{{ route('a-propos') }}">À propos</a>
            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
            <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">Articles</a>
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            <x-button-primary :href="route('contact', ['objet' => 'consultation'])" class="!px-5 !py-3">Nous consulter</x-button-primary>
        </nav>
        <button id="menu-toggle" class="grid size-11 place-items-center rounded-md border border-slate-200 text-charcoal lg:hidden" aria-label="Ouvrir le menu" aria-expanded="false">
            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>
    <nav id="mobile-menu" class="mobile-menu-panel absolute inset-x-0 top-full border-t border-slate-100 bg-white shadow-lg lg:hidden" aria-hidden="true">
        <div class="container-site flex flex-col gap-4 py-5 font-heading font-semibold text-charcoal">
            <a href="{{ route('accueil') }}">Accueil</a><a href="{{ route('a-propos') }}">À propos</a>
            <a href="{{ route('services.index') }}">Services</a><a href="{{ route('articles.index') }}">Articles</a>
            <a href="{{ route('contact') }}">Contact</a><x-button-primary :href="route('contact', ['objet' => 'consultation'])" class="text-center">Nous consulter</x-button-primary>
        </div>
    </nav>
</header>
