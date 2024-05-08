<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ url('icons/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} - @yield('title')</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ url('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 flex flex-col min-h-screen">
            @include('layouts.navigation')

            <header class="mt-24 mb-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 text-lg text-gray-700 flex justify-between">
                    <div class="w-3/5">
                        @yield('title')
                        @hasSection('back')
                        <i class="fa fa-chevron-right text-blue-500 text-base mx-2"></i><span class="text-base">@yield('back')</span>
                        @endif
                    </div>
                    @hasSection('back')
                    <a href="{{ url()->previous() }}" class="h-7 px-3 pt-1.5 bg-white border border-gray-200 rounded-md text-sm/[13px] text-gray-500 shadow-sm hover:bg-slate-50 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fa fa-history text-blue-500"></i> {{ __('Back') }}
                    </a>
                    @endif
                </div>
            </header>
            <main class="flex-grow pb-12">
                @include('layouts.verification')

                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>
    </body>
</html>
