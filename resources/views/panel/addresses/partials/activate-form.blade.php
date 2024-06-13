<div class="p-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h1 class="text-lg py-4">{{ __('Restore address') }}</h1>

    <x-alert :type="'info'">
        {{ __("This address will be restored in our system. All apartments also will added to thi address.") }}
    </x-alert>

    <div class="pt-5">
        <x-button :type="'success'" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deactivation')">
            <i class="fa fa-check text-base mr-1"></i> {{ __('Restore') }}
        </x-button>

        @if (session('status') === 'address-status')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('Address deleted') }}</p>
        @endif
    </div>
</div>

<x-modal name="confirm-deactivation">
    <form method="post" action="{{ route('panel.addresses.status', $result->id) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to restore this address?") }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("This address will be restored in our system. All apartments also will added to thi address.") }}
        </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                <i class="fa fa-times text-base mr-1"></i> {{ __('Cancel') }}
            </x-secondary-button>
            <x-button :type="'success'" class="ml-1">
                <i class="fa fa-check text-base mr-1"></i> {{ __('Restore') }}
            </x-button>
        </div>
    </form>
</x-modal>
