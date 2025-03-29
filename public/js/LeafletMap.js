var map = L.map('map').setView([54.0, -2.0], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
// const mtLayer = L.maptiler.maptilerLayer({
//     apiKey: key,
//     style: L.maptiler.MapStyle.STREETS, // optional
//   }).addTo(map);

console.log(window.OwnedSensors);
console.log(Array.isArray(window.OwnedSensors));

var SensorMarkers = [];

if (window.OwnedSensors){
    window.OwnedSensors.data.forEach(sensor => {
        SensorMarkers.push({
            SensorId: sensor.sensor_id,
            Latitude: parseFloat(sensor.latitude),
            Longitude: parseFloat(sensor.longitude),
        })
    });
    console.log(SensorMarkers);
    SensorMarkers.forEach(function (location) {
        L.marker([location.Latitude, location.Longitude])
            .addTo(map)
            .bindPopup(`<b>${location.SensorId}</b>`);
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
