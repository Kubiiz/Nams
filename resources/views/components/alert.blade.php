@props(['type'])

@php
switch ($type) {
    case 'info':
        $color = 'bg-blue-100 border-blue-200';
        $text = 'text-blue-500';
        break;
    case 'warning':
        $color = 'bg-orange-100 border-orange-200';
        $text = 'text-orange-500';
        break;
    case 'danger':
        $color = 'bg-red-100 border-red-200';
        $text = 'text-red-500';
        break;
    case 'success':
        $color = 'bg-green-100 border-green-200';
        $text = 'text-green-500';
        break;
    default:
        $color = 'bg-gray-100 border-gray-200';
        $text = 'text-gray-400';
        break;
}
@endphp

<div class="{{ $color}} w-full overflow-hidden rounded-lg border text-sm shadow-sm">
    <div class="{{ $text }} px-6 py-4">
        {{ $slot }}
    </div>
</div>
