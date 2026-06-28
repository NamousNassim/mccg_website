@props(['href' => null, 'type' => 'button'])
@if($href)
<a href="{{ $href }}" {{ $attributes->class('btn-primary') }}>{{ $slot }} <span aria-hidden="true">→</span></a>
@else
<button type="{{ $type }}" {{ $attributes->class('btn-primary') }}>{{ $slot }} <span aria-hidden="true">→</span></button>
@endif
