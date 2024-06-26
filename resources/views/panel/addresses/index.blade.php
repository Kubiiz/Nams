@section('title')
    {{ __('Control panel') }}
@endsection
@section('titleLink', route('panel.index'))
@section('back', __('Address Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid lg:grid-cols-[70%_30%] grid-flow-row gap-3' }}">
                @include('panel.addresses.partials.list')
                @include('panel.addresses.partials.create-form')
            </div>
        </div>
    </div>
</x-app-layout>
