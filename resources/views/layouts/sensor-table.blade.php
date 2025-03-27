<div class="mb-4  border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center justify-evenly sm:justify-start" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="temp--styled-tab" data-tabs-target="#temp" type="button" role="tab" aria-controls="temperature" aria-selected="false" onclick="showTemp()">All Sensors</button>
        </li>
        @if (Auth::check())
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="DO-styled-tab" data-tabs-target="#DO" type="button" role="tab" aria-controls="dashboard" aria-selected="false" onclick="showDO()">My Sensors</button>
            </li>
        @endif
    </ul>
</div>
<div id="default-styled-tab-content w-4/5">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="temp" role="tabpanel" aria-labelledby="temperature-tab">
        <x-table>
            <x-table-body>
                @foreach($opensource as $sensor)

                    <x-tr>
                        <x-th class="border-b border-gray-300 w-full">
                            <a href="{{route('sensorData.index', ['sensor_id'=>$sensor->sensor_id])}}">
                                <x-modal-toggle class="w-full !text-gray-950 bg-transparent hover:text-blue-800 hover:bg-transparent focus:outline-none font-medium rounded-md text-sm px-4 py-2 transition-all duration-300 ease-in-out">
                                    <strong class="underline">{{Str::limit($sensor->sensor_id,15)}}</strong>
                                    <p class="text-gray-600">{{Str::limit($sensor->location,20)}}</p>
                                </x-modal-toggle>
                            </a>
                        </x-th>
                    </x-tr>
                @endforeach
            </x-table-body>
        </x-table>
        {{$opensource->links()}}
    </div>
    @if (Auth::check())
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="DO" role="tabpanel" aria-labelledby="dashboard-tab">
            <x-table>
                <x-table-body>
                    @foreach($user_sensors as $sensor1)
                        <x-tr class="!px-0 !p-0 !py-0">
                            <x-th class="border-b border-gray-300 w-full !px-2">
                                <a href="{{route('sensorData.index', ['sensor_id'=>$sensor1->sensor_id])}}">
                                    <x-modal-toggle class="w-full !text-gray-950 bg-transparent hover:text-blue-800 hover:bg-transparent focus:outline-none font-medium rounded-md text-sm px-1 py-1 transition-all duration-300 ease-in-out">
                                        <strong class="underline">{{Str::limit($sensor1->sensor_name,15)}}</strong>
                                        <p class="text-gray-600">{{Str::limit($sensor1->location,20)}}</p>
                                    </x-modal-toggle>
                                </a>
                            </x-th>
                            <x-th class="border-b border-gray-300 w-full !px-1">
                                <div class="flex-col !px-0">
                                    <div class="!px-0">
                                        <x-modal-toggle data-modal-target="edit{{$sensor1}}" data-modal-toggle="edit{{$sensor1}}">Edit</x-modal-toggle>
                                    <!-- Modal to edit Sensor -->
                                        <x-modal id="edit{{$sensor1}}" class="bg-gray-500 bg-opacity-75 h-full">
                                            <x-modal-header data-modal-hide="edit{{$sensor1}}">Edit Sensor</x-modal-header>
                                            <x-modal-body>
                                                <form method="post" action="{{ route('sensors.update',$sensor1) }}" class="mt-6 space-y-6">
                                                    @method('put')
                                                    @csrf
                                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                        <div>
                                                            <x-input-label for="sensor_name" :value="__('Sensor Name')" />
                                                            <x-text-input id="sensor_name" name="sensor_name" type="text" class="mt-1 block w-full " :value="old('sensor_name')" required autofocus autocomplete="sensor_name" />
                                                            <x-input-error class="mt-2" :messages="$errors->get('sensor_name')" />
                                                        </div>
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
                                                        <div class="mb-6">
                                                            <label for="opensource" class="w-full inline-flex items-center block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                <select name="opensource" id="opensource" name="opensource" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <option value="1">Open Source</option>
                                                                    <option value="0">Closed Source</option>
                                                                </select>
                                                            </label>
                                                        </div>


                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                                    </div>
                                                </form>
                                            </x-modal-body>
                                        </x-modal>

                                    </div>
                                </div>
                            </x-th>
                        </x-tr>

                    @endforeach
                </x-table-body>
            </x-table>
            @if (Auth::check())
                {{$user_sensors->links()}}
            @endif
        </div>
    @endif
</div>



