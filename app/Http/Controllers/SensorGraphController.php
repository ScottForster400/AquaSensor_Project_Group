<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Sensor_Data;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SensorGraphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        @ini_set('memory_limit','1000M');
        //dd($request);
        $ftemp = 0;
        $fdo = 1;
        $temp=2; //setup values
        $do=3;
        $date=0;
        $time=1;
        $visableSensors = 0;

        //get important database values
        $startDateRange = null; $endDateRange = null;
        $bodysOfwater = Sensor::select('body_of_water')->where('activated',1)->orderBy('body_of_water')->distinct()->get();
        $allSensors = Sensor_Data::select('sensor_id')->get();
        $visableSensors = Sensor::where('activated',1)->where('opensource',1)->where('user_id', '!=',  Auth::id())->get();

        if(Auth::user() != null) { //if user logged in
            $ownedSensorsWithData=Sensor::whereIn('sensor_id',$allSensors)->where('user_id',Auth::id())->where('activated',1)->get();
        }

        if ($request->query() != null) { //if theres been a query through
            $requestOutput = collect();
            foreach (array_keys($_REQUEST) as $requestPart) { //seperate out the individual sensors
                if ($requestPart != "_token" && $requestPart != "_method" && $requestPart != "waterBody" && $requestPart != "start" && $requestPart != "end") {
                    $requestOutput->push($requestPart);
                }
            }

            if ($_REQUEST['start'] != null && $_REQUEST['end'] != null) { //tbd
                $startDateRange = $_REQUEST['start'];
                $endDateRange = $_REQUEST['end'];
            }
            
            if (count($requestOutput) > 0 || $_REQUEST['waterBody'] != "None") { //if theres a sensor selection
                if ($_REQUEST['waterBody'] != "None") { //if its water body
                    $databaseSearch = Sensor::select('sensor_id')->where('activated', 1)->where('body_of_water', $_REQUEST['waterBody'])->get();
                    foreach ($databaseSearch as $value) { //find the sensors in that body and add replace the list with them
                        $requestOutput->push($value['sensor_id']);
                    }
                }
                
                if (count($requestOutput) > 0) { //for all sensors in the display list
                    $selectedSensors = collect();
                    for ($t = 0; $t < count($requestOutput); $t++) { //if the sensors are publicly visable
                        for ($k = 0; $k < count($visableSensors); $k++) {
                            if ($requestOutput[$t] == $visableSensors[$k]['sensor_id']) {
                                $selectedSensors->push($visableSensors[$k]['sensor_id']); //add to list
                            }
                        }
                        if (Auth::user() != null) {
                            for ($k = 0; $k < count($ownedSensorsWithData); $k++) { //if the senors are owned by the user
                                if ($requestOutput[$t] == $ownedSensorsWithData[$k]['sensor_id']) {
                                    $selectedSensors->push($ownedSensorsWithData[$k]['sensor_id']); //add to list
                                }
                            }
                        }
                    }
                }
            } else {
                $selectedSensors = ['sensor022']; //default to sensor022
            }
        } else {
            $selectedSensors = ['sensor022']; //default to sensor022
        }
        
        $data = collect();
        $filterdData = collect();
        for ($x = 0; $x < count($selectedSensors); $x++) {
            $tempData = $this->GetAndFormatCurl($selectedSensors[$x]); //get sensor info
            if (count($tempData) > 0) { //check if the sensor actualy has data (removes incorrect entries)
                $data->push($tempData); 
                $filterdData->push([collect(), collect(), $selectedSensors[$x]]);
            }
        }
        
        if (count($data) > 0) {
            $dateDivisions = "day";
            if ($request->query() == null || ($_REQUEST['start'] == null && $_REQUEST['end'] == null)) {
                $splitStartDate = explode('-', $data[0][0][$date]);
                $splitEndDate = explode('-', $data[0][count($data[0])-1][$date]); //rearange the dates
                $startDate = $splitStartDate[2].'-'.$splitStartDate[1].'-'.$splitStartDate[0];
                $endDate = $splitEndDate[2].'-'.$splitEndDate[1].'-'.$splitEndDate[0];
                if (count($data) > 1) {
                    for ($y = 1; $y < count($data); $y++) {
                        $splitStartCompDate = explode('-', $data[$y][0][$date]);
                        $splitEndCompDate = explode('-', $data[$y][count($data[$y])-1][$date]); //rearange the dates
                        $startCompDate = $splitStartCompDate[2].'-'.$splitStartCompDate[1].'-'.$splitStartCompDate[0];
                        $endCompDate = $splitEndCompDate[2].'-'.$splitEndCompDate[1].'-'.$splitEndCompDate[0];
                        if (strtotime($endDate) < strtotime($endCompDate)) { $endDate = $endCompDate; } //getting the highest end date
                        if (strtotime($startDate) > strtotime($startCompDate)) { $startDate = $startCompDate; } //and lowest start date
                    }
                }
            } else { //using requested timespans
                $splitStartDate = explode('/', $_REQUEST['start']);
                $splitEndDate = explode('/', $_REQUEST['end']); //reformat for graph
                $startDate = substr($splitStartDate[2], 2, 2).'-'.$splitStartDate[1].'-'.$splitStartDate[0];
                $endDate = substr($splitEndDate[2], 2, 2).'-'.$splitEndDate[1].'-'.$splitEndDate[0];
                
                if (($splitEndDate[1]+($splitEndDate[2]-$splitStartDate[2])*12) - $splitEndDate[1] <= 12) { //selecting the right divisions so you can see the data properly
                    if (($splitEndDate[1]+($splitEndDate[2]-$splitStartDate[2])*12) - $splitEndDate[1] <= 1) {
                        $dateDivisions = "min"; //select the apropriate divder for the zoom
                    } else {
                        $dateDivisions = "hour";
                    }
                }
            } //make datespan for getting all intermediary dates \/
            $dateSpan = new DatePeriod( new DateTime($startDate), new DateInterval('P1D'), new DateTime($endDate) );

            $dates = collect(); //format the date span to add all intermediary dates to the array
            foreach ($dateSpan as $key => $value) {
                if ($dateDivisions != "day") { //save date values for display
                    if ($dateDivisions == "hour") {
                        for ($u = 0; $u < 24; $u++) {
                            $dates->push($value->format('d-m-y').', '.$u.':0');
                        }
                    } else {
                        for ($u = 0; $u < 1440; $u++) {
                            $dates->push($value->format('d-m-y').', '.floor($u/60).':'.($u%60));
                        }
                    }
                } else {
                    $dates->push($value->format('d-m-y'));
                }
            }
        } else {
            $dates = [];
        }

        $data = $data->jsonserialize();
        for ($y = 0; $y < count($data); $y++) {
            for ($i = 0; $i < count($data[$y]); $i++) { //for all the data
                if ($data[$y][$i][$temp] > 0 && $data[$y][$i][$temp] <= 40 && $data[$y][$i][$do] > 0 && $data[$y][$i][$do] <= 65) { //filter it
                    if ($this->IsDateInRange($startDateRange, $endDateRange, $data[$y][$i][$date])) {
                        if ($dateDivisions != "day") { //add time values to the date if it not day sorted
                            if ($dateDivisions == "hour") { //put the right hour into the date 
                                $data[$y][$i][$date] .= ', '.floor(explode(':', $data[$y][$i][$time])[0]).':0';
                            } else {
                                $currentTime = explode(':', $data[$y][$i][$time]);
                                $data[$y][$i][$date] .= ', '.floor($currentTime[0]).':'.floor($currentTime[1]);
                            }
                        }
                        
                        if ($i > 0) {
                            if (strtotime($data[$y][$i-1][$date]) - strtotime($data[$y][$i][$date]) > 604800 || 
                            explode('-', $data[$y][$i-1][$date])[1] != explode('-', $data[$y][$i][$date])[1]) {
                                $filterdData[$y][$ftemp]->push([null, null]);
                                $filterdData[$y][$fdo]->push([null, null]);
                            }
                        }
                        $filterdData[$y][$ftemp]->push([$data[$y][$i][$date], $data[$y][$i][$temp]]); //store it in a nested array list array
                        $filterdData[$y][$fdo]->push([$data[$y][$i][$date], $data[$y][$i][$do]]);
                    }
                }
            }
        }

        if (Auth::user() != null) { //if logged in pass owned sensors too
            return view('sensor_data')
                ->with('sensors',$visableSensors)
                ->with('bodyOfWater',$bodysOfwater)
                ->with('ownedSensors',$ownedSensorsWithData)
                ->with('data',$filterdData)
                ->with('dates',$dates);
        }
        return view('sensor_data') //else just send the rest of the data
            ->with('sensors',$visableSensors)
            ->with('bodyOfWater',$bodysOfwater)
            ->with('data',$filterdData)
            ->with('dates',$dates);
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

    private function IsDateInRange($lowerRange, $upperRange, $dataPoint) {
        if ($lowerRange == null && $upperRange == null) {
            return true;
        }
        
        $splitLowerRange = explode("/", $lowerRange); //split the dates into parts
        $splitUpperRange = explode("/", $upperRange);
        $splitLowerRange[2] = substr($splitLowerRange[2], 2 ,2); //remove hundreds and thousands
        $splitUpperRange[2] = substr($splitUpperRange[2], 2 ,2);
        $splitDataPoint = explode("-", $dataPoint);
        
        $lowerRange = $splitLowerRange[2].$splitLowerRange[1].$splitLowerRange[0]; //make dates into DDMMYY for easy comparison
        $upperRange = $splitUpperRange[2].$splitUpperRange[1].$splitUpperRange[0];
        $dataPoint = $splitDataPoint[2].$splitDataPoint[1].$splitDataPoint[0];

        if (($lowerRange - $dataPoint <= 0 && $upperRange - $dataPoint >= 0)) {
            return true; //if ether point or both points in range
        } else { return false; }
    }
}
