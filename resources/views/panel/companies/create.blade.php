@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back')
    <a class="text-gray-700" href="{{ route('panel.companies.index') }}">{{ __('Companies Management') }}</a>
@endsection

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white">
<form method="post" action="{{ route('panel.companies.store') }}" class="p-3 space-y-6 max-w-xl overflow-hidden shadow-sm sm:rounded-lg">
    @csrf

    <h1 class="text-lg">{{ __('Create new company') }}</h1>
    <div>
        <x-input-label for="name" :value="__('Company Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>
    <div>
        <x-input-label for="owner" :value="__('Owner Email')" />
        <small>{{ __('Company owner must be registered with this email.') }}</small>
        <x-text-input id="owner" name="owner" type="email" class="mt-1 block w-full" :value="old('owner')" required />
        <x-input-error class="mt-2" :messages="$errors->get('owner')" />
    </div>
    <div>
        <x-input-label for="count" :value="__('How many addresses can create')" />
        <x-text-input id="count" name="count" type="number" class="mt-1 block w-full" :value="old('count')" required />
        <x-input-error class="mt-2" :messages="$errors->get('count')" />
    </div>

    <div class="flex items-center gap-4">
        <x-button :type="'success'">
            <i class="fa fa-plus text-base mr-1"></i> {{ __('Create') }}
        </x-button>

        @if (session('status') === 'company-created')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600"
            >{{ __('Company created') }}</p>
        @endif
    </div>
</form>
</div>
</x-app-layout>
