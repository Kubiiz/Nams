@props(['type'])

@php
switch ($type) {
    case 'info':
        $color = 'bg-blue-400 hover:shadow-inner border-blue-500 text-white';
        break;
    case 'warning':
        $color = 'bg-yellow-400 hover:shadow-inner border-yellow-500 text-white';
        break;
    case 'danger':
        $color = 'bg-red-400 hover:shadow-inner border-red-500 text-white';
        break;
    case 'success':
        $color = 'bg-green-400 hover:shadow-inner border-green-500 text-white';
        break;
    default:
        $color = 'bg-gray-400 hover:shadow-inner border-gray-400 text-white';
        break;
}
@endphp

<div class="{{ $color}} overflow-hidden rounded border text-xs shadow-sm py-0.5 px-1.5">
    {{ $slot }}
</div>
