@section('title', __('Control panel'))
@section('titleLink', route('panel.index'))
@section('back', __('Logs'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
                <form method="GET" action="{{ route('panel.logs.search') }}" class="flex float-right pt-3 pr-3">
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
                                <td class="p-2">@sortablelink('user_id', __('User'))</td>
                                <td class="p-2">@sortablelink('note', __('Note'))</td>
                                <td class="p-2">@sortablelink('ip_address', __('IP Address'))</td>
                                <td class="p-2">{{ __('Link') }}</td>
                                <td class="p-2">@sortablelink('result', __('Result'))</td>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($result as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 italic">#{{ $log->id }}</td>
                        <td class="p-2">{{ $log->user->name }} {{ $log->user->surname }}</td>
                        <td class="p-2">{{ $log->note }}</td>
                        <td class="p-2"> {{ $log->ip_address }}</td>
                        <td class="p-2">
                            <a target="new" href="{{ $log->link }}">
                                <x-label :type="'info'">
                                    <i class="fa fa-pencil mr-0.5"></i> {{ __('View') }}
                                </x-label>
                            </a>
                        </td>
                        <td class="p-2">
                            <a href="{{ $log->link }}">
                                @if ($log->result)
                                    <x-label :type="'success'">
                                        <i class="fa fa-pencil mr-0.5"></i> {{ __('Success') }}
                                    </x-label>
                                @else
                                    <x-label :type="'danger'">
                                        <i class="fa fa-pencil mr-0.5"></i> {{ __('Failed') }}
                                    </x-label>
                                @endif
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
