@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back')
    <a class="text-gray-700" href="{{ route('panel.users.index') }}">{{ __('User Management') }}</a>
@endsection

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid sm:grid-cols-2 grid-flow-row gap-3">
                @include('panel.users.partials.information-form')

                @include('panel.users.partials.permissions-form')

                @include('panel.users.partials.password-form')
            </div>
        </div>
    </div>
</x-app-layout>
