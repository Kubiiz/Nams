@props(['disabled' => false, 'selected' => false])

<option {{ $disabled ? 'disabled' : '' }} {{ $selected ? 'selected' : '' }} {!! $attributes->merge() !!}>{{ $slot }}</option>
