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
function flipCard(item){

    if(item.classList.contains("my-rotate-y-180")){
        item.classList.remove("my-rotate-y-180")
    }
    else{
        item.classList.add("my-rotate-y-180")
    }
}
