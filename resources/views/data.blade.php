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
            <div class=" block w-10/12 rounded-lg shadow-md p-6 my-5 bg-white border-gray-200 " id="card">
                <div id="card-top" class="flex flex-row">
                    <div id="card-top-left" class="flex flex-col basis-3/4 justify-between">
                        <h2>Sensor Location</h2>
                        <div id="displayed-info">
                            12 mg/l
                        </div>
                    </div>
                    <div id="card-top-right" class="flex basis-1/4 flex-col items-end">
                        <p>Monday</p>
                        <p>10 am</p>
                        <p>Safe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
