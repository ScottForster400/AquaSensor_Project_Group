<?php

namespace App\Http\Controllers;

use App\Models\Sensor_Data;
use App\Models\Sensor;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = null;
        $sensorCount = Count(Sensor::where('opensource', 1)->where('activated', 1)->get());
        $curl = curl_init();
        $apiURL = 'https://api.aquasensor.co.uk/aq.php?op=readings&username=shu&token=aebbf6305f9fce1d5591ee05a3448eff&sensorid=';

        if ($sensorCount > 0) {
            // Mats special code
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            if (array_key_exists('sensor_id', $_REQUEST)) {
                $apiURL .= $_REQUEST['sensor_id'];
            } else {
                $allSensors = Sensor::where('opensource', 1)->where('activated', 1)->get();
                $randomSensors = $allSensors[random_int(0, count($allSensors) -1)];
                $apiURL .= "sensor022";
                //$apiURL .= $randomSensors->sensor_id;
            }

            //gets api data
            curl_setopt_array($curl, array(
                    CURLOPT_URL => $apiURL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            //gets rid of the \n on the new lines to allow iteration
            $response = rtrim($response, "\n");
            $rows = explode("\n", $response);

            //cleans up any extra newlines if the trim didnt work.
            //https://www.php.net/manual/en/function.array-filter.php
            $rows = array_filter($rows, function ($row) {
                return !empty(trim($row));
            });
            $rows = array_values($rows);

            //converts to array.
            $data = array_map('str_getcsv', $rows);

            //removes headers as first array entry
            array_shift($data);
            $temp=2;
            $do=3;
            $date=0;
            $time=1;
            $mobileAveragedData = collect([collect(), collect(), collect(), collect()]);
            $averagedData = collect([collect(), collect(), collect(), collect()]);
            
            $averageCount = 700;
            $mobileAverageCount = 2000;
            $dataLength = count($data)/$averageCount;
            $mobileData = $data;
            $MobileDataLength = count($data)/$mobileAverageCount;
            for ($i = 0; $i < $MobileDataLength; $i++) {
                $averageTempData = 0;
                $averageDoData = 0;

                $dataAverager = array_splice($mobileData, 0, $mobileAverageCount);
                for ( $j = 0; $j < count($dataAverager); $j++) {
                    $averageTempData += $dataAverager[$j][$temp];
                    $averageDoData += $dataAverager[$j][$do];
                }
                $mobileAveragedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3, '.', ''));
                $mobileAveragedData[$do]->push(number_format($averageDoData/count($dataAverager), 3, '.', ''));
                $datetime = $dataAverager[0][$date] . " " . $dataAverager[0][$time];
                $mobileAveragedData[$date]->push($datetime);
                $mobileAveragedData[$time]->push($dataAverager[0][$time]);
            }

            for ($i = 0; $i < $dataLength; $i++) {
                $averageTempData = 0;
                $averageDoData = 0;

                $dataAverager = array_splice($data, 0, $averageCount);
                for ( $j = 0; $j < count($dataAverager); $j++) {
                    $averageTempData += $dataAverager[$j][$temp];
                    $averageDoData += $dataAverager[$j][$do];
                }
                $averagedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3, '.', ''));
                $averagedData[$do]->push(number_format($averageDoData/count($dataAverager), 3, '.', ''));
                $datetime = $dataAverager[0][$date] . " " . $dataAverager[0][$time];
                $averagedData[$date]->push($datetime);
                $averagedData[$time]->push($dataAverager[0][$time]);
            }

            return view('data',[$mobileAveragedData, $averagedData]);
        }
        else{
            return view('data');
        }


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
        //
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
