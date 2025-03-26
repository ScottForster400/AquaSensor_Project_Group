<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Data') }}
                </h2>
            </div>

            <div class="flex justify-right">
                <b class="pr-2 pb-1">Day/Night:</b>
                <label>
                    <input type="checkbox">
                    <span class="check" ></span>
                </label>
            </div>
    </x-slot>

    @if(isset($currentSensorData))
        <div class="py-12 flex justify-center z-10 pb-1">
            <div class="flex items-center flex-col max-w-6xl mx-auto sm:px-6 lg:px-8 w-full z-10 ">
                <form action="{{route('sensorData.search')}}" class = "w-10/12">
                    <x-search-bar-gps placeholder="Search for a Sensor..."></x-search-bar-gps>
                </form>
                <div class="flex justify-between w-10/12 ">
                    <x-card class="mb-2 !px-4 !py-6 z-10 mr-2 w-full">
                        <div id="card-top" class="flex flex-row h-20 px-2">
                            <div id="card-top-left" class="flex flex-col basis-3/4 justify-between">
                                @if(Auth::user() == null || Auth::user()->id != $currentSensor->user_id)
                                    <h2>{{Str::title($currentSensorData->sensor_id)}}</h2>
                                @else
                                    <h2>{{Str::title($currentSensor->sensor_name)}}</h2>
                                @endif
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
                            <div id="card-top-right" class="flex basis-1/4 flex-col items-end justify-between">
                                <p>{{$weekDay}}</p>
                                <p>{{substr($currentSensorData->sensor_data_time, 0, 5);}}</p>
                                <div class="flex flex-row items-center">
                                    <div class="h-5 w-5 mr-2">
                                        @if($currentSensorData->mgl_dissolved_oxygen<=4)
                                                <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                            </div>
                                            <p>Unsafe</p>
                                        @elseif($currentSensorData->mgl_dissolved_oxygen<=6.5)

                                            @if ($currentSensorData->temperature>=10)
                                                    <img src="{{URL::asset('imgs/caution.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Caution</p>
                                            @else
                                                    <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Unsafe</p>
                                            @endif
                                        @else

                                            @if ($currentSensorData->temperature>=14)
                                                    <img src="{{URL::asset('imgs/safe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Safe</p>
                                            @elseif($currentSensorData->temperature>=10)
                                                    <img src="{{URL::asset('imgs/caution.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Caution</p>
                                            @else
                                                    <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Unsafe</p>
                                            @endif
                                        @endif

                                </div>
                            </div>
                        </div>
                        <div id="card-data">
                            <div class="">
                                @include('layouts.main-card-tab')
                            </div>
                            {{-- <div class="max-sm:hidden max-sm:h-44  h-80">
                                <div class=" rounded-lg bg-gray-50 dark:bg-gray-800 h-full w-full" id="temp" role="tabpanel" aria-labelledby="temperature-tab">
                                    <div id="graph-temp" class="h-full w-full flex items-center justify-center  my-2">
                                        <canvas id="tempChart"> </canvas>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </x-card>
                    {{-- <x-card class="mb-2 !px-4 !py-6 z-10 ml-2 max-sm:hidden">
                        <div id="card-top" class="flex flex-row h-20 px-2">
                            <div id="card-top-left" class="flex flex-col basis-3/4 justify-between">
                                @if(Auth::user() == null || Auth::user()->id != $currentSensor->user_id)
                                    <h2>{{Str::title($currentSensorData->sensor_id)}}</h2>
                                @else
                                    <h2>{{Str::title($currentSensor->sensor_name)}}</h2>
                                @endif
                                <div id="DO-data" class=" flex-row items-end">
                                    <div class="h-8 w-8 ">
                                        <img src="{{URL::asset('imgs/DO.svg')}}"" alt="dissolved_oxygen" class="w-full h-full" style="left: -4.5px; position:relative">
                                    </div>
                                    <p class="">{{$currentSensorData->mgl_dissolved_oxygen}} mg/l</p>
                                </div>
                            </div>
                            <div id="card-top-right" class="flex basis-1/4 flex-col items-end justify-between">
                                <p>{{$weekDay}}</p>
                                <p>{{substr($currentSensorData->sensor_data_time, 0, 5);}}</p>
                                <div class="flex flex-row items-center">
                                    <div class="h-5 w-5 mr-2">
                                        @if($currentSensorData->mgl_dissolved_oxygen<=4)
                                                <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                            </div>
                                            <p>Unsafe</p>
                                        @elseif($currentSensorData->mgl_dissolved_oxygen<=6.5)

                                            @if ($currentSensorData->temperature>=10)
                                                    <img src="{{URL::asset('imgs/caution.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Caution</p>
                                            @else
                                                    <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Unsafe</p>
                                            @endif
                                        @else

                                            @if ($currentSensorData->temperature>=14)
                                                    <img src="{{URL::asset('imgs/safe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Safe</p>
                                            @elseif($currentSensorData->temperature>=10)
                                                    <img src="{{URL::asset('imgs/caution.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Caution</p>
                                            @else
                                                    <img src="{{URL::asset('imgs/unsafe.svg')}}" alt="tick" class="w-full h-full ">
                                                </div>
                                                <p>Unsafe</p>
                                            @endif
                                        @endif

                                </div>
                            </div>
                        </div>
                        <div id="card-data">
                            <div class="sm:hidden">
                                @include('layouts.main-card-tab')
                            </div>
                            <div class="max-sm:hidden max-sm:h-44  h-80">
                                <div class="p rounded-lg bg-gray-50 dark:bg-gray-800 h-full w-full " id="DO" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div id="graph-DO" class="h-full w-full  flex items-center justify-center  my-2">
                                        <canvas id="DOChart"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card> --}}
                </div>

                <div class="flex flex-row justify-evenly sm:justify-between w-10/12 h-28 sm:h-40">
                    <x-card-flippable class="mr-2 max-w-64">
                        <x-card-flippable-frontface>
                            <div class="h-8 w-8 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->temperature}}°c</h3>
                            <p class="text-gray-500 text-xs">Temperature</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between sm:justify-evenly !text-left !px-1 !py-1">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Average</h3>
                                <p>{{$flipCardDataTemp[0]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekley Average</h3>
                                <p>{{$flipCardDataTemp[1]}}°C</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Average</h3>
                                <p>{{$flipCardDataTemp[2]}}°C</p>
                            </div>
                        </x-card-flippable-backface>
                    </x-card-flippable>


                    <x-card-flippable class="ml-2 max-w-64  max-sm:hidden" onclick="background()">
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





                    <x-card-flippable class="ml-2 max-w-64">
                        <x-card-flippable-frontface>
                            <div class="h-9 w-9 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/DO.svg')}}" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->mgl_dissolved_oxygen}} mg/l</h3>
                            <p class="text-gray-500 text-xs">Dissolved Oxygen</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between !text-left !px-1 !py-1 sm:justify-evenly">
                            <div class="text-xs w-full ">
                                <h3 class="text-gray-500 ">Daily Average</h3>
                                <p>{{$flipCardDataDO[0]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Weekley Average</h3>
                                <p>{{$flipCardDataDO[1]}} mg/L</p>
                            </div>
                            <div class="text-xs w-full">
                                <h3 class="text-gray-500 ">Monthly Average</h3>
                                <p>{{$flipCardDataDO[2]}} mg/L</p>
                            </div>
                        </x-card-flippable-backface>
                    </x-card-flippable>
                </div>
                <x-card class="px-2 !my-3 !pb-1">
                    <h2 class="">
                        Sensor Data
                    </h2>
                    <form action="" class="w-full flex justify-center">
                        <x-date-time-picker></x-date-time-picker>
                    </form>
                    <div id="graph" class="max-sm:h-60 h-96 flex items-center justify-center  my-2">
                        <canvas id="myChart"> </canvas>
                    </div>
                </x-card>
            </div>
        </div>
        @include('layouts.charts')
    @else
    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">
            <x-card>
                <h2>No Sensor Data in system</h2>
            </x-card>
        </div>
    </div>
    @endif
    @include('layouts.waves')
</x-app-layout>

<?
