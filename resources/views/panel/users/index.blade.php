@section('title', __('Control panel'))
@section('back', __('User Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">
                <div class="p-3">
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="font-bold border-b">
                                <td class="py-1 px-2">{{ __('ID') }}</td>
                                <td class="py-1 px-2">{{ __('Name') }}</td>
                                <td class="py-1 px-2">{{ __('Surname') }}</td>
                                <td class="py-1 px-2">{{ __('Email') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="py-1 px-2 italic">#{{ $user->id }}</td>
                        <td class="py-1 px-2">{{ $user->name }}</td>
                        <td class="py-1 px-2">{{ $user->surname }}</td>
                        <td class="py-1 px-2"> {{ $user->email }}</td>
                        <td class="py-1 px-2 float-end">
                            <a href="{{ route('panel.users.edit', $user->id) }}">Edit</a>
                            <a href="">Delete</a>
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
