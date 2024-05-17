<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <div class="p-3 max-w-xl space-y-6 overflow-hidden">
        <h1 class="text-lg mt-4">{{ __('Options') }}</h1>

        <div>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('View apartments') }}
            </x-button>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('Send Invoices') }}
            </x-button>
            <x-button :type="'info'" :url="route('panel.addresses.edit', $result->id)">
                <i class="fa fa-eye mr-0.5"></i> {{ __('See Counters') }}
            </x-button>
        </div>
    </div>
</div>
