if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var UserLatitude = position.coords.latitude;
        var UserLongitude = position.coords.longitude;

        const Radius = 6371;
        let SensorDictionary = new Map();
        if (window.SensorsJS){
            window.SensorsJS.forEach(sensor => {
                var SensorLatitude = sensor.latitude;
                var SensorLongitude = sensor.longitude;
                const dLat = (SensorLatitude - UserLatitude) * (Math.PI / 180);
                const dLon = (SensorLongitude - UserLongitude) * (Math.PI / 180);

                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(UserLatitude * (Math.PI / 180)) * Math.cos(SensorLatitude * (Math.PI / 180)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);

                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                let Distance = Radius * c;
                let roundedDistance = Number(Distance.toFixed(2));
                SensorDictionary.set(sensor.sensor_id, [roundedDistance, sensor.body_of_water])
            });
        }
        let SortedSensorDictionary = new Map([...SensorDictionary.entries()].sort((a, b) => a[1][0] - b[1][0]));
        let ClosestSensorID = SortedSensorDictionary.keys().next().value;
        const suggestions = [];

        SortedSensorDictionary.forEach((value, key) => {
            let SortedSensor = key.toString() + ", " + value[0].toString() + "km, " + value[1].toString();
            suggestions.push(SortedSensor);
        });

        const searchBar = document.getElementById('search-bar');
        const suggestionsList = document.getElementById('suggestions-list');
        const ClosestSensorButton = document.getElementById('ClosestSensorButton');
        
        ClosestSensorButton.onclick = () => {
            searchBar.value = ClosestSensorID;
            document.getElementById('SearchBarForm').submit();
        }

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
            let sensorId = suggestion.split(",")[0]; // Get the ID part
            searchBar.value = sensorId;  // Set only the Sensor ID in the search bar
            suggestionsList.classList.add('hidden');  // Hide the suggestions
        }


        // Close the suggestions list if clicking outside the search bar or the suggestions
        document.addEventListener('click', (event) => {
            if (!searchBar.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.classList.add('hidden');
            }
        });

        // Ensure the suggestions open when user focuses on the search bar
        searchBar.addEventListener('focus', openSuggestions);
    })
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
        searchBar.value = suggestion;  // Set the search bar to the selected suggestion
        suggestionsList.classList.add('hidden');
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





