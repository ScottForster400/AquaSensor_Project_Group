<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $currentRoute = Route::currentRouteName();

        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <link rel="stylesheet" href="{{ asset('/css/waves/waves.css') }}"/>

        <link rel="stylesheet" href="{{ asset('/css/sidebar.css') }}"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @if($currentRoute =="sensorData.index")
            <script src="{{ asset('/js/dataPage.js') }} " defer></script>
            {{-- <script src="{{asset('/js/charts.js')}}" defer></script> --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            {{-- <script src="path/to/chartjs/dist/chart.min.js"></script> --}}
            <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
            {{-- <script src="path/to/chartjs-plugin-zoom/dist/chartjs-plugin-zoom.min.js"></script> --}}
            <link rel="stylesheet" href="{{ asset('/css/daynight/daynight.css') }}"/>
        @endif
        @if ($currentRoute =="sensor_data.index")
            <script src="{{ asset('/js/sidebar.js') }} " defer></script>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.6.0/dist/echarts.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/dygraphs@2.2.1/dist/dygraph.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/dygraphs@2.2.1/dist/dygraph.min.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script src="https://cdn.maptiler.com/maptiler-sdk-js/v3.0.1/maptiler-sdk.umd.min.js"></script>
        <link href="https://cdn.maptiler.com/maptiler-sdk-js/v3.0.1/maptiler-sdk.css" rel="stylesheet" />
        <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v4.0.2/leaflet-maptilersdk.umd.min.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
