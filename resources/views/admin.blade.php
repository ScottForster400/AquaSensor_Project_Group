<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    @error('email')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('password')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('name')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('admin')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('companyname')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('quantity')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror
    @error('confirm')
        <div class="text-sm mt-1 text-red-500">{{ $message }}</div>
    @enderror

    <p>Sensors</p>

    <div class="py-12 flex justify-center">
        <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">

            <x-card class="mb-2">
                <div id="card-top" class="flex flex-row h-20">
            <x-modal-toggle data-modal-target="create-sensor" data-modal-toggle="create-sensor">Create Sensor</x-modal-toggle>

                        <x-modal id="create-sensor" class="bg-gray-500 bg-opacity-75 h-full">
                            <x-modal-header data-modal-hide="create-sensor">Create Sensor</x-modal-header>
                            <x-modal-body>
                                <form id="sensor-form" method="POST" action="{{ route('admin.createSensor') }}">
                                    @csrf
                                    <div>
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-900">Sensor Name (optional)</label>
                                        <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    </div>
                                    <div class="mb-6">
                                        <label for="ID" class="block text-sm font-medium text-gray-900">Sensor ID</label>
                                        <input type="text" id="ID" name="ID" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <div class="mb-6">
                                        <label for="ActivationKey" class="block text-sm font-medium text-gray-900">Activation key</label>
                                        <input type="text" id="ActivationKey" name="ActivationKey" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <button type="submit" id="create-sensor-btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                                </form>
                            </x-modal-body>
                        </x-modal>


                    <x-modal-toggle data-modal-target="edit" data-modal-toggle="edit">Delete Sensor</x-modal-toggle>
                    <x-modal id="edit" class="bg-gray-500 bg-opacity-75 h-full">
                        <x-modal-header data-modal-hide="edit">Delete Sensor</x-modal-header>
                        <x-modal-body>
                            <form id="sensor form">
                            <label for="quantity">Sensor ID:</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="69">
                                    @foreach ($sensor as $sensorData)
                                        <p>Name: {{ $sensorData->sensor_name }}</p>
                                        <!--<p>Company Name: {{ $sensorData->companyname }}</p>-->
                                        <p>Location: {{ $sensorData->location }}</p>
                                        <p>Body of water: {{ $sensorData->body_of_water }}</p>
                                        <p>Created at: {{ $sensorData->created_at }}</p>
                                        <p>Activated: {{ $sensorData->updated_at }}</p>
                                        <p>Open Source: {{ $sensorData->opensource }}</p>
                                        <p>Longitude: {{ $sensorData->longitude }}</p>
                                        <p>Latitude: {{ $sensorData->latitude }}</p>
                                    @endforeach
                                </div>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Delete</button>
                                </div>
                            </form>
                        </x-modal-body>
                    </x-modal>
                    </div>
                    </x-card>

                    <p>Users</p>

                    <x-card class="mb-2">
                <div id="card-top" class="flex flex-row h-20">



                    <x-modal-toggle data-modal-target="create-user" data-modal-toggle="create-user">Create User</x-modal-toggle>

                    <x-modal id="create-user" class="bg-gray-500 bg-opacity-75 h-full">
                        <x-modal-header data-modal-hide="create-user">Create User</x-modal-header>
                        <x-modal-body>
                            <form  method="POST" action="{{ route('admin.createUser') }}">
                                @csrf
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                                        <input type="text" id="name" name="name" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                        <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                                        <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <div>
                                        <label for="companyname" class="block text-sm font-medium text-gray-900">Company Name</label>
                                        <input type="text" id="companyname" name="companyname" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300">
                                    </div>
                                    <label for="test6">Admin</label>
                                    <input type="hidden" id="test6" value="0" ng-model="isFull" checked name="admin">
                                    <input type="checkbox" id="test6" value="1" ng-model="isFull" name="admin">

                                </div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                            </form>
                        </x-modal-body>
                    </x-modal>

                        <x-modal-toggle data-modal-target="delete sensor" data-modal-toggle="delete sensor">Delete User</x-modal-toggle>
                    <x-modal id="delete sensor" class="bg-gray-500 bg-opacity-75 h-full">
                        <x-modal-header data-modal-hide="delete sensor">Delete User</x-modal-header>
                        <x-modal-body>
                            <form>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    @foreach ($user as $userData)
                                        <p>Name: {{ $userData->name }}</p>
                                        <p>Email: {{ $userData->email }}</p>
                                        <p>Is verified: @if($userData->email_verified_at == null) no @else yes @endif</p>
                                        <p>Created at: {{ $userData->company_name }}</p>
                                        <p>Is admin: @if($userData->admin == 0) no @else yes @endif</p>
                                    @endforeach
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Delete User</button>
                                </div>
                            </form>
                        </x-modal-body>
                    </x-modal>
                </div>
            </x-card>
        </div>
    </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Function to open modal
                    function openModal(modalId) {
                        const modal = document.getElementById(modalId);
                        if (modal) {
                            modal.classList.remove("hidden");
                            modal.classList.add("flex"); // Ensure modal is visible
                        }
                    }

                    // Function to close modal
                    function closeModal(modalId) {
                        const modal = document.getElementById(modalId);
                        if (modal) {
                            modal.classList.add("hidden");
                            modal.classList.remove("flex");
                        }
                    }

                    // Add event listeners to toggle buttons
                    document.querySelectorAll("[data-modal-toggle]").forEach(button => {
                        button.addEventListener("click", function () {
                            const target = this.getAttribute("data-modal-target");
                            openModal(target);
                        });
                    });

                    // Add event listeners to close buttons
                    document.querySelectorAll("[data-modal-hide]").forEach(button => {
                        button.addEventListener("click", function () {
                            const target = this.getAttribute("data-modal-hide");
                            closeModal(target);
                        });
                    });

                    // Close modal when clicking outside the modal content
                    document.querySelectorAll(".modal").forEach(modal => {
                        modal.addEventListener("click", function (event) {
                            if (event.target === modal) {
                                closeModal(modal.id);
                            }
                        });
                    });
                });
            </script>




</x-app-layout>
