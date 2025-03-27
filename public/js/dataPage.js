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


document.getElementById("check").onchange= function()
{

if (document.getElementById("check").checked==true)
{
document.getElementById("check2").checked=true;
}

else if (document.getElementById("check").checked==false)
{
document.getElementById("check2").checked=false;
}
}

function desktopdaynight(){
    if (document.getElementById("check").checked==true)
        {
        document.getElementById("check").checked=false;
        document.getElementById("check2").checked=false;
        }

    else if (document.getElementById("check").checked==false)
        {
        document.getElementById("check").checked=true;
        document.getElementById("check2").checked=true;
        }
}
