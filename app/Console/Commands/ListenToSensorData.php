<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\sensorListenService;
use App\Models\Sensor_Data;
use PhpMqtt\Client\MqttClient;

class ListenToSensorData extends Command
{
    protected $signature = 'sensor:listen-all';
    protected $description = 'Listen to all sensor data and update the database in real-time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {   
            // Connect to the MQTT broker
            $mqtt = new MqttClient(
                env('MQTT_BROKER_HOST'),
                env('MQTT_BROKER_PORT'), 
                uniqid('sensor_')
            );
            
    
            $mqtt->connect();
    
            // Subscribe to all sensor topics
            $mqtt->subscribe('sensor/#', function ($topic, $message) {
                // Extract the sensorId from the topic
                $sensorId = substr($topic, strpos($topic, '/') + 1); 
    
                // Decode the sensor data
                $sensorData = json_decode($message, true);
    
                // Save the sensor data to the database
                Sensor_Data::create([
                    'sensor_id' => $sensorId,
                    'sensor_data_date' => now(),
                    'dissolved_oxygen' => $sensorData['dissolved_oxygen'],
                    'temperature' => $sensorData['temperature'],
                ]);
    
                echo "Data saved for sensor $sensorId: ";
                print_r($sensorData);
            });

        $mqtt->loop(); // Start listening for messages
    }
}
