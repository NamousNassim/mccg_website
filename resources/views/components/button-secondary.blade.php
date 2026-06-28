@props(['href' => null, 'type' => 'button'])
@if($href)
<a href="{{ $href }}" {{ $attributes->class('btn-secondary') }}>{{ $slot }}</a>
@else
<button type="{{ $type }}" {{ $attributes->class('btn-secondary') }}>{{ $slot }}</button>
@endif
