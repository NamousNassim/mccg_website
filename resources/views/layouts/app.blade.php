@php
    $pageSeo = $seo ?? null;
    $title = $seoTitle ?? ($pageSeo?->meta_title ?? 'MCCG | Cabinet de conseil comptable et fiscal au Maroc');
    $description = $seoDescription ?? ($pageSeo?->meta_description ?? 'MCCG accompagne les entreprises au Maroc en tenue comptable, fiscalité, gestion sociale, conseil juridique et accompagnement administratif.');
    $ogImage = $seoImage ?? ($pageSeo?->og_image ? asset('storage/'.$pageSeo->og_image) : asset('images/logo.png'));
    $schemaContext = '@'.'context';
    $analyticsProvider = config('mccg.analytics_provider');
    $gaId = config('mccg.ga_id');
    $plausibleDomain = config('mccg.plausible_domain');
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
        $schemaContext => 'https://schema.org', '@type' => ['LocalBusiness', 'ProfessionalService'],
        'name' => 'MCCG', 'url' => url('/'), 'logo' => asset('images/logo.png'),
        'description' => 'MCCG est un cabinet de conseil comptable, fiscal, social et administratif basé à Marrakech, accompagnant les entreprises et entrepreneurs au Maroc.',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => config('mccg.street_address'),
            'addressLocality' => config('mccg.city'),
            'addressRegion' => config('mccg.region'),
            'addressCountry' => 'MA',
        ],
        'areaServed' => ['@type' => 'Country', 'name' => 'Maroc'],
        'email' => config('mccg.email'), 'telephone' => config('mccg.phone'),
        'sameAs' => array_values(array_filter([config('mccg.linkedin_url'), config('mccg.instagram_url')])),
        'priceRange' => '$$',
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @stack('structured-data')
    @if($analyticsProvider === 'google' && $gaId)
        <script data-mccg-google-bootstrap>
            (() => {
                const measurementId = @json($gaId);

                window.mccgLoadGoogleAnalytics = () => {
                    if (document.querySelector('script[data-mccg-google-analytics]')) return;

                    const tag = document.createElement('script');
                    tag.async = true;
                    tag.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(measurementId)}`;
                    tag.dataset.mccgGoogleAnalytics = 'true';
                    document.head.appendChild(tag);

                    window.dataLayer = window.dataLayer || [];
                    window.gtag = function () { window.dataLayer.push(arguments); };
                    window.gtag('js', new Date());
                    window.gtag('config', measurementId);
                };

                try {
                    if (window.localStorage.getItem('mccg_analytics_consent') === 'accepted') {
                        window.mccgLoadGoogleAnalytics();
                    }
                } catch (_) {
                    // Tracking remains disabled if browser storage is unavailable.
                }
            })();
        </script>
    @elseif($analyticsProvider === 'plausible' && $plausibleDomain)
        <script defer data-domain="{{ $plausibleDomain }}" src="https://plausible.io/js/script.js" data-mccg-plausible></script>
    @endif
</head>
<body class="bg-surface text-slate-700 antialiased">
    <x-navbar />

    <main>@yield('content')</main>

    <x-footer />

    @if($analyticsProvider === 'google' && $gaId)
        <x-cookie-notice />
    @endif
</body>
</html>
