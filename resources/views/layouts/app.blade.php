<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} - @yield('title')</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 flex flex-col min-h-screen">
            @include('layouts.navigation')

            <header class="mt-24 mb-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 text-xl text-gray-700">
                    @yield('title')
                </div>
            </header>
            <main class="flex-grow">
            @if(!isset(Auth::user()->email_verified_at))
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                    <div class="bg-red-100 overflow-hidden sm:rounded-lg border border-red-200">
                        <div class="px-6 py-4 text-red-500">
                            {!! __('To continue using the website, please confirm your e-mail <b>:email</b>! A confirmation link was sent to your email.', ['email' => Auth::user()->email]) !!}
                        </div>
                    </div>
                </div>
            @else
                {{ $slot }}
            @endif
            </main>

            @include('layouts.footer')
        </div>
    </body>
</html>
