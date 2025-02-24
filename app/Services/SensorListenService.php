<?php  

namespace App\Services;

use PhpMqtt\Client\MqttClient;

class sensorListenService
{
    protected $mqtt;

    public function __construct(MqttClient $mqttClient)
    {
        $this->mqtt = $mqttClient;
    }

    public function listenToSensorData($sensorId)
    {
        $this->mqtt->connect();

        //sets the topic to listen for data
        $topic = "sensor/{$sensorId}";

        $this->mqtt->subscribe($topic, function ($topic, $message) {
            // Decodes data from the sensor
            $sensorData = json_decode($message, true);
            echo "Received data from $topic: ";
            // Test for displaying received data
            print_r($sensorData); 
        });

        $this->mqtt->loop(); // Start listening for data from the sensor to grab it in real time
    }
}

?>