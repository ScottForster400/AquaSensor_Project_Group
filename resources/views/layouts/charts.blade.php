<script>
    Chart.defaults.font.size = 12;
    Chart.defaults.elements.bar.borderWidth = 0;
    const tempJson = {!! json_encode($mobileAveragedData[2]->toArray()) !!};
    const doJson = {!! json_encode($mobileAveragedData[3]->toArray()) !!};
    const dateJson = {!! json_encode($mobileAveragedData[0]->toArray()) !!};

    const tempHourJson = {!! json_encode($daysData[0]) !!};
    const doHourJson = {!! json_encode($daysData[1]) !!};
    const timeJson = {!! json_encode($daysLabel) !!};
    console.dir({!! json_encode($daysData) !!})
    console.dir(timeJson)

    const data = {
        labels: dateJson,
        datasets: [{
            pointHitRadius: 1000,
            type: 'line',
            label: 'Temp: °C',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgb(255, 99, 132)',
            data: tempJson,
        },{
            pointHitRadius: 1000,
            type: 'line',
            label: 'DO: (mg/L)',
            backgroundColor: 'rgb(110, 99, 255,0.5)',
            borderColor: 'rgb(110, 99, 255)',
            data: doJson,
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

    const dataTemp = {
    labels: timeJson,
    datasets: [{
        pointHitRadius: 1000,
        type: 'line',
        label: 'Temp: °C',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgb(255, 99, 132)',
        data: tempHourJson,
        radius: 0
    }]
    };
    const tempConfig = {
    type: 'line',
    data: dataTemp,
    options: {
        responsive: true,
        //aspectRatio:1,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
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
    const dataDO = {
    labels: timeJson,
    datasets: [{
        pointHitRadius: 1000,
        type: 'line',
        label: 'DO (mg,L)',
        backgroundColor: 'rgb(110, 99, 255,0.5)',
        borderColor: 'rgb(110, 99, 255)',
        data:doHourJson,
        radius: 0
    }]
    };
    const DOConfig = {
    type: 'line',
    data: dataDO,
    options: {
        events: ['mousemove'],
        responsive: true,
        //aspectRatio:1,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
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
    document.getElementById('myChart'),
    config // We'll add the configuration details later.
    );
    const tempChart = new Chart(
    document.getElementById('tempChart'),
    tempConfig // We'll add the configuration details later.
    );
    const DOChart = new Chart(
    document.getElementById('DOChart'),
    DOConfig // We'll add the configuration details later.
    );
</script>
