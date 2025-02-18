<div class="mb-4  border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center justify-evenly" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="temp--styled-tab" data-tabs-target="#temp" type="button" role="tab" aria-controls="temperature" aria-selected="false" onclick="showTemp()">All Sensors</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="DO-styled-tab" data-tabs-target="#DO" type="button" role="tab" aria-controls="dashboard" aria-selected="false" onclick="showDO()">My Sensors</button>
        </li>
    </ul>
</div>
<div id="default-styled-tab-content w-4/5">
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="temp" role="tabpanel" aria-labelledby="temperature-tab">
        <x-table>
            <x-table-body>
                @foreach($opensource as $sensor)
                    <x-tr>
                        <x-th class="border-b border-gray-300 w-full">
                            <x-modal-toggle data-modal-target="edit{{$sensor}}" data-modal-toggle="edit{{$sensor}}" class="w-full text-gray-950 bg-transparent hover:text-blue-800 hover:bg-transparent focus:outline-none font-medium rounded-md text-sm px-4 py-2 transition-all duration-300 ease-in-out">{{$sensor->location}} - {{$sensor->sensor_id}}</x-modal-toggle>
                            <!-- Modal to view report -->
                            <x-modal id="edit{{$sensor}}" class="bg-gray-500 bg-opacity-75 h-full">
                                <x-modal-header data-modal-hide="edit{{$sensor}}">Report</x-modal-header>
                                <x-modal-body>
                                    <x-primary-button>View Sensor</x-primary-button>
                                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                                </x-modal-body>
                            </x-modal>
                        </x-th>
                    </x-tr>
                @endforeach
            </x-table-body>
        </x-table>
        {{$opensource->links()}}
    </div>
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="DO" role="tabpanel" aria-labelledby="dashboard-tab">

        <x-table>
            <x-table-body>
                @foreach($id_1_sensors_example as $sensor1)
                    <x-tr>
                        <x-th>
                            <x-accordion-head data-accordion-target="{{$sensor1->sensor_id}}" aria-controls="{{$sensor1->sensor_id}}" title="{{$sensor1->location}} - {{$sensor1->sensor_id}}">
                            </x-accordion-head>
                            <x-accordion-body id="{{$sensor1->sensor_id}}" aria-labelledby="accordion-flush-heading-1" class="hidden">
                                <x-primary-button>View Sensor</x-primary-button>
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </x-accordion-body>
                        </x-th>
                    </x-tr>
                @endforeach
            </x-table-body>
        </x-table>
        {{$id_1_sensors_example->links()}}

    </div>
</div>
