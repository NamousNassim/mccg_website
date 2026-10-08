


<header class="site-navbar sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur" data-navbar>
    <style>
        .office-menu { position: relative; }
        .office-menu__trigger {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 0;
            background: transparent;
            color: inherit;
            cursor: pointer;
            font: inherit;
        }
        .office-menu__chevron {
            width: .85rem;
            height: .85rem;
            transition: transform .25s ease;
        }
        .office-menu__panel {
            position: absolute;
            z-index: 60;
            top: calc(100% + 1rem);
            left: 50%;
            width: 13rem;
            padding: .5rem;
            border: 1px solid rgb(226 232 240);
            border-radius: .75rem;
            background: #fff;
            box-shadow: 0 18px 45px rgb(51 51 51 / .14);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translate(-50%, -.5rem);
            transition: opacity .2s ease, transform .25s ease, visibility .25s;
        }
        .office-menu__panel::before {
            content: '';
            position: absolute;
            right: 0;
            bottom: 100%;
            left: 0;
            height: 1rem;
        }
        .office-menu__link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 2.75rem;
            padding: .65rem .75rem;
            border-radius: .5rem;
            color: #475569;
            transition: color .2s ease, background-color .2s ease, transform .2s ease;
        }
        .office-menu__link:hover,
        .office-menu__link:focus-visible {
            background: #f2f2f2;
            color: #e84c64;
            outline: none;
            transform: translateX(.15rem);
        }
        .office-menu__link.is-active {
            background: rgb(232 76 100 / .09);
            color: #e84c64;
        }
        .office-menu__dot {
            width: .35rem;
            height: .35rem;
            border-radius: 999px;
            background: currentColor;
            opacity: .65;
        }
        .office-menu.is-open .office-menu__panel,
        .office-menu:focus-within .office-menu__panel {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translate(-50%, 0);
        }
        .office-menu.is-open .office-menu__chevron,
        .office-menu:focus-within .office-menu__chevron { transform: rotate(180deg); }
        @media (hover: hover) and (pointer: fine) {
            .office-menu:hover .office-menu__panel {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                transform: translate(-50%, 0);
            }
            .office-menu:hover .office-menu__chevron { transform: rotate(180deg); }
        }
        .mobile-office-menu summary { list-style: none; }
        .mobile-office-menu summary::-webkit-details-marker { display: none; }
        .mobile-office-menu__chevron {
            display: block;
            width: 1rem;
            height: 1rem;
            flex: 0 0 1rem;
            transition: transform .2s ease;
        }
        .mobile-office-menu[open] .mobile-office-menu__chevron { transform: rotate(180deg); }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const officeMenu = document.querySelector('[data-office-menu]');
            const officeTrigger = officeMenu?.querySelector('[data-office-trigger]');

            if (!officeMenu || !officeTrigger) return;

            const setOfficeMenu = function (isOpen) {
                officeMenu.classList.toggle('is-open', isOpen);
                officeTrigger.setAttribute('aria-expanded', String(isOpen));
            };

            officeTrigger.addEventListener('click', function () {
                setOfficeMenu(!officeMenu.classList.contains('is-open'));
            });

            document.addEventListener('click', function (event) {
                if (!officeMenu.contains(event.target)) setOfficeMenu(false);
            });

            officeMenu.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') return;
                setOfficeMenu(false);
                officeTrigger.focus();
            });
        });
    </script>
    <div class="container-site flex h-16 items-center justify-between sm:h-20">

        <a href="{{ route('accueil') }}" class="block h-12 w-[170px] overflow-hidden sm:h-14 sm:w-[200px]" aria-label="MCCG — Accueil">
            <img src="{{ asset('images/logo.png') }}" alt="MCCG" class="w-[180px] max-w-none -translate-x-1 -translate-y-[23px] sm:w-[210px] sm:-translate-y-[27px]" width="310" height="163">
        </a>
        <nav class="hidden items-center gap-7 text-[13px] font-semibold text-slate-600 lg:flex" aria-label="Navigation principale">
            <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
            <a class="nav-link {{ request()->routeIs('a-propos') ? 'active' : '' }}" href="{{ route('a-propos') }}">À propos</a>
            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
            <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">Articles</a>
            <div class="office-menu" data-office-menu>
                <button
                    type="button"
                    class="nav-link office-menu__trigger {{ request()->routeIs('marrakech', 'casablanca', 'dubai') ? 'active' : '' }}"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="office-menu-panel"
                    data-office-trigger
                >
                    Nos sites
                    <svg class="office-menu__chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path d="m4 6 4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div id="office-menu-panel" class="office-menu__panel" aria-label="Choisir un site">
                    <a class="office-menu__link {{ request()->routeIs('marrakech') ? 'is-active' : '' }}" href="{{ route('marrakech') }}">
                        Marrakech <span class="office-menu__dot" aria-hidden="true"></span>
                    </a>
                    <a class="office-menu__link {{ request()->routeIs('casablanca') ? 'is-active' : '' }}" href="{{ route('casablanca') }}">
                        Casablanca <span class="office-menu__dot" aria-hidden="true"></span>
                    </a>
                    <a class="office-menu__link {{ request()->routeIs('dubai') ? 'is-active' : '' }}" href="{{ route('dubai') }}">
                        Dubaï <span class="office-menu__dot" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
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
            <details class="mobile-office-menu">
                <summary class="flex min-h-11 cursor-pointer items-center justify-between rounded-md px-2 hover:bg-surface hover:text-coral">
                    <span>Nos sites</span>
                    <svg class="mobile-office-menu__chevron size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path d="m4 6 4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </summary>
                <div class="mb-2 ml-2 border-l border-slate-200 pl-3" style="display: grid; row-gap: 3px; margin-top: 6px;">
                    <a class="flex min-h-10 items-center rounded-md px-3 text-sm hover:bg-surface hover:text-coral {{ request()->routeIs('marrakech') ? 'bg-surface text-coral' : '' }}" style="padding-top: 3px; padding-bottom: 3px;" href="{{ route('marrakech') }}">Marrakech</a>
                    <a class="flex min-h-10 items-center rounded-md px-3 text-sm hover:bg-surface hover:text-coral {{ request()->routeIs('casablanca') ? 'bg-surface text-coral' : '' }}" style="padding-top: 3px; padding-bottom: 3px;" href="{{ route('casablanca') }}">Casablanca</a>
                    <a class="flex min-h-10 items-center rounded-md px-3 text-sm hover:bg-surface hover:text-coral {{ request()->routeIs('dubai') ? 'bg-surface text-coral' : '' }}" style="padding-top: 3px; padding-bottom: 3px;" href="{{ route('dubai') }}">Dubaï</a>
                </div>
            </details>
            <a class="flex min-h-11 items-center rounded-md px-2 hover:bg-surface hover:text-coral" href="{{ route('contact') }}">Contact</a><x-button-primary :href="route('contact', ['objet' => 'consultation'])" class="mt-3 w-full text-center">Nous consulter</x-button-primary>
        </div>
    </nav>
</header>
