@section('title', __('Control panel'))
@section('back', __('Address Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid sm:grid-cols-2 grid-flow-row gap-3">
                @include('panel.addresses.partials.information-form')

                @if($perm)
                    @include('panel.addresses.partials.delete-form')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
