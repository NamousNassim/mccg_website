@extends('layouts.app')



@section('content')
<div class="bg-white text-charcoal">
    
    <section class="overflow-hidden bg-white">
        <div class="container-site grid items-center gap-12 py-12 sm:py-16 lg:min-h-[650px] lg:grid-cols-[1.02fr_.98fr] lg:gap-14 lg:py-20">
            <div class="relative z-10">
                <p class="eyebrow">Cabinet de conseil à Marrakech</p>

                <h1 class="hero-title mt-5 max-w-3xl break-words font-heading text-3xl font-bold leading-[1.12] tracking-tight text-charcoal sm:mt-6 sm:text-5xl lg:text-[3.6rem]">
                    Votre partenaire de confiance pour <span class="highlight-underline text-coral">décider avec clarté.</span>
                </h1>

                <p class="hero-subtitle mt-6 max-w-2xl text-base leading-7 text-slate-600 sm:mt-7 sm:text-lg sm:leading-8">
                    MCCG Marrakech accompagne les entreprises, entrepreneurs et investisseurs en comptabilité, fiscalité, gestion sociale, conseil juridique et démarches administratives.
                </p>

                <div class="hero-actions mt-8 flex flex-col gap-3 sm:mt-9 sm:flex-row">
                    <a href="{{ route('services.index') }}" class="btn-primary w-full sm:w-auto">
                        Découvrir nos services <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary w-full sm:w-auto">
                        Nous contacter
                    </a>
                </div>

                <div class="mt-8 grid gap-3 border-t border-slate-200 pt-6 text-sm text-slate-500 sm:mt-10 sm:flex sm:flex-wrap sm:gap-x-8 sm:gap-y-3">
                    <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Expertise locale</span>
                    <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Conseil sur mesure</span>
                    <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Vision pluridisciplinaire</span>
                </div>
            </div>

            <div class="hero-visual relative pb-10 sm:pb-8">
                <div class="absolute -left-5 -top-5 size-24 rounded-xl border border-coral/20" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-surface shadow-xl shadow-slate-900/[.08]">
                    <img
                        src="{{ asset('images/marrakech.webp') }}"
                        alt="La Koutoubia et la place Jemaa el-Fna à Marrakech"
                        class="hero-parallax aspect-[4/3] max-h-[430px] w-full object-cover"
                        width="1260"
                        height="840"
                        fetchpriority="high"
                        data-parallax
                    >
                </div>
                <div class="absolute bottom-0 left-4 right-4 rounded-xl border border-slate-200 bg-white p-4 shadow-lg sm:-bottom-2 sm:left-10 sm:right-auto sm:p-5">
                    <p class="font-heading text-sm font-bold text-charcoal">MCCG Marrakech</p>
                    <p class="mt-1 text-xs text-slate-500">Guéliz · Marrakech · Maroc</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-space overflow-hidden bg-white">
        <div class="container-site">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-8">
                <div class="lg:col-span-3">
                    <p class="eyebrow reveal" data-reveal>À propos de MCCG Marrakech</p>
                </div>
                <div class="lg:col-span-9">
                    <h2 class="reveal max-w-5xl font-heading text-3xl font-bold leading-[1.12] tracking-[-.035em] text-charcoal sm:text-4xl lg:text-5xl" data-reveal>
                        Nous rendons les sujets complexes plus simples, pour que chaque décision soit prise avec <span class="text-coral">confiance.</span>
                    </h2>

                    <div class="mt-10 grid gap-8 border-t border-slate-200 pt-8 sm:mt-12 sm:grid-cols-2 sm:gap-10">
                        <p class="reveal text-base leading-8 text-slate-600" data-reveal>
                            Entreprises, entrepreneurs et investisseurs évoluent dans un environnement qui exige précision et réactivité. Nous réunissons les expertises essentielles pour vous donner une lecture juste de votre activité.
                        </p>
                        <div class="reveal" data-reveal>
                            <p class="text-base leading-8 text-slate-600">
                                Notre rôle ne s’arrête pas aux obligations. Nous expliquons, anticipons et restons présents lorsque vos projets demandent un regard fiable et une réponse concrète.
                            </p>
                            <a href="{{ route('a-propos') }}" class="group mt-7 inline-flex items-center gap-3 text-sm font-semibold text-charcoal hover:text-coral">
                                Découvrir le cabinet <span class="service-link-arrow" aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space bg-surface">
        <div class="container-site">
            <div class="grid gap-8 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <p class="eyebrow reveal" data-reveal>Nos expertises</p>
                    <h2 class="section-title reveal mt-4 max-w-2xl" data-reveal>Un accompagnement complet, construit autour de votre réalité.</h2>
                </div>
                <p class="reveal max-w-xl text-base leading-7 text-slate-600 lg:col-span-5 lg:justify-self-end" data-reveal>
                    Un interlocuteur attentif, des expertises coordonnées et des recommandations directement utiles à votre organisation.
                </p>
            </div>

            <div class="mt-10 grid overflow-hidden border border-slate-200 bg-slate-200 sm:mt-14 md:grid-cols-2 lg:grid-cols-3" data-stagger>
                @forelse($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="group reveal relative min-h-64 overflow-hidden bg-white p-6 transition-colors duration-300 hover:bg-surface sm:p-8" data-reveal>
                        <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-coral transition-transform duration-300 group-hover:scale-x-100"></span>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold tracking-[.18em] text-coral">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="service-link-arrow flex size-9 items-center justify-center rounded-full border border-slate-200 text-charcoal transition-all group-hover:border-coral group-hover:bg-coral group-hover:text-white" aria-hidden="true">↗</span>
                        </div>
                        <h3 class="mt-12 font-heading text-xl font-bold text-charcoal sm:text-2xl">{{ $service->title }}</h3>
                        <p class="mt-4 max-w-xs text-sm leading-7 text-slate-500">{{ $service->short_description }}</p>
                    </a>
                @empty
                    <p class="col-span-full bg-white px-6 py-12 text-center text-slate-500">Nos services seront bientôt disponibles.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Method. --}}
    <section class="section-space bg-white">
        <div class="container-site">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-4">
                    <p class="eyebrow reveal" data-reveal>Notre méthode</p>
                    <h2 class="section-title reveal mt-4" data-reveal>Simple dans la forme. Rigoureuse dans le fond.</h2>
                    <p class="reveal mt-6 max-w-md leading-7 text-slate-600" data-reveal>
                        Une méthode lisible pour avancer sans zones d’ombre, de la première analyse au suivi de vos décisions.
                    </p>
                </div>

                <div class="lg:col-span-8">
                    <div class="border-t border-slate-200" data-stagger>
                        @foreach([
                            ['01', 'Comprendre', 'Votre activité, vos priorités et les contraintes propres à votre organisation.'],
                            ['02', 'Structurer', 'Les informations et les obligations pour construire une gestion plus claire.'],
                            ['03', 'Accompagner', 'Vos décisions dans la durée avec disponibilité, précision et pragmatisme.'],
                        ] as [$number, $title, $description])
                            <div class="reveal grid gap-4 border-b border-slate-200 py-7 sm:grid-cols-[70px_180px_1fr] sm:items-start sm:py-8" data-reveal>
                                <span class="text-xs font-bold tracking-[.18em] text-coral">{{ $number }}</span>
                                <h3 class="font-heading text-xl font-bold text-charcoal">{{ $title }}</h3>
                                <p class="max-w-lg text-sm leading-7 text-slate-500">{{ $description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="overflow-hidden bg-charcoal py-16 text-white sm:py-20 lg:py-24">
        <div class="container-site relative">
            <div class="absolute -right-20 -top-40 size-80 rounded-full border border-white/10" aria-hidden="true"></div>
            <div class="relative grid gap-10 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-8">
                    <p class="eyebrow">MCCG Marrakech</p>
                    <h2 class="mt-5 max-w-4xl font-heading text-3xl font-bold leading-[1.08] tracking-[-.035em] text-white sm:text-4xl lg:text-5xl">
                        Parlons de votre entreprise et de la prochaine étape.
                    </h2>
                    <p class="mt-6 max-w-2xl leading-7 text-white/55">
                        Notre équipe est à votre écoute pour comprendre vos besoins et construire un accompagnement adapté.
                    </p>
                </div>
                <div class="lg:col-span-4 lg:flex lg:justify-end">
                    <a href="{{ route('contact') }}" class="btn-primary w-full sm:w-auto">
                        Prendre contact <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-space bg-surface">
        <div class="container-site">
            <div class="grid gap-8 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <p class="eyebrow reveal" data-reveal>Notre bureau à Marrakech</p>
                    <h2 class="section-title reveal mt-4 max-w-2xl" data-reveal>Venez rencontrer notre équipe à Guéliz.</h2>
                </div>
                <div class="reveal lg:col-span-5 lg:text-right" data-reveal>
                    <p class="text-sm leading-7 text-slate-600">
                        92 Boulevard Zerktouni, 2ème et 3ème étage,<br class="hidden sm:block"> appartements 6, 12 et 13 · Marrakech 40000
                    </p>
                    <a
                        href="https://maps.app.goo.gl/4qsnuBBguZCT8tuBA"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group mt-4 inline-flex items-center gap-3 text-sm font-semibold text-charcoal hover:text-coral"
                    >
                        Ouvrir dans Google Maps <span class="service-link-arrow" aria-hidden="true">↗</span>
                    </a>
                </div>
            </div>

            <div class="reveal mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/[.06] sm:mt-12" data-reveal>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3396.875080792107!2d-8.0116213!3d31.6372705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8fa302e4d5%3A0xa7ccec9b89163022!2sMCCG!5e0!3m2!1sen!2sma!4v1790637470437!5m2!1sen!2sma"
                    title="Localisation du bureau MCCG à Marrakech"
                    class="block w-full border-0"
                    style="height: min(520px, 70vh); min-height: 420px;"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>
</div>
@endsection
