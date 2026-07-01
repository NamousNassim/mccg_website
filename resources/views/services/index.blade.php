@extends('layouts.app')
@section('content')
<x-page-hero eyebrow="Nos services" title="Des expertises coordonnées pour avancer avec confiance" text="Comptabilité, fiscalité, audit, social et conseil : une équipe pluridisciplinaire, un accompagnement cohérent." />
<section class="section-space"><div class="container-site"><div class="grid gap-5 md:grid-cols-2 md:gap-6 lg:grid-cols-3" data-stagger>@forelse($services as $service)<x-service-card :service="$service" />@empty<p class="col-span-full text-center">Nos services seront bientôt disponibles.</p>@endforelse</div></div></section>
<section class="bg-white section-space"><div class="container-site grid gap-9 lg:grid-cols-2 lg:items-center lg:gap-12"><div><p class="eyebrow">Une méthode éprouvée</p><h2 class="section-title mt-4">Le bon niveau d’accompagnement, au bon moment</h2></div><div class="space-y-6">@foreach([['Diagnostic','Nous partons de vos enjeux, de vos outils et de votre organisation.'],['Feuille de route','Nous définissons les priorités, les responsabilités et les résultats attendus.'],['Suivi','Nous mesurons les avancées et adaptons l’accompagnement à votre évolution.']] as [$t,$d])<div class="border-l-2 border-gold pl-5 sm:pl-6"><h3 class="font-semibold text-navy">{{ $t }}</h3><p class="mt-1 leading-7">{{ $d }}</p></div>@endforeach</div></div></section>
<x-cta />
@endsection
