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
    public function index(Request $request)
    {
        $sensorCount = Count(Sensor::where('opensource', 1)->where('activated', 1)->get());
        //get open source sensor count
        //dd(!$this->Compare2Dates("09-02-25", "13/03/2025", true) . ", " . $this->Compare2Dates("15-04-25", "13/03/2025", false));

        if ($sensorCount > 0) { //if any open source sensors exist
            if (array_key_exists('sensor_id', $_REQUEST)) { //if the user has selected a sensor
                $activeSensor = $_REQUEST['sensor_id'];
                $data = $this->GetAndFormatCurl($activeSensor); //get all data related to that sensor
                $sensor_id = $_REQUEST['sensor_id']; //save id for later
            } else { //if no specific sensor selected
                $allSensors = Sensor::where('opensource', 1)->where('activated', 1)->get();
                $randomSensors = $allSensors[random_int(0, count($allSensors) -1)]; //select a random sensor
                $sensor_id = $randomSensors->sensor_id;
                $activeSensor = $sensor_id; //save id for later
                $data = $this->GetAndFormatCurl($activeSensor); //get related data
            }

            $temp=2; //setup values
            $do=3;  //53.650131, -1.783098
            $date=0;
            $time=1;
            $sunRise = '0400';
            $sunSet = '2000';

            $mobileAveragedData = collect([collect(), collect(), collect(), collect()]);
            $averagedData = collect([collect(), collect(), collect(), collect()]);
            $startDate = "01/01/2000"; //api ony uses 2 digits for year so will break after 2100
            $endDate = "31/12/2099";

            if (isset($_REQUEST['start']) &&  isset($_REQUEST['end'])) {
                $startDate = $_REQUEST['start'];
                $endDate = $_REQUEST['end'];

                $splitStart = explode("/", $startDate);
                $splitEnd = explode("/", $endDate);

                $mobileAverageMax = 2000;
                $splitEnd[1] = (int)$splitEnd[1] + ($splitEnd[2] - $splitStart[2]) * 12;

                $mobileAverageCount = ($splitEnd[1] - $splitStart[1])+1 * 5;
                if ($splitEnd[1] - $splitStart[1] == 0) {
                    $mobileAverageCount = ($splitEnd[0]-$splitStart[0])+1 * (5/30);
                }
                if ($mobileAverageCount < 1) { $mobileAverageCount = 1;}
                if ($mobileAverageCount > 2000) { $mobileAverageCount = 50;}
            } else {
                $mobileAverageCount = 50;
            }

            $averageCount = 700; //data settings
            $dataLength = count($data)/$averageCount;
            $mobileData = $data;
            $mobileDataLength = count($data)/$mobileAverageCount;
            if (count($data) > 0) {
                for ($i = 0; $i < $mobileDataLength; $i++) { //do the averaging for moblile
                    $averageTempData = 0;
                    $averageDoData = 0;

                    $dataAverager = array_splice($mobileData, 0, $mobileAverageCount); //split the array into sections
                    if ($this->IsArrayInRange($startDate, $endDate, $dataAverager[0][$date], $dataAverager[Count($dataAverager)-1][$date])) { //if the split is entirly outside date range skip
                        for ( $j = 0; $j < count($dataAverager); $j++) { //average each array section
                            if (!$this->IsDateInRange($startDate, $endDate, $dataAverager[$j][$date])) { //if date outside range
                                array_splice($dataAverager, $j, 1); //remove from array section
                            } else {
                                if ($dataAverager[$j][$temp] > 0 && $dataAverager[$j][$temp] <= 40 && $dataAverager[$j][$do] >= 0 && $dataAverager[$j][$do] <= 65) {
                                    $averageTempData += $dataAverager[$j][$temp];
                                    $averageDoData += $dataAverager[$j][$do];
                                } else { //if the current value is too high to be realistic (an error reading)
                                    array_splice($dataAverager, $j, 1); //remove from array section
                                }
                            }
                        }
                        $mobileAveragedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3, '.', ''));
                        $mobileAveragedData[$do]->push(number_format($averageDoData/count($dataAverager), 3, '.', ''));
                        $mobileAveragedData[$date]->push($dataAverager[0][$date] . " - " . $dataAverager[count($dataAverager)-1][$date]);
                        $mobileAveragedData[$time]->push($dataAverager[0][$time]); //save averaged data in variable
                    }
                }

                for ($i = 0; $i < $dataLength; $i++) { //do the averaging for desktop (exact same as mobile)
                    $averageTempData = 0;
                    $averageDoData = 0;

                    $dataAverager = array_splice($data, 0, $averageCount); //split the array into sections
                    if ($this->IsArrayInRange($startDate, $endDate, $dataAverager[0][$date], $dataAverager[Count($dataAverager)-1][$date])) { //if the split is entirly outside date range skip
                        for ( $j = 0; $j < count($dataAverager); $j++) {
                            if (!$this->IsDateInRange($startDate, $endDate, $dataAverager[$j][$date])) { //if date outside range
                                array_splice($dataAverager, $j, 1); //remove from array section
                            } else {
                                if ($dataAverager[$j][$temp] >= -30 && $dataAverager[$j][$temp] <= 120 && $dataAverager[$j][$do] >= 0 && $dataAverager[$j][$do] <= 65) {
                                    $averageTempData += $dataAverager[$j][$temp];
                                    $averageDoData += $dataAverager[$j][$do];
                                } else {
                                    array_splice($dataAverager, $j, 1);
                                }
                            }
                        }
                    }
                    $averagedData[$temp]->push(number_format($averageTempData/count($dataAverager), 3));
                    $averagedData[$do]->push(number_format($averageDoData/count($dataAverager), 3));
                    $averagedData[$date]->push($dataAverager[0][$date] . " - " . $dataAverager[count($dataAverager)-1][$date]);
                    $averagedData[$time]->push($dataAverager[0][$time]);
                }

                $timeFrameEntries = [ //get the initial data for the averages on the flip cards
                    $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y', strtotime('yesterday')) . "&todate=" . date('d-m-y')),
                    $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y', strtotime('-'.(string)(date('w')-1).' days')) . "&todate=" . date('d-m-y')),
                    $this->GetAndFormatCurl($activeSensor . "&fromdate=" . date('d-m-y', strtotime('-'.(string)(date('j')-1).' days')) . "&todate=" . date('d-m-y'))
                ];

                $currentTime = date( 'Hi');
                $currentDate = date( 'ymd');
                $nightTimeSplitData = [[],[]]; //filtering current day data for time spans
                for ($z=0; $z<count($timeFrameEntries[0]); $z++) { //day entries
                    $splitTime = explode(':', $timeFrameEntries[0][$z][$time]);
                    $splitDate = explode('-', $timeFrameEntries[0][$z][$date]);
                    $cumilatedTime = $splitTime[0].$splitTime[1];
                    $cumilatedDate = $splitDate[2].$splitDate[1].$splitDate[0];
                    //if ($z == 165) { dd($currentTime.'; '.$sunRise.'; '.$sunSet.' --- '.$currentDate.' '.$cumilatedDate); }
                    if ($sunRise <= $cumilatedTime && $sunSet >= $cumilatedTime && $currentDate == $cumilatedDate) {
                        $nightTimeSplitData[0][count($nightTimeSplitData[0])] = $timeFrameEntries[0][$z]; //only save data if in the day bounds
                    }
                    $endOfDayCheck = $currentDate == $cumilatedDate && $cumilatedTime >= $sunSet; //if current day is past sunset
                    $startOfDayCheck1 = $cumilatedTime >= $sunSet && $currentDate != $cumilatedDate && $sunSet <= $cumilatedTime && 2400 >= $cumilatedTime; //checks previous day on day chaange
                    $startOfDayCheck2 = $cumilatedTime <= $sunRise && $currentDate == $cumilatedDate && 0000 <= $cumilatedTime && $sunRise >= $cumilatedTime; //checks current day on day change
                    if ($startOfDayCheck1 || $startOfDayCheck2 || $endOfDayCheck) {
                        $nightTimeSplitData[1][count($nightTimeSplitData[1])] = $timeFrameEntries[0][$z]; //only save data if in the night bounds
                        //echo "<a>$cumilatedTime; $sunRise; $sunSet --- $currentDate $cumilatedDate --- $startOfDayCheck1:$startOfDayCheck2:$endOfDayCheck</a><br>";
                    }
                }

                $averagedFlipData = [[0, 0, 0], [0, 0, 0]]; //setup
                for ($i=0; $i<count($timeFrameEntries); $i++) { //average data for flip cards
                    $tempAverager = 0;
                    $doAverager = 0;
                    if (count($timeFrameEntries[$i]) > 0) {
                        for ($j= 0; $j<count($timeFrameEntries[$i]); $j++) { //get the total of data
                            $tempAverager += $timeFrameEntries[$i][$j][$temp];
                            $doAverager += $timeFrameEntries[$i][$j][$do];
                        }
                        $averagedFlipData[0][$i] = number_format($tempAverager/count($timeFrameEntries[$i]), 3);
                        $averagedFlipData[1][$i] = number_format($doAverager/count($timeFrameEntries[$i]), 3);
                    } else {
                        $averagedFlipData[0][$i] = 0;
                        $averagedFlipData[1][$i] = 0;
                    }
                }   //save averages
            } else {
                return view('data')->with('message', "The sensor that attempted to display is bugged (".$sensor_id."). Please let an admin know");
            }

            $currentSensorData = Sensor_Data::where('sensor_id',$sensor_id)->first(); //get latest values
            $currentSensor = Sensor::where('sensor_id', $sensor_id)->first();

            $dt = Carbon::now();
            $weekDay=($dt->englishDayOfWeek); //get current day of the week
            
            $sensors = Sensor::where('opensource',1)->get(); //get opensource sensor count

            // day, night and time stuffs
            $reformatedData = [[[], []], [[], []]];
            if (Count($nightTimeSplitData[0]) > 0) {
                for ($o= 0; $o<2; $o++) { //reformat the data
                    for ($j= 0; $j<Count($nightTimeSplitData[$o]); $j++) {
                        $reformatTime = explode(':', $nightTimeSplitData[$o][$j][$time]);
                        $reformatedData[$o][0][$j] = [$reformatTime[0].':'.$reformatTime[1], $timeFrameEntries[0][$j][$temp]];
                        $reformatedData[$o][1][$j] = [$reformatTime[0].':'.$reformatTime[1], $timeFrameEntries[0][$j][$do]];
                    }
                }
            }

            $timeLabel=[collect(), collect()];
            $riseInMins = $sunRise%100 + floor($sunRise/100)*60;
            $setInMins = $sunSet%100 + floor($sunSet/100)*60;
            for($i = $riseInMins; $i <= $setInMins; ++$i) { //day hourly labels
                $minsForHour = $i%60;
                if ($i < 10) { $ret = '0'.floor($i/60); }
                else { $ret = floor($i/60); }
                if ($minsForHour < 10) { $minsForHour = '0'.$minsForHour; }
                if ($ret < 10) { $ret = '0'.$ret; }
                $timeLabel[0]->push("{$ret}:{$minsForHour}");
            }
            for($i = $setInMins; $i <= $riseInMins; ++$i) { //night hourly labels
                $minsForHour = $i%60;
                if ($minsForHour < 10) { $minsForHour = '0'.$minsForHour; }
                if ($ret < 10) { $ret = '0'.$ret; }
                $timeLabel[0]->push("{$ret}:{$minsForHour}");
                if ($i/60 == 24) { $i = 0; } //reset the time to 0 on hitting h24
            }
            //dd($reformatedData[0]);

            return view('data')
                ->with('mobileAveragedData',$mobileAveragedData)
                ->with('desktopAveragedData',$averagedData)
                ->with('dayFlipCardDataDO', $averagedFlipData[1])//->with('nightFlipCardDataDO', $averagedFlipData[1][1])
                ->with('dayFlipCardDataTemp', $averagedFlipData[0])//->with('nightFlipCardDataTemp', $averagedFlipData[1][0])
                ->with('currentSensorData',$currentSensorData)
                ->with('currentSensor',$currentSensor)
                ->with('weekDay',$weekDay)
                ->with('daysData',$reformatedData[0])->with('nightsData', $reformatedData[1])
                ->with('daysLabel',$timeLabel[0])->with('nightsLabel',$timeLabel[1])
                ->with('Sensors',$sensors);
        }
        else{
            return view('data')->with('message', "No Sensor Data in system");
        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd("stire");
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor_Data $sensor_Data)
    {
        dd("show");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor_Data $sensor_Data)
    {
        dd("edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor_Data $sensor_Data)
    {
        dd("upadte");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor_Data $sensor_Data)
    {
        dd("destroy");
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
    public function search(Request $request){
        $searchRequest = $request->search;

        $searchedSensor = Sensor::
        Where('sensor_id','like',"%$searchRequest%")
        ->where('activated',1)
        ->where('opensource',1)
        ->first();

        if($searchedSensor == null){
            return view('data');
        }
        else{
            $sensor_id=$searchedSensor->sensor_id;
            return to_route('sensorData.index',compact('sensor_id'));
        }

    }

    //checks if the value is in the date range
    private function IsDateInRange($lowerRange, $upperRange, $dataPoint) {
        $splitLowerRange = explode("/", $lowerRange); //split the dates into parts
        $splitUpperRange = explode("/", $upperRange);
        $splitDataPoint = explode("-", $dataPoint);
        $splitLowerRange[2] = substr($splitLowerRange[2], 2); //remove hundreds and thousands from range
        $splitUpperRange[2] = substr($splitUpperRange[2], 2);
        
        $lowerRange = $splitLowerRange[2].$splitLowerRange[1].$splitLowerRange[0]; //make dates into DDMMYY for easy comparison
        $upperRange = $splitUpperRange[2].$splitUpperRange[1].$splitUpperRange[0];
        $dataPoint = $splitDataPoint[2].$splitDataPoint[1].$splitDataPoint[0];

        if (($lowerRange - $dataPoint <= 0 && $upperRange - $dataPoint >= 0)) {
            return true; //if ether point or both points in range
        } else { return false; }
    }

    //returns true if the data points are in the range points
    private function IsArrayInRange($lowerRange, $upperRange, $lowerData, $upperData) {
        $splitLowerRange = explode("/", $lowerRange); //split the dates into parts
        $splitUpperRange = explode("/", $upperRange);
        $splitLowerData = explode("-", $lowerData);
        $splitUpperData = explode("-", $upperData);
        $splitLowerRange[2] = substr($splitLowerRange[2], 2); //remove hundreds and thousands from range
        $splitUpperRange[2] = substr($splitUpperRange[2], 2);
        
        $lowerRange = $splitLowerRange[2].$splitLowerRange[1].$splitLowerRange[0]; //make dates into DDMMYY for easy comparison
        $upperRange = $splitUpperRange[2].$splitUpperRange[1].$splitUpperRange[0];
        $lowerData = $splitLowerData[2].$splitLowerData[1].$splitLowerData[0];
        $upperData = $splitUpperData[2].$splitUpperData[1].$splitUpperData[0];

        //printf(($lowerRange - $lowerData <= 0).", ".($upperRange - $lowerData >= 0).", ".($lowerRange - $upperData <= 0).", ".($upperRange - $upperData >= 0)." - - ".
        //$lowerRange.", ".$upperRange.", ".$lowerData.", ".$upperData."<br>");
        if (($lowerRange - $lowerData <= 0 && $upperRange - $lowerData >= 0) || ($lowerRange - $upperData <= 0 && $upperRange - $upperData >= 0) || ($upperRange - $lowerData >= 0 && $lowerRange - $upperData <= 0)) {
            return true; //if ether point or both points in range
        } else { return false; }
    }
}
