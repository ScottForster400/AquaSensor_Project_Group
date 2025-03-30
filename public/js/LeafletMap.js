var map = L.map('map').setView([54.0, -2.0], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
// const mtLayer = L.maptiler.maptilerLayer({
//     apiKey: key,
//     style: L.maptiler.MapStyle.STREETS, // optional
//   }).addTo(map);

console.log(window.OwnedSensors);

var SensorMarkers = [];

if (window.OwnedSensors){
    Object.keys(OwnedSensors).forEach(sensorId => {
        let sensor = OwnedSensors[sensorId];
        console.log(sensorId, sensor.temperature)
        SensorMarkers.push({
            SensorId: sensorId,
            Latitude: parseFloat(sensor.latitude),
            Longitude: parseFloat(sensor.longitude),
            Temperature: parseFloat(sensor.temperature),
            mglDissolvedOxygen: parseFloat(sensor.mglDissolvedOxygen),
            BodyOfWater: sensor.bodyOfWater
        })
    })
    console.log(SensorMarkers);
    SensorMarkers.forEach(function (location) {
        L.marker([location.Latitude, location.Longitude])
            .addTo(map)
            .bindPopup(`<b>Sensor ID:</b> ${location.SensorId} <br>
                <b>Temperature:</b> ${location.Temperature}°C <br>
                <b>Dissolved Oxygen (mg/L):</b> ${location.mglDissolvedOxygen} mg/L <br>
                <b>Body Of Water:</b> ${location.BodyOfWater}`);
    });
}

function showMap(){
    const renderedMap = document.getElementById('map-container')
    if (renderedMap.classList.contains('opacity-0')){
        renderedMap.classList.remove('opacity-0');

    }
    else{
        renderedMap.classList.add('opacity-0');
    }
}
