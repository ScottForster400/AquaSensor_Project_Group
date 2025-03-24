<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data') }}
        </h2>
    </x-slot>

    @if(isset($currentSensorData))
        <div class="py-12 flex justify-center z-10 pb-1">
            <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full z-10 ">
                <form id="SearchBarForm" autocomplete="off" action="{{route('sensorData.search')}}" class = "w-10/12">
                    @include('layouts.searchbar')
                </form>
                <x-card class="mb-2 !px-4 !py-6 z-10">
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
                        @include('layouts.main-card-tab')
                    </div>
                </x-card>

                <div class="flex flex-row justify-evenly w-10/12 h-28">
                    <x-card-flippable class="mr-2">
                        <x-card-flippable-frontface>
                            <div class="h-8 w-8 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->temperature}}°c</h3>
                            <p class="text-gray-500 text-xs">Temperature</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between !text-left !px-1 !py-1">
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
                    <x-card-flippable class=ml-2>
                        <x-card-flippable-frontface>
                            <div class="h-9 w-9 flex justify-center items-center ">
                                <img src="{{URL::asset('imgs/DO.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                            </div>
                            <h3>{{$currentSensorData->mgl_dissolved_oxygen}} mg/l</h3>
                            <p class="text-gray-500 text-xs">Dissolved Oxygen</p>
                        </x-card-flippable-frontface>
                        <x-card-flippable-backface class="items-start justify-between !text-left !px-1 !py-1">
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
                    <form action="{{route('sensors.index')}}" class="w-full flex justify-center">
                        <x-date-time-picker></x-date-time-picker>
                    </form>
                    <div id="graph" class="max-sm:h-60 h-96 flex items-center justify-center  my-2">
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
                <h2>No Sensor Data in system</h2>
            </x-card>
        </div>
    </div>
    @endif
    @include('layouts.waves')

</x-app-layout>
