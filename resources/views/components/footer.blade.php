@php
    $phone = config('mccg.phone');
    $email = config('mccg.email');
@endphp

<footer class="border-t border-slate-200 bg-charcoal text-white/65">
    <div class="container-site grid gap-10 py-12 sm:py-16 md:grid-cols-2 md:gap-12 lg:grid-cols-4" data-stagger>
        <div class="reveal lg:col-span-2" data-reveal>
            <div class="mb-5 h-14 w-[200px] overflow-hidden rounded bg-white"><img src="{{ asset('images/logo.png') }}" alt="MCCG" class="w-[210px] max-w-none -translate-x-1 -translate-y-[27px]" width="310" height="163" loading="lazy"></div>
            <p class="max-w-xl leading-7">MCCG accompagne les entreprises et entrepreneurs au Maroc et à l’international en comptabilité, fiscalité, audit, gestion sociale et conseil.</p>
            <div class="mt-5 flex flex-wrap gap-2 text-sm font-semibold sm:mt-6">
                <a class="inline-flex min-h-11 items-center rounded-md px-2 hover:bg-white/5 hover:text-coral" href="{{ config('mccg.linkedin_url') }}" target="_blank" rel="noopener noreferrer">LinkedIn <span aria-hidden="true">↗</span></a>
                <a class="inline-flex min-h-11 items-center rounded-md px-2 hover:bg-white/5 hover:text-coral" href="{{ config('mccg.instagram_url') }}" target="_blank" rel="noopener noreferrer">Instagram <span aria-hidden="true">↗</span></a>
            </div>
        </div>
        <div class="reveal" data-reveal><h2 class="mb-5 text-xs font-bold uppercase tracking-[.18em] text-white">Liens rapides</h2><div class="flex flex-col gap-3 text-sm"><a class="hover:text-coral" href="{{ route('a-propos') }}">À propos</a><a class="hover:text-coral" href="{{ route('services.index') }}">Nos services</a><a class="hover:text-coral" href="{{ route('articles.index') }}">Nos articles</a><a class="hover:text-coral" href="{{ route('contact') }}">Nous contacter</a></div></div>
        <div class="reveal" data-reveal>
            <h2 class="mb-5 text-xs font-bold uppercase tracking-[.18em] text-white">Contact</h2>
            <div class="space-y-3 text-sm leading-6">
                <p><a class="hover:text-coral" href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>
                <p class="break-words"><a class="break-all hover:text-coral" href="mailto:{{ $email }}">{{ $email }}</a></p>
                <p class="break-words">{{ config('mccg.address') }}</p>
                <p><span class="text-white">Autres bureaux :</span> {{ implode(', ', config('mccg.other_offices', [])) }}</p>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10"><div class="container-site flex flex-col gap-3 py-5 text-xs sm:flex-row sm:items-center sm:justify-between sm:py-6"><p>© {{ date('Y') }} MCCG. Tous droits réservés.</p><div class="flex flex-wrap gap-x-5 gap-y-2"><a class="inline-flex min-h-11 items-center hover:text-coral sm:min-h-0" href="{{ route('confidentialite') }}">Confidentialité</a><a class="inline-flex min-h-11 items-center hover:text-coral sm:min-h-0" href="{{ route('conditions') }}">Conditions</a></div></div></div>
</footer>
