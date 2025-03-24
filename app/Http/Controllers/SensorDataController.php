<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sensor;
use App\Models\Sensor_Data;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Auth;

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
                $activeSensor = $sensor_id;
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
            for ($i=0; $i<count($flipCardData); $i++) {
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

            $dt = Carbon::now();
            $weekDay=($dt->englishDayOfWeek);

            $hourlyAverages = [[], []];
            $currentData = 0;
            for ($j= 0; $j<24; $j++) {
                $timedTemp = 0;
                $timedDO = 0;
                $totalReadingsInCurrentHour = 0;
                while ($currentData < Count($flipCardData[0])) {
                    $hour = (int)explode(":", $flipCardData[0][$currentData][$time])[0];
                    $data = $flipCardData[0][$currentData];
                    if ($hour == $j) {
                        $timedTemp += $data[$temp];
                        $timedDO += $data[$do];
                        $totalReadingsInCurrentHour++;
                    } else {
                        $hourlyAverages[0][$j] = number_format($timedTemp/$totalReadingsInCurrentHour, 3);
                        $hourlyAverages[1][$j] = number_format($timedDO/$totalReadingsInCurrentHour, 3);
                        break;
                    }
                    $currentData++;
                }
            }
            $timeLabel=collect();
            for($i = 0; $i < count($hourlyAverages[0]); ++$i) {
                $time = "{$i}:00";
                $timeLabel->push($time);
            }


            return view('data')
                ->with('mobileAveragedData',$mobileAveragedData)
                ->with('desktopAveragedData',$averagedData)
                ->with('flipCardDataDO', $averagedFlipData[1])
                ->with('currentSensorData',$currentSensorData)
                ->with('currentSensor',$currentSensor)
                ->with('weekDay',$weekDay)
                ->with('flipCardDataTemp', $averagedFlipData[0])
                ->with('hourlyAverages',$hourlyAverages)
                ->with('timeLabel',$timeLabel);
        }
        else{

            return view('data');
        }


    }

    public function sensor_data_index(){


        if(Auth::user() != null){
            $sensors = Sensor::where('activated',1)->where('opensource',1)->where('user_id','!=',Auth::id())->get();
            $SensorIdsWithData =Sensor_Data::select('sensor_id')->get();
            $ownendSenorsWithData=Sensor::whereIn('sensor_id',$SensorIdsWithData)->where('user_id',Auth::id())->where('activated',1)->get();

            return view('sensor_data')->with('sensors',$sensors)->with('ownedSensors',$ownendSenorsWithData);
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
}
