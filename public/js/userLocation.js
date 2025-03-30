
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var UserLatitude = position.coords.latitude;
        var UserLongitude = position.coords.longitude;

        const Radius = 6371;
        let SensorArray = [];

        if (window.SensorsJS) {
            window.SensorsJS.forEach(sensor => {
                var SensorLatitude = parseFloat(sensor.latitude);
                var SensorLongitude = parseFloat(sensor.longitude);

                // Calculate distance using Haversine formula
                const dLat = (SensorLatitude - UserLatitude) * (Math.PI / 180);
                const dLon = (SensorLongitude - UserLongitude) * (Math.PI / 180);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(UserLatitude * (Math.PI / 180)) * Math.cos(SensorLatitude * (Math.PI / 180)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                let Distance = Radius * c;
                let roundedDistance = Number(Distance.toFixed(2));

                SensorArray.push({
                    sensor_id: sensor.sensor_id,
                    sensor_name: sensor.sensor_name,
                    body_of_water: sensor.body_of_water,
                    roundedDistance: roundedDistance
                });
            });
        }

        // Sort sensors by distance (ascending)
        SensorArray.sort((a, b) => a.roundedDistance - b.roundedDistance);

        // Get the closest sensor's ID
        let ClosestSensorID = SensorArray.length > 0 ? SensorArray[0].sensor_id : null;

        const searchBar = document.getElementById('search-bar');
        const suggestionsList = document.getElementById('suggestions-list');
        const ClosestSensorButton = document.getElementById('ClosestSensorButton');

        // Set closest sensor when button is clicked
        if (ClosestSensorButton && ClosestSensorID) {
            ClosestSensorButton.onclick = () => {
                searchBar.value = ClosestSensorID;
                document.getElementById('SearchBarForm').submit();
            }
        }

        // Function to open suggestions when search bar is clicked
        function openSuggestions() {
            suggestionsList.classList.remove('hidden');
            updateSuggestions();
        }

        // Function to filter and display suggestions
        function updateSuggestions() {
            const query = searchBar.value.toLowerCase();
            const filteredSensors = SensorArray.filter(sensor => 
                sensor.sensor_name.toLowerCase().includes(query) || 
                sensor.body_of_water.toLowerCase().includes(query)
            );

            suggestionsList.innerHTML = '';  // Clear previous suggestions

            filteredSensors.slice(0, 5).forEach(sensor => {
                const listItem = document.createElement('li');
                listItem.textContent = `${sensor.sensor_name} - ${sensor.roundedDistance} km - ${sensor.body_of_water}`;
                listItem.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-gray-100');

                // Fill search bar with sensor_id when clicked
                listItem.onclick = () => handleSelection(sensor.sensor_id);
                suggestionsList.appendChild(listItem);
            });

            if (filteredSensors.length === 0) {
                suggestionsList.classList.add('hidden');
            }
        }

        // Handles clicking a suggestion
        function handleSelection(sensorId) {
            searchBar.value = sensorId;
            suggestionsList.classList.add('hidden');
            document.getElementById('SearchBarForm').submit();
        }

        // Hide suggestions if clicking outside
        document.addEventListener('click', (event) => {
            if (!searchBar.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.classList.add('hidden');
            }
        });

        // Show suggestions when user focuses on the search bar
        searchBar.addEventListener('focus', openSuggestions);
    });
} else {
    const suggestions = [];

    if (window.SensorsJS) {
        window.SensorsJS.forEach(sensor => {
            suggestions.push(sensor.sensor_id.toString());  // Ensure sensor_id is a string for searching
        });
    }

    const searchBar = document.getElementById('search-bar');
    const suggestionsList = document.getElementById('suggestions-list');

    // Show suggestions when search bar is clicked by the user
    function openSuggestions() {
        suggestionsList.classList.remove('hidden');
        filterSuggestions();
    }

    function filterSuggestions() {
        const query = searchBar.value.toLowerCase();
        const filteredSuggestions = suggestions.filter(item => item.toLowerCase().includes(query));

        suggestionsList.innerHTML = '';  // Clear the suggestions list

        filteredSuggestions.slice(0, 5).forEach(suggestion => {
            const listItem = document.createElement('li');
            listItem.textContent = suggestion;  // Show the sensor_id as suggestion
            listItem.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-gray-100');
            listItem.onclick = () => handleSelection(suggestion);
            suggestionsList.appendChild(listItem);
        });

        if (filteredSuggestions.length === 0) {
            suggestionsList.classList.add('hidden');
        }
    }

    function handleSelection(suggestion) {
        let sensorId = suggestion.split(",")[0];
        searchBar.value = sensorId;  // Set the search bar to the selected suggestion
        suggestionsList.classList.add('hidden');
        document.getElementById('SearchBarForm').submit();
    }

    // Close the suggestions list if clicking outside the search bar or the suggestions
    document.addEventListener('click', (event) => {
        if (!searchBar.contains(event.target) && !suggestionsList.contains(event.target)) {
            suggestionsList.classList.add('hidden');
        }
    });

    // Ensure the suggestions open when user focuses on the search bar
    searchBar.addEventListener('focus', openSuggestions);
}





