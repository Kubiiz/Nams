@props(['disabled' => false, 'checked' => false])

<input type="checkbox" {{ $disabled ? 'disabled' : '' }} {{ $checked ? 'checked' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 shadow-sm mr-2 mt-0.5']) !!}>
