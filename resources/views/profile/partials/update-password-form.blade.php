<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 mb-5">
            {{ __('Update Password') }}
        </h2>
        <x-alert :type="'info'">
            {!! __('Parolei jābūt vismaz 8 simbolus garai un tai jāsatur vismaz viens:') !!}<br />
            {!! __('Lielais burts (A - Z)') !!}<br />
            {!! __('Mazais burts (a - z)') !!}<br />
            {!! __('Cipars (0 - 9)') !!}<br />
            {!! __('Simbols vai speciāla rakstzīme ($,#,& u.c.)') !!}

        </x-alert>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button :type="'primary'">
                <i class="fa fa-check text-base mr-1"></i> {{ __('Save') }}
            </x-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
