<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Data') }}
                </h2>
            </div>

            <div class="flex justify-right sm:hidden">
                <b class="pr-2 pb-1">Day/Night:</b>
                <label>
                    <input type="checkbox" name="check" value="check" id="check">
                    <span class="check" ></span>
                </label>
            </div>
        </div>
        <label onclick="desktopdaynight()">
            <input type="checkbox" name="check2" value="check2" id="check2">
            <span class="check2" ></span>
        </label>
    </x-slot>

    @if(!isset($message))
        <div class="py-12 flex justify-center z-10 pb-1">
            <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full z-10 ">
                <form id="SearchBarForm" autocomplete="off" action="{{route('sensorData.search')}}" class = "w-10/12">
                    @include('layouts.searchbar')
                </form>
                <div class="flex justify-between w-10/12 ">
                    <x-card class="mb-2 !px-4 !py-6 z-10 w-full">
                        <div id="card-top" class="flex flex-row h-20 px-2">
                            <div id="card-top-left" class="flex flex-col basis-3/4 justify-between">
                                <h2>{{Str::title($currentSensor->sensor_name)}}</h2>
                                <div id="DO-data" class=" hidden flex-row items-end">
                                    <div class="h-8 w-8 ">
                                        <img src="{{URL::asset('imgs/DO.svg')}}"" alt="dissolved_oxygen" class="w-full h-full" style="left: -4.5px; position:relative">
                                    </div>
                                    <p class="">{{$currentSensorData->mgl_dissolved_oxygen}} mg/l</p>
                                </div>
                                <div id="temp-data" class=" flex flex-row items-end">
                                    <div class="h-8 w-8 ">
                                        <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full" style="left: -7.5px; position:relative">
                                    </div>
                                    <p class="">{{$currentSensorData->temperature}}°c</p>
                                </div>
                            </div>
                            <div id="card-top-right" title="Last Recorded Data" class="flex basis-1/4 flex-col items-end justify-between">
                                <p data-tooltip-target="Data-tooltip">{{$weekDay}}</p>
                                <div id="Data-tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Last Recorded Data
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                <p>{{substr($currentSensorData->sensor_data_time, 0, 5);}}</p>
                                <div class="flex flex-row items-center">
                                    <div class="h-5 w-5 mr-2">

                                        @if($isActive=='inactive')
                                                <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="inactive" class="w-full h-full ">
                                            </div>
                                            <p>Inactive</p>
                                        @else
                                                <img src="{{URL::asset('imgs/safe.svg')}}" alt="tick" class="w-full h-full ">
                                            </div>
                                            <p>Active</p>
                                        @endif

                                </div>
                            </div>
                        </div>
                        <div id="card-data">
                            <div class="">
                                @include('layouts.main-card-tab')
                            </div>
                        </div>
                    </x-card>
                </div>

                <div class="flex flex-row justify-evenly sm:justify-between w-10/12 h-28 sm:h-40">
                    <x-card-flippable class="mr-2 max-w-64 z-10">
                        <x-card-flippable-frontface>
                            <div class="h-8 w-8 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->temperature}}°c</h3>
                            <p class="text-gray-500 text-xs">Temperature</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between sm:justify-evenly !text-left !px-1 !py-1 day-card">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataTemp[0]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekly Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataTemp[1]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataTemp[2]}}°C</p>
                            </div>
                        </x-card-flippable-backface>
                        <x-nightcard-flippable-backface class="items-start justify-between sm:justify-evenly !text-left !px-1 !py-1 ">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataTemp[0]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekly Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataTemp[1]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataTemp[2]}}°C</p>
                            </div>
                        </x-nightcard-flippable-backface>
                    </x-card-flippable>


                    <x-card-flippable class="ml-2 max-w-64  max-sm:hidden z-10" onclick="desktopdaynight()">
                        <x-card-flippable-frontface>
                            <div class="h-8 w-8 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/sun.svg')}}" alt="sun" class="w-full h-full">
                            </div>
                            <h>Day</h>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between !text-left !px-1 !py-1 sm:justify-evenly">
                            <div class="h-8 w-8 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/moon.svg')}}" alt="moon" class="w-full h-full">
                            </div>
                            <h>Night</h>
                        </x-card-flippable-backface>
                    </x-card-flippable>





                    <x-card-flippable class="ml-2 max-w-64 z-10">
                        <x-card-flippable-frontface>
                            <div class="h-9 w-9 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/DO.svg')}}" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->mgl_dissolved_oxygen}} mg/l</h3>
                            <p class="text-gray-500 text-xs">Dissolved Oxygen</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between !text-left !px-1 !py-1 sm:justify-evenly  day-card">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataDO[0]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekly Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataDO[1]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Avg <span class="text-[9px]">(Day)</span></h3>
                                <p>{{$dayFlipCardDataDO[2]}} mg/L</p>
                            </div>
                        </x-card-flippable-backface>
                        <x-nightcard-flippable-backface class="items-start justify-between !text-left !px-1 !py-1 sm:justify-evenly">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataDO[0]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekly Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataDO[1]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Avg <span class="text-[9px]">(Night)</span></h3>
                                <p>{{$dayFlipCardDataDO[2]}} mg/L</p>
                            </div>
                        </x-nightcard-flippable-backface>
                    </x-card-flippable>
                </div>
                <x-card class="px-2 !my-3 !pb-1  z-10 flex flex-col items-center">
                    <div class="px-2 h-auto w-full">
                        <h2 class="w-full text-start ">
                            Sensor Data
                        </h2>

                        <form action="{{route('sensorData.index')}}" class=" flex justify-center  flex-col w-full mt-2">
                            <x-date-time-picker></x-date-time-picker>
                            <div class="w-full pt-3">
                                <x-button-1 class="w-full">Search</x-button-1>
                            </div>
                            <input type="hidden" name="sensor_id" value="{{$currentSensor->sensor_id}}">
                        </form>
                    </div>

                    <div id="graph" class="max-sm:h-60 h-96 w-full flex items-center justify-center  my-2">
                        <canvas id="myChart"> </canvas>
                    </div>
                </x-card>
            </div>
        </div>
        @include('layouts.charts')
        <script>
            window.SensorsJS = @json($Sensors);
        </script>
        <script src="{{ asset('js/userLocation.js') }}"></script>
    @else
    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">
            <x-card>
                <h2>{{ $message }}</h2>
            </x-card>
        </div>
    </div>
    @endif
    @include('layouts.waves')

</x-app-layout>

<?
