<div class="mb-4  border-gray-200 dark:border-gray-700 px-2">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="temp--styled-tab" data-tabs-target="#temp" type="button" role="tab" aria-controls="temperature" aria-selected="false" onclick="showTemp()">Temp</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="DO-styled-tab" data-tabs-target="#DO" type="button" role="tab" aria-controls="dashboard" aria-selected="false" onclick="showDO()">DO</button>
        </li>
    </ul>
</div>
<div id="default-styled-tab-content" class="max-sm:h-44  h-80">
    <div class="hidden  rounded-lg bg-gray-50 dark:bg-gray-800 h-full w-full" id="temp" role="tabpanel" aria-labelledby="temperature-tab">
        <div id="graph-temp" class="h-full w-full flex items-center justify-center  my-2">
            <div class="day-graph h-full w-full">
                <canvas id="tempChart"> </canvas>
            </div>
            <div class="night-graph h-full w-full hidden">
                <canvas id="tempChartNight"> </canvas>
            </div>
        </div>
    </div>
    <div class="hidden p rounded-lg bg-gray-50 dark:bg-gray-800 h-full w-full " id="DO" role="tabpanel" aria-labelledby="dashboard-tab">
        <div id="graph-DO" class="h-full w-full  flex items-center justify-center  my-2">
            <div class="day-graph h-full w-full">
                <canvas id="DOChart" class="day-graph"> </canvas>
            </div>
            <div class="night-graph h-full w-full hidden">
                <canvas id="DOChartNight" class="night-graph hidden"> </canvas>
            </div>
        </div>
    </div>
</div>
