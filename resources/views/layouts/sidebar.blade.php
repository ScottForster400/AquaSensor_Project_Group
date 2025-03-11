<div id="sidebar-cont" class=" flex flex-col w-8 h-full z-30">
    <div id ="sidebar" class="sidebar sticky w-full h-full  bg-white z-30 shadow-[rgba(0,0,0,0.1)_1px_4px_4px_0px] transition-all overflow-y-auto flex justify-center flex-row">
        <div id="list-cont" class="w-full max-w-40 hidden opacity-0 bg-slate-50 py-3 pl-3 pr-1">
            <h2>Sensor Filters</h2>
            <ul class="flex flex-col gap-1 list-none">
                <div class="flex items-center text-s text-gray-400 pt-2">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <x-switch-select>Open Source</x-switch-select>
                    </li>
                </div>
                @if (Auth::user() != null)
                    <div class="flex items-center text-s text-gray-400 pt-2">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <x-switch-select>My Sensors</x-switch-select>
                        </li>
                    </div>
                @endif

                <div class="flex items-center text-s text-gray-400 flex-row pt-2">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <x-accordion-wrapper id="openSourceAccordion">
                            <x-accordion-head data-accordion-target="#openSource" aria-expanded="false" class="!p-0" >
                                <x-slot name="title" class="text-sm">Open Source</x-slot>
                                <x-accordion-body id="openSource">

                                    @foreach ($sensors as $sensor)
                                        <x-switch-select>{{$sensor->sensor_id}}</x-switch-select>
                                    @endforeach
                                </x-accordion-body>
                            </x-accordion-head>
                        </x-accordion-wrapper>
                    </li>
                </div>
                @if (Auth::user() != null)
                    <div class="flex items-center text-s text-gray-400 flex-row pt-2">
                        <li class="flex flex-row w-full justify-between opacity-0">
                            <x-accordion-wrapper id="mySensorAccordion">
                                <x-accordion-head data-accordion-target="#mySensors" aria-expanded="false" class="!p-0" >
                                    <x-slot name="title" class="text-sm">My Sensors</x-slot>
                                    <x-accordion-body id="mySensors">
                                        @foreach ($ownedSensors as $ownedSensor)
                                            <x-switch-select>{{$ownedSensor->sensor_id}}</x-switch-select>
                                        @endforeach
                                    </x-accordion-body>
                                </x-accordion-head>
                            </x-accordion-wrapper>
                        </li>
                    </div>
                @endif
                <div class="flex items-center text-s text-gray-400">
                    <li class="flex flex-row w-full justify-between opacity-0">

                    </li>
                </div>
            </ul>
        </div>
        <div class=" h-full min-w-8 w-8 flex flex-col max-w-8 justify-between items-center py-3" onclick="sidebarToggle()">
            <div class="w-5 flex justify-center">
                <img src="{{URL::asset('imgs/arrow.svg')}}" alt="sidebar-toggle" id="sidebar-toggle" class="w-full h-full" >
            </div>
            <div class=" w-5 flex justify-center">
                <img src="{{URL::asset('imgs/arrow.svg')}}" alt="sidebar-toggle" id="sidebar-toggle" class="w-full h-full" >
            </div>
            <div class="w-5 flex justify-center">
                <img src="{{URL::asset('imgs/arrow.svg')}}" alt="sidebar-toggle" id="sidebar-toggle" class="w-full h-full">
            </div>
        </div>
    </div>
</div>

