@php
    $pageSeo = $seo ?? null;
    $title = $seoTitle ?? ($pageSeo?->meta_title ?? 'MCCG | Cabinet d’expertise comptable et conseil au Maroc');
    $description = $seoDescription ?? ($pageSeo?->meta_description ?? 'MCCG accompagne les entreprises au Maroc en expertise comptable, fiscalité, audit, gestion sociale, conseil juridique et accompagnement stratégique.');
    $ogImage = $seoImage ?? ($pageSeo?->og_image ? asset('storage/'.$pageSeo->og_image) : asset('images/logo.png'));
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    @isset($seoKeywords)<meta name="keywords" content="{{ $seoKeywords }}">@endisset
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:locale" content="fr_MA">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="MCCG">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#333333">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org', '@type' => ['LocalBusiness', 'AccountingService'],
        'name' => 'MCCG', 'url' => url('/'), 'logo' => asset('images/logo.png'),
        'description' => 'Cabinet marocain d’expertise comptable, fiscalité, audit, gestion sociale, conseil juridique et accompagnement stratégique.',
        'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'MA'],
        'areaServed' => ['@type' => 'Country', 'name' => 'Maroc'],
        'email' => 'contact@mccg.ma', 'telephone' => '+212 5 00 00 00 00',
        'priceRange' => '$$',
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @stack('structured-data')
</head>
<body class="bg-surface text-slate-700 antialiased">
    <x-navbar />

    <main>@yield('content')</main>

    <x-footer />
</body>
</html>
