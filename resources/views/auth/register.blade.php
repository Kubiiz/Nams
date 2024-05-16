<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="flex flex-col sm:flex-row">
            <div class="sm:mr-1">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="sm:ml-1">
                <x-input-label for="surname" :value="__('Surname')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" />
                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone number')" />
            <small>{{ __('Example') }} {!! __(': (+371) <b>23456789</b>') !!}</small>
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="+371" autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" />
        </div>

        <div class="my-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <x-alert :type="'info'">
            {!! __('Parolei jābūt vismaz 8 simbolus garai un tai jāsatur vismaz viens:') !!}<br />
            {!! __('Lielais burts (A - Z)') !!}<br />
            {!! __('Mazais burts (a - z)') !!}<br />
            {!! __('Cipars (0 - 9)') !!}<br />
            {!! __('Simbols vai speciāla rakstzīme ($,#,& u.c.)') !!}
        </x-alert>
        <div class="flex flex-col sm:flex-row mt-4">
            <div class="sm:mr-1">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="sm:mr-1">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm mr-6" href="{{ route('login') }}">
                {{ __('Already registered') }}
            </a>

            <x-button :type="'primary'">
                <i class="fa fa-user-plus text-base mr-1"></i> {{ __('Register') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
