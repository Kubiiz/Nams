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
        $color = 'bg-green-600 hover:shadow-inner border-green-700 text-white';
        break;
    default:
        $color = 'bg-gray-400 hover:shadow-inner border-gray-400 text-white';
        break;
}
@endphp

<div class="{{ $color}} inline-flex items-center justify-center rounded-md border text-xs shadow-sm cursor-pointer py-0.5 px-1.5 text-shadow">
    {{ $slot }}
</div>
