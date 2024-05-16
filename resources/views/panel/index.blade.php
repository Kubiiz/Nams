@section('title', __('Control panel'))

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 grid-flow-row gap-3">
            @if (Auth::user()->hasPermission('Admin'))
                <x-panel-main-link :href="route('panel.users.index')" :icon="'users'">
                    {{ __('Users') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'bar-chart'">
                    {{ __('Statistics') }}
                </x-panel-main-link>
            @endif

            @if (Auth::user()->hasPermission('Manager') || Auth::user()->hasPermission('Owner'))
                @if (Auth::user()->hasPermission('Owner'))
                    <x-panel-main-link :href="route('panel.companies.index')" :icon="'address-card-o'">
                        {{ __('Companies') }}
                    </x-panel-main-link>
                @endif

                <x-panel-main-link :href="route('dashboard')" :icon="'home'">
                    {{ __('Addresses') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'building-o'">
                    {{ __('Apartments') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'tint'">
                    {{ __('Counters') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'file-o'">
                    {{ __('Invoices') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'bell-o'">
                    {{ __('Notices') }}
                </x-panel-main-link>
                <x-panel-main-link :href="route('dashboard')" :icon="'pie-chart'">
                    {{ __('Polls') }}
                </x-panel-main-link>
            @endif
        </div>
    </div>
</x-app-layout>
