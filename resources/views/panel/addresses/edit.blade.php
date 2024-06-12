@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back')
    <a class="text-gray-700" href="{{ route('panel.addresses.index') }}">{{ __('Address Management') }}</a>
@endsection

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid sm:grid-cols-2 grid-flow-row gap-3">
                @include('panel.addresses.partials.information-form')
                @include('panel.addresses.partials.options')

                @if($perm || Auth::user()->isAdmin())
                    @include('panel.addresses.partials.managers')
                    @include('panel.addresses.partials.delete-form')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
