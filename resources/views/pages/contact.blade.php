@extends('layouts.app')

@php
    $phone = config('mccg.phone');
    $email = config('mccg.email');
    $address = config('mccg.address');
    $otherOffices = config('mccg.other_offices', []);
    $officeLocations = config('mccg.office_locations', []);
    $iconClass = 'size-5 stroke-current';
@endphp

@section('content')
<x-page-hero eyebrow="Contact" title="Commençons par une conversation" text="Décrivez-nous votre besoin. Un membre de notre équipe vous répondra avec clarté, sans jargon inutile." />

<section class="section-space">
    <div class="container-site grid gap-10 lg:grid-cols-[.8fr_1.2fr] lg:items-start lg:gap-12">
        <div class="reveal" data-reveal>
            <p class="eyebrow">Nous joindre</p>
            <h2 class="section-title mt-4">À votre écoute</h2>
            <p class="mt-5 leading-8">Qu’il s’agisse d’une question ponctuelle, d’un projet de création ou d’un accompagnement dans la durée, nous prendrons le temps de comprendre votre contexte.</p>

            <div class="mt-8 grid gap-4 sm:mt-9 sm:grid-cols-2 lg:grid-cols-1">
                <a class="group flex gap-4 rounded-xl border border-slate-200 bg-white p-5 hover:border-coral/50" href="tel:{{ preg_replace('/\s+/', '', $phone) }}">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-coral/10 text-coral"><svg class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg></span>
                    <span><span class="block text-xs uppercase tracking-wider text-slate-400">Téléphone</span><span class="mt-1 block font-semibold text-charcoal group-hover:text-coral">{{ $phone }}</span></span>
                </a>
                <a class="group flex min-w-0 gap-4 rounded-xl border border-slate-200 bg-white p-5 hover:border-coral/50" href="mailto:{{ $email }}">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-coral/10 text-coral"><svg class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.69 5.52a2.25 2.25 0 0 1-2.12 0L2.25 6.75" /></svg></span>
                    <span class="min-w-0"><span class="block text-xs uppercase tracking-wider text-slate-400">E-mail</span><span class="mt-1 block break-all font-semibold text-charcoal group-hover:text-coral">{{ $email }}</span></span>
                </a>
                <div class="flex gap-4 rounded-xl border border-slate-200 bg-white p-5 sm:col-span-2 lg:col-span-1">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-coral/10 text-coral"><svg class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg></span>
                    <span><span class="block text-xs uppercase tracking-wider text-slate-400">Adresse</span><span class="mt-1 block font-semibold leading-6 text-charcoal">{{ $address }}</span></span>
                </div>
                <div class="flex gap-4 rounded-xl border border-slate-200 bg-white p-5">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-coral/10 text-coral"><svg class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-4.5h6V21" /></svg></span>
                    <span><span class="block text-xs uppercase tracking-wider text-slate-400">Autres bureaux</span><span class="mt-1 block font-semibold text-charcoal">{{ implode(', ', $otherOffices) }}</span></span>
                </div>
                <div class="flex gap-4 rounded-xl border border-slate-200 bg-white p-5">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-coral/10 text-coral"><svg class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></span>
                    <span><span class="block text-xs uppercase tracking-wider text-slate-400">Horaires</span><span class="mt-1 block font-semibold text-charcoal">{{ config('mccg.hours') }}</span></span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                <a class="btn-secondary !px-3 !py-3 sm:!px-4" href="{{ config('mccg.linkedin_url') }}" target="_blank" rel="noopener noreferrer" aria-label="MCCG sur LinkedIn"><svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.34V8.98h3.42v1.57h.05c.47-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.29ZM5.32 7.41a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13Zm1.78 13.04H3.54V8.98H7.1v11.47Z" /></svg>LinkedIn <span aria-hidden="true">↗</span></a>
                <a class="btn-secondary !px-3 !py-3 sm:!px-4" href="{{ config('mccg.instagram_url') }}" target="_blank" rel="noopener noreferrer" aria-label="MCCG sur Instagram"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" /><circle cx="12" cy="12" r="4" /><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" /></svg>Instagram <span aria-hidden="true">↗</span></a>
            </div>
        </div>

        <x-contact-form :services="$services" />
    </div>
</section>

