<div class="overflow-hidden">
<div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
    <div class="flex justify-end p-3">
        <form method="GET" action="{{ route('panel.addresses.search') }}" class="flex">
            @csrf
            <div class="mr-1">
                <x-text-input id="search" name="search" type="text" class="h-8 w-52" :value="old('search', $search)" placeholder="{{ __('Search') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('search')" />
            </div>
            <x-button :type="'success'">
                <i class="fa fa-search text-sm mr-1"></i><span class="mt-px">{{ __('Search') }}</span>
            </x-button>

            @if(strlen($search) != 0)
            <div class="ml-1">
                <x-button :type="'danger'" :url="route('panel.addresses.index')">
                    <i class="fa fa-times text-sm mr-1"></i><span class="mt-px">{{ __('Clear') }}</span>
                </x-button>
            </div>
            @endif
        </form>
    </div>
    <div class="w-full p-3 relative overflow-x-auto">
    @if(count($result) > 0)
        <table class="w-full text-sm whitespace-nowrap">
            <thead>
                <tr class="font-bold border-b">
                    <td class="p-2">{{ __('Company Name') }}</td>
                    <td class="p-2">@sortablelink('address', __('Address'))</td>
                    <td class="p-2">&nbsp;</td>
                </tr>
            </thead>
            <tbody>
        @foreach ($result as $address)
        <tr class="border-b hover:bg-gray-50">
            <td class="p-2">{{ $address->company->name }}</td>
            <td class="p-2">{{ $address->address }}</td>
            <td class="p-2 float-end">
                <a href="{{ route('panel.addresses.edit', $address->id) }}">
                    <x-label :type="'info'">
                        <i class="fa fa-eye mr-0.5"></i> {{ __('View') }}
                    </x-label>
                </a>
            </td>
        </tr>
        @endforeach
            </tbody>
        </table>
    @else
        <x-alert :type="'info'">
            {{ __('No record found.') }}
        </x-alert>
    @endif
    </div>
</div>
{!! $result->appends(Request::except('page'))->onEachSide(1)->render() !!}
</div>
