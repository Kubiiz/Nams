@section('title', __('Control panel'))
@section('back', __('User Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
                <form method="GET" action="{{ route('panel.users.search') }}" class="flex float-right pt-3 pr-3">
                    @csrf
                    <div class="mr-1">
                        <x-text-input id="search" name="search" type="text" class="h-8 w-52" :value="old('search', $search)" placeholder="{{ __('Search') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('search')" />
                    </div>
                    <x-button :type="'success'">
                        <i class="fa fa-search text-sm mr-1"></i><span class="mt-px">{{ __('Search') }}</span>
                    </x-button>

                    @if($search)
                    <div class="ml-1">
                        <x-button :type="'danger'" :url="route('panel.users.index')">
                            <i class="fa fa-times text-sm mr-1"></i><span class="mt-px">{{ __('Clear') }}</span>
                        </x-button>
                    </div>
                    @endif
                </form>
                <div class="w-full p-3 relative overflow-x-auto">
                @if(count($result) > 0)
                    <table class="w-full text-sm whitespace-nowrap">
                        <thead>
                            <tr class="font-bold border-b">
                                <td class="p-2 flex items-center">@sortablelink('id', __('ID'))</td>
                                <td class="p-2">@sortablelink('name', __('Name')) </td>
                                <td class="p-2">@sortablelink('surname', __('Surname')) </td>
                                <td class="p-2">@sortablelink('email', __('Email'))</td>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($result as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 italic">#{{ $user->id }}</td>
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->surname }}</td>
                        <td class="p-2"> {{ $user->email }}</td>
                        <td class="p-2 float-end">
                            <a href="{{ route('panel.users.edit', $user->id) }}">
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
