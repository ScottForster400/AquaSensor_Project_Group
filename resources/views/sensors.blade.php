<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sensors') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">

            <form action="{{route('sensors.search')}}" method="GET" class = "w-4/5">
                <x-search-bar-gps placeholder="Search for a Sensor..."></x-search-bar-gps>
            </form>

            <div class="flex justify-around w-4/5 pt-4">
                <div>
                    <x-modal-toggle data-modal-target="edit" data-modal-toggle="edit">Activate Sensor</x-modal-toggle>
                    <!-- Modal to activate Sensor -->
                    <x-modal id="edit" class="bg-gray-500 bg-opacity-75 h-full">
                        <x-modal-header data-modal-hide="edit">Activate Sensor</x-modal-header>
                        <x-modal-body>
                            <form>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <label for="sensor_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sensor Location</label>
                                        <input type="text" id="sensor_location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="River Derwent" required />
                                    </div>
                                    <div>
                                        <label for="body_of_water" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body of Water</label>
                                        <input type="text" id="body_of_water" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Loch Ness" required />
                                    </div>
                                    <div>
                                        <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Latitude</label>
                                        <input type="text" id="latitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="52.8738" required />
                                    </div>
                                    <div>
                                        <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Longitude</label>
                                        <input type="text" id="longitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1.3203" required />
                                    </div>
                                    <div class="mb-6">
                                        <label for="activation_key" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Activation Key</label>
                                        <input type="password" id="activation_key" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required />
                                    </div>
                                    <div class="flex items-start mb-6">
                                        <div class="flex items-center h-5">
                                        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required />
                                        </div>
                                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Open Source?</label>
                                    </div>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                </div>
                            </form>
                        </x-modal-body>
                    </x-modal>
                </div>



                <div>
                    <x-dropdown-button class="float-left !w-24 ">Sort</x-dropdown-button>
                    <div>
                        <x-dropdown-button-body>
                            <x-dropdown-button-li class="w-full">
                                <x-dropdown-button-a href="{{route('sensors.sort', ['sort_by'=>'alph_asc'] )}}">A to Z</x-dropdown-button-a>
                            </x-dropdown-button-li>
                            <x-dropdown-button-li class="w-full">
                                <x-dropdown-button-a href="{{route('sensors.sort', ['sort_by'=>'alph_des'])}}">Z to A</x-dropdown-button-a>
                            </x-dropdown-button-li>
                        </x-dropdown-button-body>
                    </div>
                </div>
            </div>

            <div id="card-data" class="w-4/5">
                @include('layouts.sensor-table')
            </div>





        </div>
    </div>
    @include("layouts.maps")
</x-app-layout>
