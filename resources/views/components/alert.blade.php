@props(['type'])

@php
if ($type == 'info') {
    $color = 'bg-blue-100 border-blue-200';
    $text = 'text-blue-600';
} elseif ($type == 'warning') {
    $color = 'bg-orange-100 border-orange-200';
    $text = 'text-orange-600';
} elseif ($type == 'danger') {
    $color = 'bg-red-100 border-red-200';
    $text = 'text-red-600';
} elseif ($type == 'success') {
    $color = 'bg-green-100 border-green-200';
    $text = 'text-green-600';
} else {
    $color = 'bg-gray-200 border-gray-200';
    $text = 'text-gray-500';
}
@endphp

<div class="{{ $color}} overflow-hidden sm:rounded-lg border">
    <div class="{{ $text }} px-6 py-4">
        {{ $slot }}
    </div>
</div>
