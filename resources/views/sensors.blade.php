<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sensors') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">

            <x-modal-toggle data-modal-target="edit" data-modal-toggle="edit">Activate Sensor</x-modal-toggle>
            <!-- Modal to activate Sensor -->
            <x-modal id="edit" class="bg-gray-500 bg-opacity-75 h-full">
                <x-modal-header data-modal-hide="edit">Activate Sensor</x-modal-header>
                <x-modal-body>
                    <form>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="sensor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sensor ID</label>
                                <input type="text" id="sensor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="001" required />
                            </div>
                            <div>
                                <label for="sensor_location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sensor Location</label>
                                <input type="text" id="sensor_location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="River Derwent" required />
                            </div>
                            <div class="mb-6">
                                <label for="activation_key" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Activation Key</label>
                                <input type="password" id="activation_key" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required />
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </x-modal-body>
            </x-modal>

        </div>
    </div>
</x-app-layout>