<section class="bg-white py-14 sm:py-20 lg:py-24">
    <div class="container-site" data-office-carousel>
        <div class="mb-8 flex flex-col justify-between gap-6 sm:mb-9 md:flex-row md:items-end">
            <div>
                <p class="eyebrow">Implantations</p>
                <h2 class="section-title mt-4">Nos bureaux</h2>
                <p class="mt-5 max-w-2xl leading-8">Retrouvez notre bureau principal à Marrakech. MCCG accompagne également ses clients à Casablanca et Dubai.</p>
            </div>
            <div class="flex items-center gap-2 self-end md:self-auto" aria-label="Navigation entre les bureaux">
                <button class="grid size-11 place-items-center rounded-full border border-slate-200 bg-white text-charcoal hover:border-coral hover:text-coral disabled:cursor-not-allowed disabled:opacity-40" type="button" data-office-previous aria-label="Bureau précédent">←</button>
                <button class="grid size-11 place-items-center rounded-full border border-slate-200 bg-white text-charcoal hover:border-coral hover:text-coral disabled:cursor-not-allowed disabled:opacity-40" type="button" data-office-next aria-label="Bureau suivant">→</button>
            </div>
        </div>

        <div class="mb-5 grid grid-cols-3 gap-2 sm:flex sm:flex-wrap" role="tablist" aria-label="Choisir une ville">
            @foreach($officeLocations as $index => $office)
                <button class="min-h-11 rounded-full border px-2 py-2.5 text-xs font-semibold transition sm:px-5 sm:text-sm {{ $index === 0 ? 'border-coral bg-coral text-white' : 'border-slate-200 bg-white text-charcoal hover:border-coral hover:text-coral' }}" type="button" role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="office-panel-{{ $index }}" data-office-tab="{{ $index }}">{{ $office['city'] }}</button>
            @endforeach
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-surface shadow-sm">
            <div class="flex transition-transform duration-500 ease-out" data-office-track>
                @foreach($officeLocations as $index => $office)
                    <article class="grid min-w-full lg:grid-cols-[.7fr_1.3fr]" id="office-panel-{{ $index }}" role="tabpanel" aria-label="Bureau MCCG {{ $office['city'] }}" data-office-panel>
                        <div class="flex flex-col justify-center p-6 sm:p-10 lg:p-12">
                            <span class="grid size-12 place-items-center rounded-xl bg-coral/10 text-coral"><svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7.5-4.35 7.5-11.25a7.5 7.5 0 1 0-15 0C4.5 16.65 12 21 12 21Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg></span>
                            <p class="mt-6 text-xs font-semibold uppercase tracking-[.2em] text-coral">Bureau MCCG</p>
                            <h3 class="mt-2 font-heading text-3xl font-bold text-charcoal">{{ $office['city'] }}</h3>
                            <p class="mt-5 border-l-2 border-coral pl-4 font-semibold leading-7 text-charcoal">{{ $office['address'] }}</p>
                            <div class="mt-8">
                                @if($office['maps_url'])
                                    <a class="btn-primary w-full sm:w-auto" href="{{ $office['maps_url'] }}" target="_blank" rel="noopener noreferrer">Ouvrir dans Google Maps <span aria-hidden="true">↗</span></a>
                                @else
                                    <span class="btn-primary cursor-not-allowed opacity-60" aria-disabled="true">Ouvrir dans Google Maps</span>
                                @endif
                            </div>
                        </div>
                        <div class="min-h-72 bg-charcoal/5 sm:min-h-80 lg:min-h-[460px]">
                            @if($office['embed_url'])
                                <iframe class="h-full min-h-72 w-full sm:min-h-80 lg:min-h-[460px]" src="{{ $office['embed_url'] }}" title="Carte du bureau MCCG à {{ $office['city'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                            @else
                                <div class="grid h-full min-h-80 place-items-center p-8 text-center lg:min-h-[460px]"><div><span class="mx-auto grid size-16 place-items-center rounded-full bg-white text-coral shadow-sm">⌖</span><p class="mt-5 font-heading text-xl font-bold text-charcoal">MCCG {{ $office['city'] }}</p><p class="mt-3 text-slate-600">{{ $office['address'] }}</p></div></div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
        <p class="mt-4 text-center text-xs text-slate-400" aria-live="polite" data-office-status>1 / {{ count($officeLocations) }} · Marrakech</p>
    </div>
</section>
@endsection
