<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <div class="p-3 space-y-6 overflow-hidden">
        <h1 class="text-lg mt-4">{{ __('Settings') }}</h1>
        <form method="post" action="{{ route('panel.addresses.settings', $result->id) }}" class="space-y-3">
            @csrf
            @method('patch')

            <h2>{{ __('Counter readings') }}</h2>
            <div>
                <x-input-label for="counter" :value="__('Counter reading options')" />
                <x-select-input id="counter" name="counter" class="mt-1 block w-full">
                    <x-select-option :selected="'selected'" disabled>{{ __('Choose option') }}</x-select-option>
                    <x-select-option value="number" :selected="old('counter', $settings['counter']) == 'number' ? 'selected' : ''">{{ __('Only counter numbers') }}</x-select-option>
                    <x-select-option value="number_photo" :selected="old('counter', $settings['counter']) == 'number_photo' ? 'selected' : ''">{{ __('Counter numbers with photo') }}</x-select-option>
                    <x-select-option value="random" :selected="old('counter', $settings['counter']) == 'random' ? 'selected' : ''">{{ __('Counter numbers with/without photo (randomly for each apartment every month)') }}</x-select-option>
                    <x-select-option value="without" :selected="old('counter', $settings['counter']) == 'without' ? 'selected' : ''">{{ __('Without counter reading') }}</x-select-option>
                </x-select-input>
                <x-input-error class="mt-2" :messages="$errors->get('counter')" />
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <x-input-label for="counter_from" :value="__('Counter reading from')" />
                    <x-text-input id="invoice_from" name="counter_from" type="number" placeholder="27" class="mt-1 block w-full" :value="old('counter_from', $settings['counter_from'])" />
                    <x-input-error class="mt-2" :messages="$errors->get('counter_from')" />
                </div>
                <div>
                    <x-input-label for="counter_to" :value="__('Counter reading to')" />
                    <x-text-input id="counter_to" name="counter_to" type="number" placeholder="07" class="mt-1 block w-full" :value="old('counter_to', $settings['counter_to'])" />
                    <x-input-error class="mt-2" :messages="$errors->get('counter_to')" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <x-button :type="'primary'">
                    <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
                </x-button>
            </div>
            @if (session('status') === 'settings-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('Settings updated') }}</p>
        @endif
        </form>
    </div>
</div>
