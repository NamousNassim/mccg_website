@extends('layouts.app')
@section('content')
<section class="overflow-hidden bg-white">
    <div class="container-site grid min-h-[650px] items-center gap-14 py-16 lg:grid-cols-[1.02fr_.98fr] lg:py-20">
        <div class="relative z-10">
            <p class="eyebrow">Cabinet d’expertise comptable & conseil au Maroc</p>
            <h1 class="hero-title mt-6 max-w-3xl font-heading text-4xl font-bold leading-[1.12] tracking-tight text-charcoal sm:text-5xl lg:text-[3.6rem]">Votre partenaire de confiance pour une <span class="highlight-underline text-coral">performance durable</span></h1>
            <p class="hero-subtitle mt-7 max-w-2xl text-lg leading-8 text-slate-600">Expertise comptable, conseil fiscal, social et stratégique au service des entreprises et des entrepreneurs au Maroc.</p>
            <div class="hero-actions mt-9 flex flex-col gap-3 sm:flex-row"><x-button-primary :href="route('services.index')">Découvrir nos services</x-button-primary><x-button-secondary :href="route('contact')">Nous contacter</x-button-secondary></div>
            <div class="mt-10 flex flex-wrap gap-x-8 gap-y-3 border-t border-slate-200 pt-6 text-sm text-slate-500">
                <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Conseil personnalisé</span>
                <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Expertise pluridisciplinaire</span>
                <span class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-coral"></span>Accompagnement durable</span>
            </div>
        </div>
        <div class="hero-visual relative">
            <div class="absolute -left-5 -top-5 size-24 rounded-xl border border-coral/20"></div>
            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-surface shadow-xl shadow-slate-900/[.08]">
                <img src="{{ asset('images/hero-mccg.png') }}" alt="Conseil financier et expertise comptable MCCG" class="hero-parallax aspect-[4/3] h-full w-full object-cover" width="1536" height="1024" fetchpriority="high" data-parallax>
            </div>
            <div class="absolute -bottom-6 left-6 rounded-xl border border-slate-200 bg-white p-5 shadow-lg sm:left-10">
                <p class="font-heading text-sm font-bold text-charcoal">Une vision claire de vos enjeux</p>
                <p class="mt-1 text-xs text-slate-500">Comptables • Fiscaux • Sociaux • Juridiques</p>
            </div>
        </div>
    </div>
</section>

<section class="border-y border-slate-200 bg-white"><div class="container-site grid divide-y divide-slate-200 py-2 sm:grid-cols-3 sm:divide-x sm:divide-y-0" data-stagger><div class="reveal px-8 py-8 text-center" data-reveal><strong class="block font-heading text-3xl font-bold text-charcoal" data-counter="6">6</strong><span class="mt-1 block text-sm text-slate-500">Domaines d’expertise</span></div><div class="reveal px-8 py-8 text-center" data-reveal><strong class="block font-heading text-3xl font-bold text-charcoal" data-counter="4">4</strong><span class="mt-1 block text-sm text-slate-500">Engagements fondamentaux</span></div><div class="reveal px-8 py-8 text-center" data-reveal><strong class="block font-heading text-3xl font-bold text-charcoal" data-counter="360" data-suffix="°">360°</strong><span class="mt-1 block text-sm text-slate-500">Vision de votre entreprise</span></div></div></section>

<section class="section-space bg-surface"><div class="container-site"><x-section-title eyebrow="Nos expertises" title="Des solutions concrètes pour chaque étape de votre entreprise" text="Une approche pluridisciplinaire qui rassemble expertise comptable, fiscalité, audit, droit et conseil sous un même accompagnement." align="center" /><div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3" data-stagger>@forelse($services as $service)<x-service-card :service="$service" />@empty<p class="col-span-full text-center">Aucun service publié pour le moment.</p>@endforelse</div><div class="mt-10 text-center"><x-button-secondary :href="route('services.index')">Voir tous nos services</x-button-secondary></div></div></section>

<section class="section-space bg-white"><div class="container-site grid gap-14 lg:grid-cols-2 lg:items-center"><div class="relative"><div class="rounded-2xl bg-surface p-8 sm:p-10"><p class="eyebrow">À propos de MCCG</p><h2 class="section-title mt-4">L’expertise technique, avec une vraie proximité</h2><p class="mt-6 leading-8 text-slate-600">MCCG accompagne les entreprises, entrepreneurs et investisseurs avec une lecture claire de leurs obligations et de leurs leviers de développement. Notre rôle va au-delà de la conformité : nous vous aidons à décider avec confiance.</p><p class="mt-5 leading-8 text-slate-600">Notre connaissance du contexte marocain et notre approche pluridisciplinaire permettent de construire des réponses cohérentes, pragmatiques et durables.</p><x-button-primary :href="route('a-propos')" class="mt-8">Découvrir le cabinet</x-button-primary></div></div><div class="grid gap-5 sm:grid-cols-2">@foreach([['Expertise','Des compétences rigoureuses et continuellement actualisées.'],['Rigueur','Des méthodes fiables et une attention constante aux détails.'],['Proximité','Un interlocuteur disponible qui comprend votre activité.'],['Engagement','Des recommandations suivies dans la durée.']] as [$title,$text])<div class="rounded-xl border border-slate-200 bg-white p-7"><span class="mb-5 block h-1 w-10 rounded bg-coral"></span><h3 class="font-heading text-lg font-bold text-charcoal">{{ $title }}</h3><p class="mt-3 text-sm leading-6 text-slate-600">{{ $text }}</p></div>@endforeach</div></div></section>

<section class="section-space border-y border-slate-200 bg-surface"><div class="container-site"><x-section-title eyebrow="Pourquoi MCCG" title="Un partenaire structuré autour de votre performance" text="Notre manière de travailler privilégie la clarté, la responsabilité et l’utilité concrète de chaque recommandation." align="center" /><div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4" data-stagger><x-feature-card title="Expertise" text="Une équipe pluridisciplinaire au fait des exigences marocaines." /><x-feature-card title="Confiance" text="Une relation transparente et une information financière fiable." /><x-feature-card title="Accompagnement" text="Une présence attentive, de vos opérations courantes à vos projets." /><x-feature-card title="Performance" text="Des analyses qui transforment vos chiffres en décisions utiles." /></div></div></section>

@if($articles->isNotEmpty())<section class="section-space bg-white"><div class="container-site"><div class="flex flex-col justify-between gap-5 md:flex-row md:items-end"><x-section-title eyebrow="Nos publications" title="Éclairages & actualités" text="Des repères utiles pour mieux comprendre les enjeux comptables, fiscaux et réglementaires de votre entreprise." /><x-button-secondary :href="route('articles.index')">Tous les articles</x-button-secondary></div><div class="mt-12 grid gap-6 md:grid-cols-3" data-stagger>@foreach($articles as $article)<x-article-card :article="$article" />@endforeach</div></div></section>@endif

<x-cta />
@endsection
