if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        console.log("latitude: " + latitude + " longitude: " + longitude);
    })
}

const suggestionsLists = document.getElementById('suggestions-list');

if (!suggestionsLists) {
    console.error('suggestions-list element not found!');
} else {
    console.log('suggestions-list element is available');
}


const suggestions = [];

if (window.SensorsJS) {
    window.SensorsJS.forEach(sensor => {
        suggestions.push(sensor.sensor_id.toString());  // Ensure sensor_id is a string for searching
    });
}

console.log(suggestions);  // Check if the suggestions array is receiving data correctly

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
    console.log('Selected:', suggestion);
}

// Close the suggestions list if clicking outside the search bar or the suggestions
document.addEventListener('click', (event) => {
    if (!searchBar.contains(event.target) && !suggestionsList.contains(event.target)) {
        suggestionsList.classList.add('hidden'); 
    }
});

// Ensure the suggestions open when user focuses on the search bar
searchBar.addEventListener('focus', openSuggestions);
