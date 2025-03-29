<script defer>
    const sensors = {!! json_encode($selectedSensors) !!};
    console.dir(sensors);
    sensors.forEach(sensor => {
        const currentSensor = document.getElementById(sensor);
        currentSensor.checked = true;
    });
</script>
