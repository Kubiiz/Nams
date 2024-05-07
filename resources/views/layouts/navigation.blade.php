<nav x-data="{ open: false }" class="bg-white fixed w-screen shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <x-application-logo class="block w-14 fill-current" />
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ms-10 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(Auth::user()->hasPermission('bills'))
                        <x-nav-link :href="route('bills')" :active="request()->routeIs('bills')">
                            {{ __('Bills') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->hasPermission('counters'))
                        <x-nav-link :href="route('counters')" :active="request()->routeIs('counters')">
                            {{ __('Counters') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->hasPermission('addresses'))
                        <x-nav-link :href="route('addresses')" :active="request()->routeIs('addresses')">
                            {{ __('Addresses') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->hasPermission('notices'))
                        <x-nav-link :href="route('notices')" :active="request()->routeIs('notices')">
                            {{ __('Notices') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->hasPermission('polls'))
                        <x-nav-link :href="route('polls')" :active="request()->routeIs('polls')">
                            {{ __('Polls') }}
                        </x-nav-link>
                    @endif
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
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Edit profile') }}
                            </x-dropdown-link>
                            @if(Auth::user()->hasPermission('panel'))
                                <x-dropdown-link :href="route('panel.index')">
                                    {{ __('Control panel') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
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
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->hasPermission('bills'))
                <x-responsive-nav-link :href="route('bills')" :active="request()->routeIs('bills')">
                    {{ __('Bills') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->hasPermission('counters'))
                <x-responsive-nav-link :href="route('counters')" :active="request()->routeIs('counters')">
                    {{ __('Counters') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->hasPermission('addresses'))
                <x-responsive-nav-link :href="route('addresses')" :active="request()->routeIs('addresses')">
                    {{ __('Addresses') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->hasPermission('notices'))
                <x-responsive-nav-link :href="route('notices')" :active="request()->routeIs('notices')">
                    {{ __('Notices') }}
                </x-responsive-nav-link>
            @endif
            @if(Auth::user()->hasPermission('polls'))
                <x-responsive-nav-link :href="route('polls')" :active="request()->routeIs('polls')">
                    {{ __('Polls') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-3 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Edit profile') }}
                </x-responsive-nav-link>
                @if(Auth::user()->hasPermission('panel'))
                    <x-responsive-nav-link :href="route('panel.index')">
                         {{ __('Control panel') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
