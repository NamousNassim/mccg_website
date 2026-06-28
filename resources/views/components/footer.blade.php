<footer class="border-t border-slate-200 bg-charcoal text-white/65">
    <div class="container-site grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-4" data-stagger>
        <div class="reveal lg:col-span-2" data-reveal>
            <div class="mb-5 h-14 w-[200px] overflow-hidden rounded bg-white"><img src="{{ asset('images/logo.png') }}" alt="MCCG" class="w-[210px] max-w-none -translate-x-1 -translate-y-[27px]" width="310" height="163" loading="lazy"></div>
            <p class="max-w-md leading-7">Cabinet d’expertise comptable, fiscale, sociale et juridique au service des entreprises et entrepreneurs au Maroc.</p>
        </div>
        <div class="reveal" data-reveal><h2 class="mb-5 text-xs font-bold uppercase tracking-[.18em] text-white">Liens rapides</h2><div class="flex flex-col gap-3 text-sm"><a class="hover:text-coral" href="{{ route('a-propos') }}">À propos</a><a class="hover:text-coral" href="{{ route('services.index') }}">Nos services</a><a class="hover:text-coral" href="{{ route('articles.index') }}">Nos articles</a><a class="hover:text-coral" href="{{ route('contact') }}">Nous contacter</a></div></div>
        <div class="reveal" data-reveal><h2 class="mb-5 text-xs font-bold uppercase tracking-[.18em] text-white">Contact</h2><div class="space-y-3 text-sm"><p>Maroc</p><p><a class="hover:text-coral" href="mailto:contact@mccg.ma">contact@mccg.ma</a></p><p><a class="hover:text-coral" href="tel:+212500000000">+212 5 00 00 00 00</a></p></div></div>
    </div>
    <div class="border-t border-white/10"><div class="container-site flex flex-col gap-3 py-6 text-xs sm:flex-row sm:items-center sm:justify-between"><p>© {{ date('Y') }} MCCG. Tous droits réservés.</p><div class="flex gap-5"><a class="hover:text-coral" href="{{ route('confidentialite') }}">Confidentialité</a><a class="hover:text-coral" href="{{ route('conditions') }}">Conditions</a></div></div></div>
</footer>
