@props(['eyebrow' => null, 'title', 'text' => null, 'align' => 'left'])
<div data-reveal @class(['reveal max-w-3xl', 'mx-auto text-center' => $align === 'center'])>
    @if($eyebrow)<p class="eyebrow">{{ $eyebrow }}</p>@endif
    <h2 class="section-title mt-4">{{ $title }}</h2>
    @if($text)<p class="mt-5 text-base leading-7 text-slate-600 sm:text-lg">{{ $text }}</p>@endif
    <span class="section-title-line" aria-hidden="true"></span>
</div>
