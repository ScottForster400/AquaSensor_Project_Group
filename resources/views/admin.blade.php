<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>
    
    <p>Sensors</p>

    <x-modal-toggle data-modal-target="edit" data-modal-toggle="edit">Create Sensor</x-modal-toggle>
            <!-- Modal to create Sensor -->
            <x-modal id="edit" class="bg-gray-500 bg-opacity-75 h-full">
                <x-modal-header data-modal-hide="edit">Create Sensor</x-modal-header>
                <x-modal-body>
                    <form>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <button type="Create" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </x-modal-body>
            </x-modal>

</x-app-layout>
