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
                            <form method="post" action="{{ route('sensors.activate') }}" class="mt-6 space-y-6">
                                @csrf
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <x-input-label for="sensor_location" :value="__('Sensor Location')" />
                                        <x-text-input id="sensor_location" name="sensor_location" type="text" class="mt-1 block w-full" :value="old('sensor_location')" required autofocus autocomplete="sensor_location" />
                                        <x-input-error class="mt-2" :messages="$errors->get('sensor_location')" />
                                    </div>
                                    <div>
                                        <x-input-label for="body_of_water" :value="__('Body of Water')" />
                                        <x-text-input id="body_of_water" name="body_of_water" type="text" class="mt-1 block w-full" :value="old('body_of_water')" required autofocus autocomplete="body_of_water" />
                                        <x-input-error class="mt-2" :messages="$errors->get('body_of_water')" />
                                    </div>
                                    <div>
                                        <x-input-label for="latitude" :value="__('Latitude')" />
                                        <x-text-input id="latitude" name="latitude" type="number" class="mt-1 block w-full" :value="old('latitude')" required autofocus autocomplete="latitude" />
                                        <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                                    </div>
                                    <div>
                                        <x-input-label for="longitude" :value="__('Longitude')" />
                                        <x-text-input id="longitude" name="longitude" type="number" class="mt-1 block w-full" :value="old('longitude')" required autofocus autocomplete="longitude" />
                                        <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                                    </div>
                                    <div>
                                        <x-input-label for="activation_key" :value="__('Activation Key')" />
                                        <x-text-input id="activation_key" name="activation_key" type="number" class="mt-1 block w-full" :value="old('activation_key')" required autofocus autocomplete="activation_key" />
                                        <x-input-error class="mt-2" :messages="$errors->get('activation_key')" />
                                    </div>
                                    <div class="mb-6">
                                        <label for="opensource" class="inline-flex items-center">
                                            <input type="checkbox" name="opensource" id="opensource" value="0" class="form-checkbox">
                                            <span class="ml-2">Open Source?</span>
                                        </label>
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
</x-app-layout>
