@php
    use App\Models\Sensor;

    $Sensors = Sensor::where('opensource', 1)->where('activated', 1)->get();
@endphp

<script>
    var allSensorMaps = [];

    //var Sensors{!! json_encode($Sensors->toArray()) !!};
    //console.dir(Sensors.length);

    for (let i = 0; i < 5; i++) {
        console.dir(i);
        var sensorLocation = L.map('map').setView([51.505, -0.09], 13); //.Sensors[i]

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(sensorLocation);

        sensorLocation.locate({setView: true, maxZoom: 16});

        function onLocationFound(location) {
            var radius = location.accuracy;
            L.marker(location.latlng).addTo(sensorLocation).bindPopup("You are within " + radius + " meters from this point").openPopup();
            L.circle(location.latlng, radius).addTo(sensorLocation);
        }

        sensorLocation.on('locationfound', onLocationFound);

        function onLocationError(error) {
            alert(error.message);
        }

        sensorLocation.on('locationerror', onLocationError);

        console.dir(sensorLocation);
        allSensorMaps[i] = sensorLocation;
    }

    function mapModalOpen() {
        console.dir(allSensorMaps.length);
        for (let i = 0; i < allSensorMaps.length; i++) {
            allSensorMaps[i].invalidateSize()
            console.dir(i);
        }
    }
</script>