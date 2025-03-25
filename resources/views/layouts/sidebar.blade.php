<div id="sidebar-cont" class=" flex flex-col w-8 h-full z-30">
    <form method="get" action="{{ route('sensor_data.index') }}" class="flex flex-col w-8 h-full z-30">
        @csrf
        @method('GET')
        <div id ="sidebar" class="sidebar sticky w-full h-full  bg-white z-30 shadow-[rgba(0,0,0,0.1)_1px_4px_4px_0px] transition-all overflow-y-auto flex justify-center flex-row">
            <div id="list-cont" class="w-full max-w-40 h-full hidden opacity-0 bg-slate-50 py-3 pl-3 pr-1">
                <h2>Sensor Filters</h2>
                <ul class="flex flex-col gap-1 list-none bg-inherit">
                    <div class="flex items-center text-s text-gray-400 pt-2">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <x-switch-select id="openSourceToggle" onclick="openSource()">Open Source</x-switch-select>
                        </li>
                    </div>
                    @if (Auth::user() != null)
                        <div class="flex items-center text-s text-gray-400 pt-3">
                            <li class="flex flex-row w-full justify-between opacity-0">
                                <x-switch-select id="mySensorsToggle" onclick="mySensors()">My Sensors</x-switch-select>
                            </li>
                        </div>
                    @endif

                    <div class="flex items-center text-s text-gray-400 flex-row pt-3">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <x-accordion-wrapper id="openSourceAccordion">
                                <x-accordion-head data-accordion-target="#openSource" aria-expanded="false" class="!p-0" >
                                    <x-slot name="title" class="text-sm">Open Source</x-slot>
                                    <x-accordion-body id="openSource">

                                        @foreach ($sensors as $sensor)
                                            <x-switch-select class="openSource">{{$sensor->sensor_id}}</x-switch-select>
                                        @endforeach
                                    </x-accordion-body>
                                </x-accordion-head>
                            </x-accordion-wrapper>
                        </li>
                    </div>
                    @if (Auth::user() != null)
                        <div class="flex items-center text-s text-gray-400 flex-row pt-3">
                            <li class="flex flex-row w-full justify-between opacity-0">
                                <x-accordion-wrapper id="mySensorAccordion">
                                    <x-accordion-head data-accordion-target="#mySensors" aria-expanded="false" class="!p-0" >
                                        <x-slot name="title" class="text-sm">My Sensors</x-slot>
                                        <x-accordion-body id="mySensors">
                                            @foreach ($ownedSensors as $ownedSensor)
                                                <x-switch-select class="mySensor">{{$ownedSensor->sensor_id}}</x-switch-select>
                                            @endforeach
                                        </x-accordion-body>
                                    </x-accordion-head>
                                </x-accordion-wrapper>
                            </li>
                        </div>
                    @endif
                    <div class="flex items-center text-s text-gray-400 pt-3">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <label for="underline_select" class="sr-only">Body Of Water</label>
                            <select id="underline_select" class="block py-0 px-0 w-full text-sm text-gray-500 font-medium bg-transparent border-0 border-b border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option class="px-0" selected>Body Of Water</option>
                                @foreach ($bodyOfWater as $body)
                                    <option value="{{$body->body_of_water}}">{{$body->body_of_water}}</option>
                                @endforeach
                            </select>
                        </li>
                    </div>

                    <div class="flex items-center text-s text-gray-400 flex-row pt-3">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <x-accordion-wrapper id="datetimeAccordion">
                                <x-accordion-head data-accordion-target="#datetime" aria-expanded="false" class="!p-0" >
                                    <x-slot name="title" class="text-sm">Date Selector</x-slot>
                                    <x-accordion-body id="datetime">
                                        <!-- Date Time -->
                                        <form action="" class="w-full flex flex-wrap justify-center">
                                            <div id="date-range-picker" date-rangepicker datepicker-format="dd/mm/yyyy" datepicker-autohide datepicker-orientation="bottom middle" class="flex flex-col">
                                                <div class="relative pr-1">
                                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                    </svg>
                                                </div>
                                                <input id="datepicker-range-start"  name="start"  type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date start">
                                                </div>

                                                <div class="relative pr-1 pt-2">
                                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                    </svg>
                                                </div>
                                                <input id="datepicker-range-end" name="end"  type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date end">
                                            </div>
                                            </div>
                                        </form>
                                    </x-accordion-body>
                                </x-accordion-head>
                            </x-accordion-wrapper>
                        </li>
                    </div>

                    <div class="flex justify-center text-s text-gray-400 flex-row pt-3">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-4/5 pt-2 flex justify-center">Submit</button>
                    </div>



                </ul>
            </div>
            <div class=" h-full min-w-8 w-8 flex flex-col max-w-8 justify-between items-center py-3" onclick="sidebarToggle()">
                <div class="w-5 flex justify-center">
                    <img src="{{URL::asset('imgs/arrow.svg')}}" alt="sidebar-toggle" id="sidebar-toggle" class="w-full h-full" >
                </div>
            </div>
        </div>
    </form>
</div>

