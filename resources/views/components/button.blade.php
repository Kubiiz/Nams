@props(['type', 'url' => null])

@php
switch ($type) {
    case 'info':
        $color = 'bg-blue-400 hover:shadow-inner border-blue-500 text-white hover:text-white';
        break;
    case 'warning':
        $color = 'bg-yellow-400 hover:shadow-inner border-yellow-500 text-white hover:text-white';
        break;
    case 'danger':
        $color = 'bg-red-400 hover:shadow-inner border-red-500 text-white hover:text-white';
        break;
    case 'success':
        $color = 'bg-green-400 hover:shadow-inner border-green-500 text-white hover:text-white';
        break;
    default:
        $color = 'bg-gray-400 hover:shadow-inner border-gray-400 text-white hover:text-white';
        break;
}

$classes = $color . ' inline-flex items-center justify-center rounded-md border text-sm shadow-sm px-3 h-8';
@endphp

@if ($url)
    <a href="{{ $url }}" class="{{ $classes }}">{{ $slot }}</a>
@else
    <button type="submit" class="{{ $classes }}">
        {{ $slot }}
    </button>
@endif

