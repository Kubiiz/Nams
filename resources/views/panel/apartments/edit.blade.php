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

                @if(!$result->trashed())
                    @include('panel.addresses.partials.managers')
                    @include('panel.addresses.partials.settings')
                @endif

                @if ($isAdmin)
                    @if (!$result->trashed())
                        @include('panel.addresses.partials.deactivate-form')
                    @else
                        @include('panel.addresses.partials.activate-form')
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
