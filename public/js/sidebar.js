

function sidebarToggle(){
    const sidebar = document.getElementById('sidebar-cont')
    sidebar.classList.toggle('sb-active')
}
function openSource() {
    const toggle = document.getElementById('openSourceToggle')
    const openSourceSensors = document.querySelectorAll('.openSource');
    if (toggle.checked){
        openSourceSensors.forEach(sensor => {

            sensor.checked = true
        });
    }
    else{
        openSourceSensors.forEach(sensor => {
            sensor.checked = false
        });
    }
  }
  function mySensors() {
    const toggle = document.getElementById('mySensorsToggle')
    const mySensors = document.querySelectorAll('.mySensor');
    if (toggle.checked){
        mySensors.forEach(sensor => {
            sensor.checked = true
        });
    }
    else{
        mySensors.forEach(sensor => {
            sensor.checked = false
        });
    }
  }
