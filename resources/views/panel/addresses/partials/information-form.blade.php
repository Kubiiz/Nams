<div class="p-3 space-y-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h1 class="text-lg mt-4">{{ __('Address Information') }}</h1>

    @if ($perm && !$result->trashed())
        <form method="post" action="{{ route('panel.addresses.update', $result->id) }}" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label>
                    {{ __('Company Name') }}

                    @if ($perm)
                        <a href="{{ route('panel.companies.edit', $result->company->id) }}">
                            <x-label :type="'warning'">
                                <i class="fa fa-pencil mr-1"></i> {{ __('Edit company') }}
                            </x-label>
                        </a>
                    @endif
                </x-input-label>
                <small>
                    {{ $result->company->name }}
                </small>
            </div>
            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $result->address)" required />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div class="flex items-center gap-4">
                <x-button :type="'primary'">
                    <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
                </x-button>

                @if (session('status') === 'address-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-green-600"
                    >{{ __('Address updated') }}</p>
                @endif
            </div>
        </form>
    @else
        <div>
            <x-input-label for="owner" :value="__('Company Name')" />
            <small>{{ $result->company->name }}</small>
        </div>
        <div>
            <x-input-label for="owner" :value="__('Address')" />
            <small>{{ $result->address }}</small>
        </div>
    @endif
</div>
