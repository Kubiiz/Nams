<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-alert :type="'info'">
            {!! __('Parolei jābūt vismaz 8 simbolus garai un tai jāsatur vismaz viens:') !!}<br />
            {!! __('Lielais burts (A - Z)') !!}<br />
            {!! __('Mazais burts (a - z)') !!}<br />
            {!! __('Cipars (0 - 9)') !!}<br />
            {!! __('Simbols vai speciāla rakstzīme ($,#,& u.c.)') !!}
        </x-alert>

        <!-- Email Address -->
        <div class="mt-5">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button :type="'primary'">
                <i class="fa fa-refresh text-sm mr-1"></i> {{ __('Reset password') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
