@section('title', __('Control panel'))
@section('back', __('User Management'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="grid sm:grid-cols-2 grid-flow-row gap-3">
                @include('panel.users.partials.information-form')

                @if($user->id != Auth::user()->id && !$user->hasPermission('admin', $user->id))
                    @if(Auth::user()->hasPermission('users_perm'))
                        @include('panel.users.partials.permissions-form')
                    @endif

                    @include('panel.users.partials.password-form')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
