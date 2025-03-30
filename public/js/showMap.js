function showMap(){
    console.dir("map");
    const renderedMap = document.getElementById('map-container')
    renderedMap.classList.remove('opacity-0');

}
function hideMap(){
    console.dir("map");
    const renderedMap = document.getElementById('map-container')
    renderedMap.classList.add('opacity-0');
}
