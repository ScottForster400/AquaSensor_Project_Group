<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

<div class="py-12 flex justify-center">
    <div class="flex items-center flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 w-full ">
        
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif
        @error('email')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('password')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('name')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('admin')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('companyname')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('quantity')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('confirm')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('ID')
            <x-warning>{{ $message }}</x-warning>
        @enderror
        @error('ActivationKey')
            <x-warning>{{ $message }}</x-warning>
        @enderror


        <x-card class="flex items-center flex-col w-4/5">
            <div>
                <strong class="underline">Sensors:</strong>
            </div>
            <div class="pb-4 pt-4">
                <x-modal-toggle data-modal-target="createsensor" data-modal-toggle="createsensor">Create Sensor</x-modal-toggle>
            </div>
            <div>
                <x-modal-toggle data-modal-target="deletesensor" data-modal-toggle="deletesensor">Delete Sensor</x-modal-toggle>
            </div>
        </x-card>

        <x-card class="flex items-center flex-col w-4/5">
            <div>
                <strong class="underline">Users:</strong>
            </div>
            <div class="pb-4 pt-4">
                <x-modal-toggle data-modal-target="createuser" data-modal-toggle="createuser">Create User</x-modal-toggle>
            </div>
            <div>
                <x-modal-toggle data-modal-target="deleteuser" data-modal-toggle="deleteuser">Delete User</x-modal-toggle>
            </div>
        </x-card>


        <!-- Modal to create Sensor -->
        <x-modal id="createsensor" class="bg-gray-500 bg-opacity-75 h-full">
            <x-modal-header data-modal-hide="createsensor">Create Sensor</x-modal-header>
            <x-modal-body>
                <form method="post" class="mt-6 space-y-6" action="{{ route('admin.createSensor') }}">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="sensor_id" :value="__('Sensor ID')" />
                            <x-text-input id="sensor_id" name="sensor_id" type="text" class="mt-1 block w-full " :value="old('sensor_id')" required autofocus autocomplete="sensor_id" />
                            <x-input-error class="mt-2" :messages="$errors->get('sensor_id')" />
                        </div>
                        <div>
                            <x-input-label for="activation_key" :value="__('Activation Key')" />
                            <x-text-input id="activation_key" name="activation_key" type="text" class="mt-1 block w-full" :value="old('activation_key')" required autofocus autocomplete="activation_key" />
                            <x-input-error class="mt-2" :messages="$errors->get('activation_key')" />
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </x-modal-body>
        </x-modal>

        <x-modal id="deletesensor" class="bg-gray-500 bg-opacity-75 h-full">
            <x-modal-header data-modal-hide="deletesensor">Delete Sensor</x-modal-header>
            <x-modal-body>
                <x-table>
                    <x-table-body>
                        @foreach($allsensors as $sensor)
                           
                            <x-tr>
                                <x-th class="border-b border-gray-300 w-full">
                                    <form method="post" action="{{ route('admin.destroySensor') }}">
                                        @csrf
                                        <input type="hidden" value={{ $sensor->sensor_id }} name="sensor_id">
                                        <button type="submit" class="w-full !text-gray-950 bg-transparent hover:text-blue-800 hover:bg-transparent focus:outline-none font-medium rounded-md text-sm px-4 py-2 transition-all duration-300 ease-in-out">
                                            <strong class="underline">{{Str::limit($sensor->sensor_id)}}</strong>
                                            <p class="text-gray-600">{{Str::limit($sensor->sensor_name,20)}}</p>
                                            <p class="text-gray-600">{{Str::limit($sensor->location,20)}}</p>
                                        </button>
                                    </form>
                                </x-th>
                            </x-tr>
                        @endforeach
                    </x-table-body>
                </x-table>
                {{$allsensors->links()}}
            </x-modal-body>
        </x-modal>

        <x-modal id="createuser" class="bg-gray-500 bg-opacity-75 h-full">
            <x-modal-header data-modal-hide="createuser">Create User</x-modal-header>
            <x-modal-body>
                <form method="post" class="mt-6 space-y-6"  action="{{ route('admin.createUser') }}">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full " :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email')" required autofocus autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name')" required autofocus autocomplete="company_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="text" class="mt-1 block w-full" :value="old('password')" required autofocus autocomplete="password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div class="mb-6">
                            <label for="admin" class="inline-flex items-center">
                                <input type="checkbox" name="admin" id="admin" value="0" class="form-checkbox">
                                <span class="ml-2">Admin?</span>
                            </label>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </x-modal-body>
        </x-modal>

        <x-modal id="deleteuser" class="bg-gray-500 bg-opacity-75 h-full">
            <x-modal-header data-modal-hide="deleteuser">Delete User</x-modal-header>
            <x-modal-body>
                <x-table>
                    <x-table-body>
                        @foreach($allusers as $user)

                            <x-tr>
                                <x-th class="border-b border-gray-300 w-full">
                                    <form method="post" action="{{ route('admin.destroyUser') }}">
                                        @csrf
                                        <input type="hidden" value={{ $user->id }} name="user_id">
                                        <button type="submit" class="w-full !text-gray-950 bg-transparent hover:text-blue-800 hover:bg-transparent focus:outline-none font-medium rounded-md text-sm px-4 py-2 transition-all duration-300 ease-in-out">
                                            <strong class="underline">{{Str::limit($user->name)}}</strong>
                                            <p class="text-gray-600">{{Str::limit($user->company_name,20)}}</p>
                                        </button>
                                    </form>
                                </x-th>
                            </x-tr>
                        @endforeach
                    </x-table-body>
                </x-table>
                {{$allusers->links()}}
            </x-modal-body>
        </x-modal>



    </div>
</div>
</x-app-layout>
