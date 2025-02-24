<?php  

return [
    'host' => env('MQTT_BROKER_HOST', 'excalibur.ioetec.com'),
    'port' => env('MQTT_BROKER_PORT', 1833),
    'username' => env('MQTT_BROKER_USERNAME', null),  
    'password' => env('MQTT_BROKER_PASSWORD', null), 
    'clean_session' => true,
];

?>