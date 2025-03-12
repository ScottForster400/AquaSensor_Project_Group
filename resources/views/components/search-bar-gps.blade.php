<div class="relative w-full ">
    <a  type="button" class="absolute inset-y-0 start-0 flex items-center justify-center w-10 h-10 z-50">
        <svg class="w-3/5 h-3/5" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 4V1.5M4 14H1.5M14 24V26.5M24 14H26.5M23.375 14C23.375 19.1777 19.1777 23.375 14 23.375C8.82233 23.375 4.625 19.1777 4.625 14C4.625 8.82233 8.82233 4.625 14 4.625C19.1777 4.625 23.375 8.82233 23.375 14ZM17.75 14C17.75 16.0711 16.0711 17.75 14 17.75C11.9289 17.75 10.25 16.0711 10.25 14C10.25 11.9289 11.9289 10.25 14 10.25C16.0711 10.25 17.75 11.9289 17.75 14Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
    <input type="search" id="search" name="search" class="z-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required {{$attributes->merge(['placeholder' => ''])}}/>
    <input type="search" class="z-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required {{$attributes->merge(['placeholder' => ''])}}/>
    <ul id="suggestions-list" class="absolute hidden left-1/2 transform -translate-x-1/2 mt-2 w-full max-h-64 overflow-y-auto border border-gray-300 bg-white rounded-lg shadow-lg z-50">
        @if ($Sensors && $Sensors->count() > 0)
            @foreach ($Sensors as $Sensor)
                <li class="px-4 py-2 hover:bg-gray-100">
                    <a href="#" class="text-sm text-gray-700">{{$Sensor->name}}</a>
                </li>
            @endforeach
        @else
            <li class="px-4 py-2 text-sm text-gray-500">No sensors found</li>
        @endif
    </ul>

    <button type="submit" class="absolute top-0 end-0 h-full p-2.5 text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
    </button>
</div>
