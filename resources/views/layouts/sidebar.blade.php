<div id="sidebar-cont" class=" flex flex-col w-8 h-full z-30">
    <div id ="sidebar" class="sidebar sticky w-full h-full  bg-white z-30 shadow-[rgba(0,0,0,0.1)_1px_4px_4px_0px] transition-all overflow-y-auto flex justify-center flex-row">
        <div id="list-cont" class="w-full max-w-40 hidden opacity-0 bg-slate-50 py-3 pl-3 pr-1">
            <h2>Sensor Filters</h2>
            <ul class="flex flex-col gap-1 list-none">
                <div class="flex items-center text-s text-gray-400 pt-2">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <label class="inline-flex justify-between items-center me-2 cursor-pointer w-full">
                            <span class=" text-xs font-medium text-gray-900 dark:text-gray-300">Open Source</span>
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-purple-600 peer-checked:bg-purple-600 dark:peer-checked:bg-purple-600"></div>
                          </label>
                    </li>
                </div>

                <div class="flex items-center text-s text-gray-400 pt-2">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <label class="inline-flex justify-between items-center me-2 cursor-pointer w-full">
                            <span class=" text-xs font-medium text-gray-900 dark:text-gray-300">My Sensors</span>
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-purple-600 peer-checked:bg-purple-600 dark:peer-checked:bg-purple-600"></div>
                          </label>
                    </li>
                </div>
                <div class="flex items-center text-s text-gray-400 flex-row pt-2">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <x-accordion-head data-accordion-target="#openSource" aria-expanded="false" class="!p-0" >
                            <x-slot name="title" class="text-sm">Open Source</x-slot>
                            <x-accordion-body id="openSource">
                                @foreach ($sensors as $sensor)

                                @endforeach
                            </x-accordion-body>
                        </x-accordion-head>
                    </li>
                </div>
                <div class="flex items-center text-s text-gray-400">
                    <li class="flex flex-row w-full justify-between opacity-0">
                        <p class="none">ewdhqwuhd</p>
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

