@extends('layouts.app')
@section('content')
<x-page-hero eyebrow="Contact" title="Commençons par une conversation" text="Décrivez-nous votre besoin. Un membre de notre équipe vous répondra avec clarté, sans jargon inutile." />
<section class="section-space"><div class="container-site grid gap-12 lg:grid-cols-[.75fr_1.25fr]">
    <div><p class="eyebrow">Nous joindre</p><h2 class="section-title mt-4">À votre écoute</h2><p class="mt-5 leading-8">Qu’il s’agisse d’une question ponctuelle, d’un projet de création ou d’un accompagnement dans la durée, nous prendrons le temps de comprendre votre contexte.</p><div class="mt-9 space-y-6 text-sm"><div><span class="block text-xs uppercase tracking-wider text-slate-400">E-mail</span><a class="mt-1 block font-semibold text-navy" href="mailto:contact@mccg.ma">contact@mccg.ma</a></div><div><span class="block text-xs uppercase tracking-wider text-slate-400">Téléphone</span><a class="mt-1 block font-semibold text-navy" href="tel:+212500000000">+212 5 00 00 00 00</a></div><div><span class="block text-xs uppercase tracking-wider text-slate-400">Zone d’intervention</span><p class="mt-1 font-semibold text-navy">Partout au Maroc</p></div></div></div>
    <x-contact-form :services="$services" />
</div></section>
@endsection
