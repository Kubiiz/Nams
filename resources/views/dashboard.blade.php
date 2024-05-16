@section('title', __('Dashboard'))

<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div  class="my-1">
                        <x-alert :type="'info'">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, culpa quae alias consequuntur quis repellendus.
                        </x-alert>
                        <x-alert :type="'success'">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, culpa quae alias consequuntur quis repellendus.
                        </x-alert>
                        <x-alert :type="'warning'">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, culpa quae alias consequuntur quis repellendus.
                        </x-alert>
                        <x-alert :type="'danger'">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, culpa quae alias consequuntur quis repellendus.
                        </x-alert>
                        <x-alert :type="'misx'">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, culpa quae alias consequuntur quis repellendus.
                        </x-alert>
                    </div>
                    <div class="my-1">
                        <x-button :type="'primary'">
                            Lorem ipsum
                        </x-button>
                        <x-button :type="'info'">
                            Lorem ipsum
                        </x-button>
                        <x-button :type="'success'">
                            Lorem ipsum
                        </x-button>
                        <x-button :type="'warning'">
                            Lorem ipsum
                        </x-button>
                        <x-button :type="'danger'">
                            Lorem ipsum
                        </x-button>
                        <x-button :type="'misx'">
                            Lorem ipsum
                        </x-button>
                    </div>
                    <div class="my-1">
                        <x-label :type="'info'">
                            Lorem ipsum
                        </x-label>
                        <x-label :type="'success'">
                            Lorem ipsum
                        </x-label>
                        <x-label :type="'warning'">
                            Lorem ipsum
                        </x-label>
                        <x-label :type="'danger'">
                            Lorem ipsum
                        </x-label>
                        <x-label :type="'misx'">
                            Lorem ipsum
                        </x-label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
