<div class="p-3 space-y-6 max-w-xl bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h1 class="text-lg py-4">{{ __('User Permissions') }}</h1>

    <div class="">
        @forelse ( $permissions as $permission )
            <x-alert type="info">
                {{ __('User is :perm', ['perm' => App\Models\Permission::list($permission->permission)]) }}
            </x-alert>
        @empty
            <x-alert type="info">
                {{ __('User has no special permissions.') }}}}
            </x-alert>
        @endforelse
    </div>
</div>
