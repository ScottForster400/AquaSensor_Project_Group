<?php

namespace App\Http\Controllers;

use Laravel\Pail\Options;
use App\Models\Sensor_Data;
use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use App\Jobs\MqttSubscriberJob;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\ConnectionSettings;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // MqttSubscriberJob::dispatch();







        $mqtt = MQTT::connection();
        dd("client connected\n");
        dd("client connected\n");

        $mqtt->subscribe('message/test', function ($topic, $message) {
            printf("Received message on topic [%s]: %s\n", $topic, $message);
        }, 0);

        for ($i = 0; $i< 10; $i++) {
        $payload = array(
            'protocol' => 'tcp',
            'date' => date('Y-m-d H:i:s'),
            'url' => 'https://github.com/emqx/MQTT-Client-Examples'
        );
        $mqtt->publish(
            // topic
            'message/test',
            // payload
            json_encode($payload),
            // qos
            0,
            // retain
            true
        );
        printf("msg $i send\n");
        sleep(1);
        }
        sleep(5);
        $mqtt->loop(true);

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
