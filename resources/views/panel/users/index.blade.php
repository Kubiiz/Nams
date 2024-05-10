@section('title', __('Control panel'))
@section('back', __('User Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg text-gray-900">
                <div class="p-3 relative overflow-x-auto">
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
                    @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 italic">#{{ $user->id }}</td>
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->surname }}</td>
                        <td class="p-2"> {{ $user->email }}</td>
                        <td class="p-2 float-end">
                            <a href="{{ route('panel.users.edit', $user->id) }}">
                                <x-label :type="'info'">
                                    <i class="fa fa-pencil"></i> {{ __('Edit') }}
                                </x-label>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $users->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>
