@props(['icon', 'access' => false])

@php
    if (!Auth::user()->hasPermission($access)) {
        return false;
    }

    $prefix = $icon ? "<i class='fa fa-$icon text-lg mr-2'></i>" : '';
@endphp

<a {{ $attributes->merge(['class' => 'bg-white hover:bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg text-gray-700 hover:text-gray-800']) }}>
    <div class="p-6 flex justify-between items-center">
        <span>{!! $prefix . $slot !!}</span>
        <i class="fa fa-chevron-right text-blue-500 text-2xl"></i>
    </div>
</a>
