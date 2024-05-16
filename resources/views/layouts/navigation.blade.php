@php
    $panel = App\Models\Permission::panel() ?? false;
@endphp
<nav x-data="{ open: false }" class="bg-white fixed w-screen shadow z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <x-application-logo class="block w-14 fill-current" />
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 lg:-my-px lg:ms-10 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa fa-home text-blue-500 text-xl mr-1"></i> {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('invoices')" :active="request()->routeIs('invoices')">
                        <i class="fa fa-file-o text-blue-500 text-base mr-1"></i> {{ __('Invoices') }}
                    </x-nav-link>
                    <x-nav-link :href="route('counters')" :active="request()->routeIs('counters')">
                        <i class="fa fa-tint text-blue-500 text-xl mr-1"></i> {{ __('Counters') }}
                    </x-nav-link>
                    <x-nav-link :href="route('addresses')" :active="request()->routeIs('addresses')">
                        <i class="fa fa-building-o text-blue-500 text-base mr-1"></i> {{ __('Addresses') }}
                    </x-nav-link>
                    <x-nav-link :href="route('notices')" :active="request()->routeIs('notices')">
                        <i class="fa fa-bell-o text-blue-500 text-base mr-1"></i> {{ __('Notices') }}
                    </x-nav-link>
                    <x-nav-link :href="route('polls')" :active="request()->routeIs('polls')">
                        <i class="fa fa-pie-chart text-blue-500 text-base mr-1"></i> {{ __('Polls') }}
                    </x-nav-link>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="flex items-center">
                <div class="hidden lg:flex mr-5">
                    @include('layouts.language')
                </div>
                <div class="hidden lg:flex lg:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="max-w-36 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <i class="fa fa-user text-blue-500 text-base"></i>
                                <div class="mx-2">{{ Auth::user()->name }}</div>
                                <i class="fa fa-sort-down text-blue-500 text-base pb-1"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa fa-pencil text-blue-500 text-base mr-1"></i> {{ __('Edit profile') }}
                            </x-dropdown-link>
                            @if($panel)
                                <x-dropdown-link :href="route('panel.index')">
                                    <i class="fa fa-gear text-blue-500 text-base mr-1"></i> {{ __('Control panel') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    <i class="fa fa-sign-out text-blue-500 text-base mr-1"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <div class="flex">
                    @include('layouts.language')
                </div>
                <button @click="open = ! open" class="ml-10 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <i class="fa fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa fa-home text-blue-500 text-xl mr-1"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('invoices')" :active="request()->routeIs('invoices')">
                <i class="fa fa-file-o text-blue-500 text-base mr-1"></i> {{ __('Invoices') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('counters')" :active="request()->routeIs('counters')">
                <i class="fa fa-tint text-blue-500 text-xl mr-1"></i> {{ __('Counters') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('addresses')" :active="request()->routeIs('addresses')">
                <i class="fa fa-building-o text-blue-500 text-base mr-1"></i> {{ __('Addresses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('notices')" :active="request()->routeIs('notices')">
                <i class="fa fa-bell-o text-blue-500 text-base mr-1"></i> {{ __('Notices') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('polls')" :active="request()->routeIs('polls')">
                <i class="fa fa-pie-chart text-blue-500 text-base mr-1"></i> {{ __('Polls') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-3 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    <i class="fa fa-user text-blue-500 text-base mr-1"></i> {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fa fa-pencil text-blue-500 text-base mr-1"></i> {{ __('Edit profile') }}
                </x-responsive-nav-link>
                @if($panel)
                    <x-responsive-nav-link :href="route('panel.index')">
                        <i class="fa fa-gear text-blue-500 text-base mr-1"></i> {{ __('Control panel') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fa fa-sign-out text-blue-500 text-base mr-1"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
