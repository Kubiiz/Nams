@props(['type', 'url' => null, 'onclick' => false])

@php
switch ($type) {
    case 'primary':
        $color = 'bg-sky-600 border-sky-700';
        break;
    case 'info':
        $color = 'bg-blue-400 border-blue-500';
        break;
    case 'warning':
        $color = 'bg-yellow-400 border-yellow-500';
        break;
    case 'danger':
        $color = 'bg-red-400 border-red-500';
        break;
    case 'success':
        $color = 'bg-green-600 border-green-700';
        break;
    default:
        $color = 'bg-gray-400 border-gray-400';
        break;
}

$onclick ? "onclick=\'return confirm($onclick) }}\")" : '';
$classes = $color . ' inline-flex items-center justify-center rounded-md border text-sm text-white hover:text-white shadow-sm text-shadow hover:opacity-90 px-3 h-8 transition ease-in-out duration-150';
@endphp

@if ($url)
    <a href="{{ $url }}" class="{{ $classes }}">{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['onclick' => $onclick, 'type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

