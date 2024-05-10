<form method="post" action="{{ route('panel.users.permissions', $user->id) }}" class="p-3 space-y-2 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    @csrf
    @method('patch')

    <h1 class="text-lg py-4">{{ __('User Permissions') }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        @foreach($permissions as $permision => $title)
            <div class="inline-flex">
                <x-input-checkbox id="panel" name="permission[{{ $permision }}]" :value="$permision" :checked="old('permission[{{ $permision }}]', $user->hasPermission($permision, $user->id))" />
                <x-input-label for="panel" :value="__($title)" />
            </div>
        @endforeach
    </div>
    <div class="flex items-center gap-4 pt-4">
        <x-primary-button>{{ __('Update') }}</x-primary-button>

        @if (session('status') === 'permissions-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600">
                {{ __('User permissions updated') }}
            </p>
        @endif
    </div>
</form>
