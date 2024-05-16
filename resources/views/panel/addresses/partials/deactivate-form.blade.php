<div class="p-3 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h1 class="text-lg py-4">{{ __('Deactivate company') }}</h1>

    <x-alert :type="'warning'">
        {{ __("This company will be deactivated in our system. Companies owner will receive email about deactivation.") }}
    </x-alert>

    <div class="pt-5">
        <x-button :type="'danger'" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deactivation')">
            <i class="fa fa-times text-base mr-1"></i> {{ __('Deactivate') }}
        </x-button>

        @if (session('status') === 'company-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('Company deactivated.') }}</p>
        @endif
    </div>
</div>

<x-modal name="confirm-deactivation">
    <form method="post" action="{{ route('panel.companies.status', $result->id) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to deactivate this company?") }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("This company will be deactivated in our system. Companies owner will receive email about deactivation.") }}
        </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                <i class="fa fa-times text-base mr-1"></i> {{ __('Cancel') }}
            </x-secondary-button>
            <x-button :type="'danger'" class="ml-1">
                <i class="fa fa-times text-base mr-1"></i> {{ __('Deactivate') }}
            </x-button>
        </div>
    </form>
</x-modal>
