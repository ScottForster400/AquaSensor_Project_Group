<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sensor;
use App\Models\Sensor_Data;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sensorCount = Count(Sensor::where('opensource', 1)->where('activated', 1)->get());

        if ($sensorCount > 0) {
            if (array_key_exists('sensor_id', $_REQUEST)) {
                $activeSensor = $_REQUEST['sensor_id'];
                $data = $this->GetAndFormatCurl($activeSensor);
                $sensor_id = $_REQUEST['sensor_id'];
            } else {
                $allSensors = Sensor::where('opensource', 1)->where('activated', 1)->get();
                $randomSensors = $allSensors[random_int(0, count($allSensors) -1)];
                $sensor_id = $randomSensors->sensor_id;
                $activeSensor = "sensor022";
                $data = $this->GetAndFormatCurl($activeSensor);
            }

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
            $mobileDataLength = count($data)/$mobileAverageCount;
            for ($i = 0; $i < $mobileDataLength; $i++) {
                $averageTempData = 0;
                $averageDoData = 0;

                $dataAverager = array_splice($mobileData, 0, $mobileAverageCount);

                for ( $j = 0; $j < count($dataAverager); $j++) {
                    if ($dataAverager[$j][$temp] >= -30 && $dataAverager[$j][$temp] <= 120 && $dataAverager[$j][$do] >= 0 && $dataAverager[$j][$do] <= 65) {
                        $averageTempData += $dataAverager[$j][$temp];
                        $averageDoData += $dataAverager[$j][$do];
                    } else {
                        array_splice($dataAverager, $j, 1);
                    }
                }
                $mobileAveragedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3, '.', ''));
                $mobileAveragedData[$do]->push(number_format($averageDoData/count($dataAverager), 3, '.', ''));
                $mobileAveragedData[$date]->push($dataAverager[0][$date] . " - " . $dataAverager[count($dataAverager)-1][$date]);
                $mobileAveragedData[$time]->push($dataAverager[0][$time]);
            }


            for ($i = 0; $i < $dataLength; $i++) {
                $averageTempData = 0;
                $averageDoData = 0;

                $dataAverager = array_splice($data, 0, $averageCount);
                for ( $j = 0; $j < count($dataAverager); $j++) {
                    if ($dataAverager[$j][$temp] >= -30 && $dataAverager[$j][$temp] <= 120 && $dataAverager[$j][$do] >= 0 && $dataAverager[$j][$do] <= 65) {
                        $averageTempData += $dataAverager[$j][$temp];
                        $averageDoData += $dataAverager[$j][$do];
                    } else {
                        array_splice($dataAverager, $j, 1);
                    }
                }
                $averagedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3));
                $averagedData[$do]->push(number_format($averageDoData/count($dataAverager), 3));
                $averagedData[$date]->push($dataAverager[0][$date] . " - " . $dataAverager[count($dataAverager)-1][$date]);
                $averagedData[$time]->push($dataAverager[0][$time]);
            }


            $flipCardData = [
                $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y') . "&todate=" . date('d-m-y')),
                $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y', strtotime('-'.(string)(date('w')-1).' days')) . "&todate=" . date('d-m-y')),
                $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y', strtotime('-'.(string)(date('j')-1).' days')) . "&todate=" . date('d-m-y'))
            ];
            $averagedFlipData = [[0, 0, 0], [0, 0, 0]];
            for ($i= 0; $i<count($flipCardData); $i++) {
                $tempAverager = 0;
                $doAverager = 0;
                for ($j= 0; $j<count($flipCardData); $j++) {
                    $tempAverager += $flipCardData[$i][$j][$temp];
                    $doAverager += $flipCardData[$i][$j][$do];
                }
                $averagedFlipData[0][$i] = number_format($tempAverager/count($flipCardData[$i][$j]), 3);
                $averagedFlipData[1][$i] = number_format($doAverager/count($flipCardData[$i][$j]), 3);
            }

            $currentSensorData = Sensor_Data::where('sensor_id',$sensor_id)->first();
            $currentSensor = Sensor::where('sensor_id', $sensor_id)->first();


            // $dt = Carbon::now();
            // $weekDay = $dt->englishDayOfWeek();

            return view('data')->with('mobileAveragedData',$mobileAveragedData)->with('desktopAveragedData',$averagedData)->with('flipCardData', $averagedFlipData)->with('currentSensorData',$currentSensorData)->with('currentSensor',$currentSensor);
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

    private function GetAndFormatCurl($search) {
        $apiURL = 'https://api.aquasensor.co.uk/aq.php?op=readings&username=shu&token=aebbf6305f9fce1d5591ee05a3448eff&sensorid=';
        $curlOptions = array(
            CURLOPT_URL => $apiURL . $search,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        );
        $response = null;
        $curl = curl_init();
        // Mats special code
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //gets api data
        curl_setopt_array($curl, $curlOptions);

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
        return $data;
    }
}
