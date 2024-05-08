@props(['active'])

@php
$classes = ($active ?? false)
            ? 'mx-1 w-5 opacity-100 transition duration-150 ease-in-out'
            : 'w-5 hover:opacity-100 opacity-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes }}>
    <img class="{{ $classes }}" src="{{ url('assets/icons/flag-'.$slot.'.png') }}" alt="{{ $slot }}">
</a>
