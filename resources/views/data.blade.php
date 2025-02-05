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
            <x-card>
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

            <div >

            </div>
        </div>
    </div>

</x-app-layout>
