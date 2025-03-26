<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data') }}
        </h2>
    </x-slot>

    <div class=" flex flex-row w-full h-screen max-sm:max-h-1/2">

        @include('layouts.sidebar')
        <div class="py-0 flex justify-center basis-11/12 z-10 pb-1">
            <div class="flex items-center justify-center flex-col  mx-auto sm:px-6 lg:px-8 w-full z-10 h-80 pt-4">


                <x-card class="mb-2 !px-4  z-10 h-80 pt-4">
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
        
        // temp = 0  do = 1
        Chart.defaults.elements.bar.borderWidth = 0;
        console.dir({!!$data!!})
        console.dir({!!$dates!!})
        var sensorData = {!! json_encode($data) !!}
        var tempSensorLine = [];
        var doSensorLine = [];
        for (var i = 0; i < {!! count($data) !!}; i++) {
            const color = [Math.random()*255, Math.random()*255, Math.random()*255]
            tempSensorLine.push({pointHitRadius: 20,
                type: 'line',
                label: sensorData[i][2],
                backgroundColor: "rgba("+color[0]+", "+color[1]+", "+color[2]+", 0.5)",
                borderColor: 'rgba('+color[0]+', '+color[1]+', '+color[2]+')',
                data: sensorData[i][0]});

            doSensorLine.push({pointHitRadius: 20,
                type: 'line',
                label: sensorData[i][2],
                backgroundColor: "rgba("+color[0]+", "+color[1]+", "+color[2]+", 0.5)",
                borderColor: 'rgba('+color[0]+', '+color[1]+', '+color[2]+')',
                data: sensorData[i][1]});
        }
        const tempData = { 
            labels: {!! json_encode($dates) !!},
            datasets: tempSensorLine};
        const doData = { 
            labels: {!! json_encode($dates) !!},
            datasets: doSensorLine};


        const tempConfig = {
        type: 'line',
        data: tempData,
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

        const doConfig = {
        type: 'line',
        data: doData,
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

        const myTempChart = new Chart(
        document.getElementById('tempChart'),
        tempConfig // We'll add the configuration details later.
        );
        const myDoChart = new Chart(
        document.getElementById('doChart'),
        doConfig // We'll add the configuration details later.
        );
    </script>
</x-app-layout>
