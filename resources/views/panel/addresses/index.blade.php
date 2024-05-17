@section('title', __('Control panel'))
@section('back', __('Adress Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid lg:grid-cols-[70%_30%] grid-flow-row gap-3 {{ !$perm ? 'bg-white' : '' }}">
                @include('panel.addresses.partials.list')

                @if($perm)
                    @include('panel.addresses.partials.create-form')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
