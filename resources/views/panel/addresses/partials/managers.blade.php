<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <div class="p-3 space-y-6 overflow-hidden">
        <h1 class="text-lg mt-4">{{ __('Managers') }}</h1>
        <x-alert :type="'info'">
            {{ __('You can add managers to help you manage this address. If you want to add new manager, it must register first in this website!') }}
        </x-alert>

        @if(count($managers) > 0)
            <table class="w-full text-sm whitespace-nowrap">
                <thead>
                    <tr class="font-bold border-b">
                        <td class="p-2">{{ __('Manager') }}</td>
                        <td class="p-2">{{ __('Email') }}</td>
                        <td class="p-2">&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
            @foreach ($managers as $manager)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">{{ $manager }}</td>
                <td class="p-2">{{ $manager }}</td>
                <td class="p-2 float-end">
                    <x-button :type="'warning'" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-delete_{{ $loop->index }}')">
                        <i class="fa fa-times mr-0.5"></i> {{ __('Remove') }}
                    </x-button>
                    <x-modal name="confirm-delete_{{ $loop->index }}">
                        <form method="post" action="{{ route('panel.addresses.manager.destroy', $result->id) }}" class="p-6">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="manager" value="{{ $manager }}">

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to remove ":manager" manager?', ['manager' => $manager]) }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('This manager will be removed from this address.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    <i class="fa fa-times text-base mr-1"></i> {{ __('Cancel') }}
                                </x-secondary-button>
                                <x-button :type="'danger'" class="ml-1">
                                    <i class="fa fa-times text-base mr-1"></i> {{ __('Delete') }}
                                </x-button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
            @endforeach
                </tbody>
            </table>
        @endif

        @if (session('status') === 'manager-error')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-red-600"
            >{{ __('Something went wrong..') }}</p>
        @elseif (session('status') === 'manager-removed')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 5000)"
                class="text-sm text-green-600"
            >{{ __('Manager removed') }}</p>
        @endif

        <form method="post" action="{{ route('panel.addresses.manager.create', $result->id) }}" class="space-y-3">
            @csrf

            <h2>{{ __('Add manager') }}</h2>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email')" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <div class="flex items-center gap-4">
                <x-button :type="'success'">
                    <i class="fa fa-plus text-base mr-1"></i> {{ __('Create') }}
                </x-button>
            </div>
            @if (session('status') === 'manager-added')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-green-600"
                >{{ __('Manager added') }}</p>
            @endif
        </form>
    </div>
</div>
