<form method="post" action="{{ route('panel.users.update', $user->id) }}" class="p-3 space-y-6 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    @csrf
    @method('patch')

    <h1 class="text-lg">{{ __('User Information') }}</h1>
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>
    <div>
        <x-input-label for="surname" :value="__('Surname')" />
        <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->surname)" required />
        <x-input-error class="mt-2" :messages="$errors->get('surname')" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user->hasVerifiedEmail())
            <p class="text-sm mt-2 text-green-800">
                {{ __('Email address is verified.') }}
            </p>
        @else
            <p class="text-sm mt-2 text-gray-500">
                {{ __('Email address is not verified.') }}
            </p>
            <div class="inline-flex">
                <x-input-checkbox id="verify" name="verify" :value="1" :checked="old('verify')" />
                <x-input-label for="verify" :value="__('Apstiprināt epastu')" />
                <x-input-error class="mt-2" :messages="$errors->get('verify')" />
            </div>
        @endif
    </div>

    <div>
        <x-input-label for="phone" :value="__('Phone number')" />
        <small>{{ __('Example') }} {!! __(': (+371) <b>23456789</b>') !!}</small>
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="+371" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div class="flex items-center gap-4">
        <x-button :type="'primary'">
            <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
        </x-button>

        @if (session('status') === 'information-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600"
            >{{ __('Information updated') }}</p>
        @endif
    </div>
</form>
