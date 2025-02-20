<script>
    const tempJson = {!! json_encode($tempData->toArray()) !!};
    const doJson = {!! json_encode($doData->toArray()) !!};
    const dateJson = {!! json_encode($dateData->toArray()) !!};
    console.dir(tempJson);

    const data = {
    labels: dateJson,
    datasets: [{
        pointHitRadius: 20,
        type: 'line',
        label: 'Temp: °C',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgb(255, 99, 132)',
        data: tempJson,
    },{
        pointHitRadius: 20,
        type: 'line',
        label: 'DO: (mg,L)',
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

    const dataTemp = {
    labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15'],
    datasets: [{
        pointHitRadius: 20,
        type: 'line',
        label: 'Temp: °C',
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgb(255, 99, 132)',
        data: [-10,1,6,14,12,10,7,5,9,4,14,9,18,4,3],
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
    labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15'],
    datasets: [{
        pointHitRadius: 20,
        type: 'line',
        label: 'DO (mg,L)',
        backgroundColor: 'rgb(110, 99, 255,0.5)',
        borderColor: 'rgb(110, 99, 255)',
        data: [20,12,6,15,10,10,7,12,20,4,14,9,13,12,3],
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
