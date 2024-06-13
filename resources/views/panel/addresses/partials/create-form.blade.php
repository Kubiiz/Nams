<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <form method="post" action="{{ route('panel.addresses.store') }}" class="p-3 max-w-xl space-y-6 overflow-hidden shadow-sm sm:rounded-lg">
        @csrf

        <h1 class="text-lg">{{ __('Create new address') }}</h1>
        <div>
            <x-alert :type="'info'">
                {!! __('Count of addresses created by your company/companies:') !!}
                <div class="my-2">
                    @foreach ($companies as $company)
                        @php
                            $color = $company->addresses->count() < $company->count ? 'green' : 'red';

                            if($company->count - $company->addresses->count() > 0) {
                                $count[] = 1;
                            }
                        @endphp

                        <div>{{ $company->name }} - <span class="text-{{ $color }}-500">{{ $company->addresses->count() }}</span>/{{ $company->count }}</div>
                    @endforeach
                </div>
                @if (count($count) == 0)
                    {!! __('If you want to create more, please contact administrator!') !!}
                @endif
            </x-alert>
            @if (count($count) > 0)
            <x-input-label for="company" :value="__('Company Name')" />
            <x-select-input id="company" name="company" class="mt-1 block w-full">
                <x-select-option :selected="'selected'" disabled>{{ __('Choose company') }}</x-select-option>

                @foreach ($companies as $company)
                    @if ($company->addresses->count() < $company->count)
                        @php
                            $selected = old('company') == $company->id ? 'selected' : '';
                        @endphp

                        <x-select-option value="{{ $company->id }}" :selected="$selected">{{ $company->name }}</x-select-option>
                    @endif
                @endforeach

            </x-select-input>
            <x-input-error class="mt-2" :messages="$errors->get('company')" />
        </div>
        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>
        <div class="flex items-center gap-4">
            <x-button :type="'success'">
                <i class="fa fa-plus text-base mr-1"></i> {{ __('Create') }}
            </x-button>
        </div>
        @if (session('status') === 'address-created')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('Address created') }}</p>
        @endif
        @endif
    </form>
</div>
