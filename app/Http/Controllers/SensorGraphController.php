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
            $ownendSenorsWithData=Sensor::whereIn('sensor_id',$allSensors)->where('user_id',Auth::id())->where('activated',1)->get();
        }

        $data = $this->GetAndFormatCurl('sensor022');
        $filterdData = [collect(), collect(), collect(), collect()];
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i][$temp] >= -30 && $data[$i][$temp] <= 120 && $data[$i][$do] >= 0 && $data[$i][$do] <= 65) {
                $filterdData[$date]->push($data[$i][$date]);
                $filterdData[$time]->push($data[$i][$time]);
                $filterdData[$temp]->push($data[$i][$temp]);
                $filterdData[$do]->push($data[$i][$do]);
            }
        }

        if (Auth::user() != null) { //if logged in pass owned sensors too
            return view('sensor_data')
                ->with('sensors',$allSensors)
                ->with('bodyOfWater',$bodysOfwater)
                ->with('ownedSensors',$ownendSenorsWithData)
                ->with('temperature',$filterdData[$temp])
                ->with('date',$filterdData[$date])
                ->with('disolvedO2',$filterdData[$do]);
        }
        return view('sensor_data')
            ->with('sensors',$allSensors)
            ->with('bodyOfWater',$bodysOfwater)
            ->with('temperature',$filterdData[$temp])
            ->with('date',$filterdData[$date])
            ->with('disolvedO2',$filterdData[$do]);
        
        /*if(Auth::user() != null){
            $bodysOfwater =Sensor::select('body_of_water')->where('opensource',1)->orderBy('body_of_water')->distinct()->get();
            $sensors = Sensor::where('activated',1)->where('opensource',1)->where('user_id','!=',Auth::id())->get();
            $SensorIdsWithData =Sensor_Data::select('sensor_id')->get();
            $ownendSenorsWithData=Sensor::whereIn('sensor_id',$SensorIdsWithData)->where('user_id',Auth::id())->where('activated',1)->get();

            $data = $this->GetAndFormatCurl('sensor022');
            $tempDa = collect(); //setup
            for($i=0; $i < count($data); $i++){

                $wooo = $data[$i];

                $tempDa->push($wooo[2]); //save all temperature data
                // dump($tempDa);
            }
            for ( $j = 0; $j < count($tempDa); $j++) {
                if ($tempDa[$j]<= 10 && $tempDa[$j] >= 30) {

                }
                else {
                    $tempDa->splice($j,1); //remove anomolous data
                };
            }

            return view('sensor_data')->with('sensors',$sensors)->with('bodyOfWater',$bodysOfwater)->with('ownedSensors',$ownendSenorsWithData)->with('tempDa',$tempDa);
        }
        else{
            $bodysOfwater =Sensor::select('body_of_water')->where('opensource',1)->orderBy('body_of_water')->distinct()->get();
            $sensors = Sensor::where('activated',1)->where('opensource',1)->get();
            $data = $this->GetAndFormatCurl('sensor022');
            $tempDa = collect();
            for($i=0; $i < count($data); $i++){

                $wooo = $data[$i];

                $tempDa->push($wooo[2]);
                // dump($tempDa);
            }
            for ( $j = 0; $j < count($tempDa); $j++) {
                if ($tempDa[$j]<= 10 && $tempDa[$j] >= 30) {

                }
                else {
                    $tempDa->splice($j,1);
                };
            }

            return view('sensor_data')->with('sensors',$sensors)->with('bodyOfWater',$bodysOfwater)->with('tempDa',$tempDa);
        }*/
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
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
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
