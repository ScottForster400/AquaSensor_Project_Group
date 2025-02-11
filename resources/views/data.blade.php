<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">
            <form action="" class = "w-4/5">
                <x-search-bar-gps placeholder="Search for a Sensor..."></x-search-bar-gps>
            </form>
            <x-card class="mb-2">
                <div id="card-top" class="flex flex-row h-20">
                    <div id="card-top-left" class="flex flex-col basis-3/4 justify-between">
                        <h2>Sensor Location</h2>
                        <div id="DO-data" class=" hidden flex-row items-end">
                            <div class="h-8 w-8 ">
                                <img src="{{URL::asset('imgs/DO.svg')}}"" alt="dissolved_oxygen" class="w-full h-full" style="left: -4.5px; position:relative">
                            </div>
                            <p class="pl-1">12 mg/l</p>
                        </div>
                        <div id="temp-data" class=" flex flex-row items-end">
                            <div class="h-8 w-8 ">
                                <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full" style="left: -4.5px; position:relative">
                            </div>
                            <p class="pl-1">12°c</p>
                        </div>
                    </div>
                    <div id="card-top-right" class="flex basis-1/4 flex-col items-end justify-between">
                        <p>Monday</p>
                        <p>10 am</p>
                        <div class="flex flex-row items-center">
                            <div class="h-5 w-5 mr-2">
                                <img src="{{URL::asset('imgs/tick.svg')}}" alt="tick" class="w-full h-full ">
                            </div>
                            <p>Safe</p>
                        </div>
                    </div>
                </div>
                <div id="card-data">
                    @include('layouts.main-card-tab')
                </div>
            </x-card>

            <div class="flex flex-row justify-evenly w-10/12">
                <x-card class="basis-1/2 w-full mr-2 mt-2 flex flex-col items-center text-center justify-between px-2 hover:bg-gray-100 hover:shadow-xl transition-all">
                    <div class="h-8 w-8 flex justify-center items-center">
                        <img src="{{URL::asset('imgs/temp.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                    </div>
                    <h3>12°c</h3>
                    <p class="text-gray-500 text-xs">Temperature</p>
                </x-card>

                <x-card class="basis-1/2 w-full ml-2 mt-2 flex flex-col items-center text-center justify-between px-2 hover:bg-gray-100 hover:shadow-xl transition-all">
                    <div class="h-9 w-9 flex justify-center items-center ">
                        <img src="{{URL::asset('imgs/DO.svg')}}"" alt="dissolved_oxygen" class="w-full h-full">
                    </div>
                    <h3>12 mg/l</h3>
                    <p class="text-gray-500 text-xs">Dissolved Oxygen</p>
                </x-card>
            </div>
            <x-card class="px-2">
                <h2 class="m">
                    Sensor Data
                </h2>
                <form action="" class="w-full flex justify-center">
                    <x-date-time-picker></x-date-time-picker>
                </form>
                <div id="graph" class="h-32 flex items-center justify-center border-gray-400 border-solid border-2 my-2">
                    <p>Graph placeholder</p>
                </div>
            </x-card>
        </div>
    </div>

</x-app-layout>
