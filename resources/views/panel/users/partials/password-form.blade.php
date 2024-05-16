<div class="p-3 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h1 class="text-lg py-4">{{ __('User Password change') }}</h1>

    <x-alert :type="'info'">
        {{ __("The system will generate a random password that will be sent to the user's email.") }}
    </x-alert>

    <div class="pt-5">
        <x-button :type="'primary'" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-password-change')">
            <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
        </x-button>

        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('User password updated and send to email.') }}</p>
        @endif
    </div>
</div>

<x-modal name="confirm-password-change">
    <form method="post" action="{{ route('panel.users.password', $user->id) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to change user's password?") }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("The system will generate a random password that will be sent to the user's email.") }}
        </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                <i class="fa fa-times text-base mr-1"></i> {{ __('Cancel') }}
            </x-secondary-button>
            <x-button :type="'primary'" class="ml-1">
                <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
            </x-button>
        </div>
    </form>
</x-modal>
