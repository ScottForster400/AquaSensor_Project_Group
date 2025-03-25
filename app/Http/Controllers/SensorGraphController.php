<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Sensor_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Include_;
use PHPUnit\TextUI\Configuration\Php;

class SensorGraphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd($request);
        $temp=2; //setup values
        $do=3;
        $date=0;
        $time=1;
        $visableSensors = 0;

        //get important database values
        $bodysOfwater = Sensor::select('body_of_water')->where('opensource',1)->orderBy('body_of_water')->distinct()->get();
        $allSensors = Sensor_Data::select('sensor_id')->get();
        $visableSensors = Sensor::where('activated',1)->where('opensource',1)->get();

        if(Auth::user() != null) { //if user logged in
            $ownedSensorsWithData=Sensor::whereIn('sensor_id',$allSensors)->where('user_id',Auth::id())->where('activated',1)->get();
        }

        $selectedSensor = 'sensor022';
        if ($request->query() != null) {
            if ($_REQUEST['start'] != null && $_REQUEST['end'] != null) {
                //do time constrain stuffs
            }
            for ($k = 0; $k < count($visableSensors); $k++) {
                if (isset($_REQUEST[$visableSensors[$k]['sensor_id']])) {
                    $selectedSensor = $visableSensors[$k]['sensor_id'];
                }
            }
            if (Auth::user() != null) {
                for ($k = 0; $k < count($ownedSensorsWithData); $k++) {
                    if (isset($_REQUEST[$ownedSensorsWithData[$k]['sensor_id']])) {
                        $selectedSensor = $ownedSensorsWithData[$k]['sensor_id'];
                    }
                }
            }
        }

        $data = $this->GetAndFormatCurl($selectedSensor); //get sensor info
        $filterdData = [collect(), collect(), collect(), collect()];
        for ($i = 0; $i < count($data); $i++) { //for all the data
            if ($data[$i][$temp] > 0 && $data[$i][$temp] <= 40 && $data[$i][$do] > 0 && $data[$i][$do] <= 65) { //filter it
                $filterdData[$date]->push($data[$i][$date]); //store it in a quad list array
                $filterdData[$time]->push($data[$i][$time]);
                $filterdData[$temp]->push($data[$i][$temp]);
                $filterdData[$do]->push($data[$i][$do]);
            }
        }

        if (Auth::user() != null) { //if logged in pass owned sensors too
            return view('sensor_data')
                ->with('sensors',$visableSensors)
                ->with('bodyOfWater',$bodysOfwater)
                ->with('ownedSensors',$ownedSensorsWithData)
                ->with('temperature',$filterdData[$temp])
                ->with('date',$filterdData[$date])
                ->with('disolvedO2',$filterdData[$do]);
        }
        return view('sensor_data') //else just send the rest of the data
            ->with('sensors',$visableSensors)
            ->with('bodyOfWater',$bodysOfwater)
            ->with('temperature',$filterdData[$temp])
            ->with('date',$filterdData[$date])
            ->with('disolvedO2',$filterdData[$do]);
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
