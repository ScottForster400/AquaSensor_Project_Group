<?php

namespace App\Http\Controllers;

use Psr\Log\LogLevel;
use Laravel\Pail\Options;
use App\Models\Sensor_Data;
use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use App\Jobs\MqttSubscriberJob;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;

use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Laravel\Reverb\Protocols\Pusher\Http\Controllers\Controller;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // MqttSubscriberJob::dispatch();


        $server = 'broker.hivemq.com';
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

        // Create an instance of a PSR-3 compliant logger. For this example, we will also use the logger to log exceptions.



            // Create a new instance of an MQTT client and configure it to use the shared broker host and port.
            $client = new MqttClient($server, $port, 'test-subscriber', MqttClient::MQTT_3_1, null);

            // Connect to the broker without specific connection settings but with a clean session.
            $client->connect($connectionSettings, true);

            // Subscribe to the topic 'foo/ba   r/baz' using QoS 0.
            $client->subscribe('foo/bar/baz', function (string $topic, string $message, bool $retained) use ($client) {
                Log::info('We received a {typeOfMessage} on topic [{topic}]: {message}', [
                    'topic' => $topic,
                    'message' => $message,
                    'typeOfMessage' => $retained ? 'retained message' : 'message',
                ]);

                // After receiving the first message on the subscribed topic, we want the client to stop listening for messages.
                $client->interrupt();
            }, MqttClient::QOS_AT_MOST_ONCE);

            // Since subscribing requires to wait for messages, we need to start the client loop which takes care of receiving,
            // parsing and delivering messages to the registered callbacks. The loop will run indefinitely, until a message
            // is received, which will interrupt the loop.
            $client->loop(true);

            // Gracefully terminate the connection to the broker.
            //$client->disconnect();
        // } catch (MqttClientException $e) {
        //     // MqttClientException is the base exception of all exceptions in the library. Catching it will catch all MQTT related exceptions.
        //     Log::error('Subscribing to a topic using QoS 0 failed. An exception occurred.', ['exception' => $e]);
        // }



        // $mqtt = MQTT::connection();
        // dd("client connected\n");
        // dd("client connected\n");

        // $mqtt->subscribe('sensor/sensor022', function ($topic, $message) {
        //     printf("Received message on topic [%s]: %s\n", $topic, $message);
        // }, 0);

        // for ($i = 0; $i< 10; $i++) {
        // $payload = array(
        //     'protocol' => 'tcp',
        //     'date' => date('Y-m-d H:i:s'),
        //     'url' => 'https://github.com/emqx/MQTT-Client-Examples'
        // );
        // $mqtt->publish(
        //     // topic
        //     'message/test',
        //     // payload
        //     json_encode($payload),
        //     // qos
        //     0,
        //     // retain
        //     true
        // );
        // printf("msg $i send\n");
        // sleep(1);
        // }
        // sleep(5);
        //$mqtt->loop(true);

        return view('data');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'data' => 'required|array'
        ]);
        //dd($request->data);
        $sensor_data = new sensor_data([
            'data' => $request->data

        ]);
        $sensor_data->save();
        return response()->json([
            'message' => 'successfully saved data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor_Data $sensor_Data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor_Data $sensor_Data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor_Data $sensor_Data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor_Data $sensor_Data)
    {
        //
    }
}
