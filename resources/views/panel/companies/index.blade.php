@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back', __('Companies Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
                <div class="flex justify-between p-3">
                    <div>
                        @if($perm)
                        <x-button :type="'success'" :url="route('panel.companies.create')">
                            <i class="fa fa-plus text-sm mr-1"></i><span class="mt-px">{{ __('Create new') }}</span>
                        </x-button>
                        @endif
                    </div>
                    <form method="GET" action="{{ route('panel.companies.search') }}" class="flex">
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
                            <x-button :type="'danger'" :url="route('panel.companies.index')">
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
                                <td class="p-2 flex items-center">@sortablelink('id', __('ID'))</td>
                                <td class="p-2">@sortablelink('name', __('Company Name')) </td>
                                <td class="p-2">@sortablelink('owner', __('Owner Email')) </td>
                                <td class="p-2">@sortablelink('email', __('Email')) </td>
                                <td class="p-2">@sortablelink('address', __('Address')) </td>
                                @if ($perm)
                                <td class="p-2">@sortablelink('active', __('Status')) </td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($result as $company)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 italic">#{{ $company->id }}</td>
                        <td class="p-2">{{ $company->name }}</td>
                        <td class="p-2">{{ $company->owner }}</td>
                        <td class="p-2">{{ $company->email }}</td>
                        <td class="p-2">{{ $company->address }}</td>
                        @if ($perm)
                        <td class="p-2">
                            @if ($company->active == 1)
                                <x-label :type="'success'">
                                    {{ __('Active') }}
                                </x-label>
                            @else
                                <x-label :type="'warning'">
                                    {{ __('Deactivated') }}
                                </x-label>
                            @endif
                        </td>
                        @endif
                        <td class="p-2 float-end">
                            <a href="{{ route('panel.companies.edit', $company->id) }}">
                                <x-label :type="'info'">
                                    <i class="fa fa-pencil mr-0.5"></i> {{ __('Edit') }}
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
    </div>
</x-app-layout>
