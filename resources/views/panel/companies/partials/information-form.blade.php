<form method="post" action="{{ route('panel.companies.update', $result->id) }}" class="p-3 space-y-6 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    @csrf
    @method('patch')

    <h1 class="text-lg">{{ __('Company Information') }}</h1>
    <div>
        <x-input-label for="name" :value="__('Company Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $result->name)" required />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>
    <div>
        <x-input-label for="owner" :value="__('Owner Email')" />
        @if ($admin)
            <x-text-input id="owner" name="owner" type="email" class="mt-1 block w-full" :value="old('owner', $result->owner)" required />
            <x-input-error class="mt-2" :messages="$errors->get('owner')" />
        @else
            <small>{{ $result->owner }}</small>
        @endif
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $result->email)" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>
    <div>
        <x-input-label for="address" :value="__('Address')" />
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $result->address)" required />
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
    </div>
    <div>
        <x-input-label for="reg_number" :value="__('Registration number')" />
        <x-text-input id="reg_number" name="reg_number" type="text" class="mt-1 block w-full" :value="old('reg_number', $result->reg_number)" required />
        <x-input-error class="mt-2" :messages="$errors->get('reg_number')" />
    </div>
    <div>
        <x-input-label for="bank_name" :value="__('Bank')" />
        <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="old('bank_name', $result->bank_name)" required />
        <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
    </div>
    <div>
        <x-input-label for="bank_number" :value="__('Bank number')" />
        <x-text-input id="bank_number" name="bank_number" type="text" class="mt-1 block w-full" :value="old('bank_number', $result->bank_number)" required />
        <x-input-error class="mt-2" :messages="$errors->get('bank_number')" />
    </div>
    @if ($admin)
    <div>
        <x-input-label for="count" :value="__('How many addresses can create')" />
        <x-text-input id="count" name="count" type="number" class="mt-1 block w-full" :value="old('count', $result->count)" required />
        <x-input-error class="mt-2" :messages="$errors->get('count')" />
    </div>
    @endif
    <div class="flex items-center gap-4">
        <x-button :type="'primary'">
            <i class="fa fa-check text-base mr-1"></i> {{ __('Update') }}
        </x-button>

        @if (session('status') === 'information-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600"
            >{{ __('Information updated') }}</p>
        @endif
    </div>
</form>
