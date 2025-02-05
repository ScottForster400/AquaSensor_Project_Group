function showTemp(){
    var DO = document.getElementById('DO-data');
    DO.style.display = 'none';
    var temperature = document.getElementById('temp-data');
    temperature.style.display = 'flex';
}

function showDO(){
    var temperature = document.getElementById('temp-data');
    temperature.style.display = 'none';
    var DO = document.getElementById('DO-data');
    DO.style.display = 'flex';
}
