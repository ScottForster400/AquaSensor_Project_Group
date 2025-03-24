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
    <script defer>
        // var myChart = echarts.init(document.getElementById('graph-temp'), null,{

        // })
        // window.addEventListener('resize', function() {
        //     myChart.resize();
        // });
        // document.addEventListener('DOMContentLoaded',function () {
        //     setTimeout(myChart.resize(),4000)
        //     console.dir('qewiugfuiewgfiuewgfiuebgwifebgwyulfvwaiylfvbwylvfLWBVFLHEWV')
        // })

        // // Draw the chart
        // option = {
        //     xAxis: {
        //         type: 'category',
        //         data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        //     },
        //     yAxis: {
        //         type: 'value'
        //     },
        //     grid:{
        //         height:"60%",
        //         width: "80%"
        //     },
        //     series: [
        //         {
        //         data: [820, 932, 901, 934, 1290, 1330, 1320],
        //         type: 'line',
        //         smooth: true
        //         }
        //     ]
        // };
        // myChart.setOption(option);
        Chart.defaults.elements.bar.borderWidth = 0;
        const  bu = {!! json_encode($tempDa) !!}
        console.dir(bu)
        const data = {
            labels: bu,
            datasets: [{
                pointHitRadius: 20,
                type: 'line',
                label: 'Temp: °C',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgb(255, 99, 132)',
                data: bu,
            },{
                pointHitRadius: 20,
                type: 'line',
                label: 'DO: (mg/L)',
                backgroundColor: 'rgb(110, 99, 255,0.5)',
                borderColor: 'rgb(110, 99, 255)',
                data: bu,
            }]
        };
        const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            //aspectRatio:1,
            maintainAspectRatio: false,
            elements:{
                point:{
                    radius:0
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
                        maxRotation: 90,
                        minRotation: 90
                    }
                }
            },
            hover: {  // <-- to add
                mode: 'nearest'
                },
            tooltips: {
                mode: 'nearest',
                intersect: true
            },
            interaction: {
                mode: 'nearest'
            }

        }
        };

        const myChart = new Chart(
        document.getElementById('tempChart'),
        config // We'll add the configuration details later.
        );
    </script>
</x-app-layout>
