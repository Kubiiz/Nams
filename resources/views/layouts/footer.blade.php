<footer class="bg-white w-screen shadow mt-12">
    <div class="max-w-7xl mx-auto h-16 px-2 lg:px-8 flex items-center justify-between text-gray-600 text-sm">
        <div class="flex items-center">
            <x-application-logo class="w-12 fill-current" />
            <div class=" flex flex-col sm:flex-row mr-1">
                <div class="ml-1">{{ __('All rights reserved.') }}</div>
                <div class="ml-1">&copy; <span class="text-indigo-700 font-bold">{{ config('app.name') }}</span> {{ date('Y') }}</div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="w-14 fill-current" />
        </a>
    </div>
</footer>
