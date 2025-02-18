if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        console.log("latitude: " + latitude + " longitude: " + longitude);
    })
}