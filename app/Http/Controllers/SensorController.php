<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $opensource = Sensor::where('activated', 1)->where('opensource',1)->paginate(5);

        // //$currentuser = Auth::user()->user_id;
        // //$ownedsensors = Sensor::where('user_id',$currentuser)->paginate(5);


        // $sensor = Http::get('https://api.aquasensor.co.uk/aq.php?op=readings&username=shu&token=aebbf6305f9fce1d5591ee05a3448eff&sensorid=sensor022')['message'];

        // return view('sensors',data: compact('opensource','sensors'));



        $curl = curl_init();

        // Mats special code
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.aquasensor.co.uk/aq.php?op=readings&username=shu&token=aebbf6305f9fce1d5591ee05a3448eff&sensorid=sensor022',
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
        dd($response);

    }

    /**
     * Show the form for creating a new resource.
     */

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
}
