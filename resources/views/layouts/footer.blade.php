<footer class="bg-white w-screen shadow">
    <div class="max-w-7xl mx-auto h-16 px-2 lg:px-8 flex items-center justify-between text-gray-600 text-sm">
        <div class="flex items-center">
            <x-application-logo class="w-12 fill-current" />
            <div class=" flex flex-col sm:flex-row mr-3">
                <div class="ml-2">{{ __('All rights reserved.') }}</div>
                <div class="ml-2">&copy; <span class="text-blue-500 font-bold">{{ config('app.name') }}</span> {{ date('Y') }}</div>
            </div>
        </div>
        <div class="flex items-center flex-col sm:flex-row mr-1">
            <div class="sm:mr-3">{{ __('Website developed by') }}</div>
            <a target="new" href="https://etr.lv/portfolio">
                <img src="{{ url('assets/images/kubiiz.png') }}" alt="" class="sm:w-14 w-12 fill-current">
            </a>
        </div>
    </div>
</footer>
