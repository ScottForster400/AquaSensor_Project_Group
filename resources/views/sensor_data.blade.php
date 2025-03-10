<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data') }}
        </h2>
    </x-slot>

    <div class=" flex flex-row w-full h-screen max-sm:max-h-96">

        @include('layouts.sidebar')
        <div class="py-0 flex justify-center basis-11/12 z-10 pb-1">
            <div class="flex items-center justify-center flex-col  mx-auto sm:px-6 lg:px-8 w-full z-10 ">


                <x-card class="mb-2 !px-4  z-10">
                    @include('layouts.sensor-data-tab')
                </x-card>


            </div>
        {{-- @include('layouts.charts') --}}
        {{-- @else
        <div class="py-12 flex justify-center">
            <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">
                <x-card>
                    <h2>No Sensor Data in system</h2>
                </x-card>
            </div>
        </div>
        @endif --}}

        </div>
    </div>
    {{-- @include('layouts.waves') --}}
</x-app-layout>
