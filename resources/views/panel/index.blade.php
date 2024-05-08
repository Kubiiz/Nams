@section('title', __('Control panel'))

<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 grid-flow-row gap-3">
            <x-panel-main-link :href="route('panel.users.index')" :icon="'users'" :access="'users'">
                {{ __('Users') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'address-card-o'" :access="'companies'">
                {{ __('Companies') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'home'" :access="'addresses'">
                {{ __('Addresses') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'building-o'" :access="'apartments'">
                {{ __('Apartments') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'file-o'" :access="'invoices'">
                {{ __('Invoices') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'bell-o'" :access="'notices'">
                {{ __('Notices') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'pie-chart'" :access="'polls'">
                {{ __('Polls') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'gear'" :access="'settings'">
                {{ __('Settings') }}
            </x-panel-main-link>
            <x-panel-main-link :href="route('dashboard')" :icon="'bar-chart'" :access="'statistics'">
                {{ __('Statistics') }}
            </x-panel-main-link>
        </div>
    </div>
</x-app-layout>
