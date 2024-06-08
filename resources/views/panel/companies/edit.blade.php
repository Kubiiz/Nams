@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back')
    <a class="text-gray-700" href="{{ route('panel.companies.index') }}">{{ __('Companies Management') }}</a>
@endsection

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid sm:grid-cols-2 grid-flow-row gap-3 {{ !$admin ? 'bg-white' : '' }}">
                @include('panel.companies.partials.information-form')

                @if($admin)
                    @if ($result->active == 1)
                        @include('panel.companies.partials.deactivate-form')
                    @else
                        @include('panel.companies.partials.activate-form')
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
