<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <div class="p-3 space-y-6 overflow-hidden">
        <h1 class="text-lg mt-4">{{ __('Options') }}</h1>

        <div>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('Manage apartments') }}
            </x-button>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('Manage Invoices') }}
            </x-button>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('Manage Counters') }}
            </x-button>
        </div>
    </div>
</div>
