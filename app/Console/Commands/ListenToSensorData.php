<?php

namespace App\Console\Commands;

use App\Models\Sensor_Data;
use PhpMqtt\Client\MqttClient;
use Illuminate\Console\Command;
use App\Services\sensorListenService;
use PhpMqtt\Client\ConnectionSettings;

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
        $server = '	broker.hivemq.com.com';
        $port = 1883;
        $clientId = rand(1,100000);
        $username = null;
        $password = null;
        $clean_session = true;
        $mqtt_version = MqttClient::MQTT_3_1;

        $connectionSettings = (new ConnectionSettings)
            ->setConnectTimeout(10)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setKeepAliveInterval(60);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        $mqtt->connect($connectionSettings, $clean_session);
        printf("client connected\n");

        $mqtt->subscribe('#', function ($topic, $message) {
            printf("Received message on topic [%s]: %s\n", $topic, $message);
            // Save the message to the database
        }, 0);

        $mqtt->loop(true);
    }
}
