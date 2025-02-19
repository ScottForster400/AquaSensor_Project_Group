if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        console.log("latitude: " + latitude + " longitude: " + longitude);
    })
}


// placeholder data
const suggestions = [
    'Apple',
    'Banana',
    'Orange',
    'Grapes',
    'Peach',
    'Pear',
    'Plum',
    'Watermelon',
    'Strawberry',
    'Pineapple'
  ];
  
  const searchBar = document.getElementById('search-bar');
  const suggestionsList = document.getElementById('suggestions-list');
  
  function openSuggestions() {
    suggestionsList.classList.remove('hidden');
    filterSuggestions(); 
  }
  
  function filterSuggestions() {
    const query = searchBar.value.toLowerCase();
    const filteredSuggestions = suggestions.filter(item => item.toLowerCase().includes(query));
  
    suggestionsList.innerHTML = '';
  
    filteredSuggestions.slice(0, 5).forEach(suggestion => {
      const listItem = document.createElement('li');
      listItem.textContent = suggestion;
      listItem.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-gray-100');
      listItem.onclick = () => handleSelection(suggestion);
      suggestionsList.appendChild(listItem);
    });
  
    if (filteredSuggestions.length === 0) {
      suggestionsList.classList.add('hidden');
    }
  }
  
  function handleSelection(suggestion) {
    searchBar.value = suggestion;
    suggestionsList.classList.add('hidden'); 
    console.log('Selected:', suggestion);
  }
  
  document.addEventListener('click', (event) => {
    if (!searchBar.contains(event.target) && !suggestionsList.contains(event.target)) {
      suggestionsList.classList.add('hidden'); 
    }
  });
  