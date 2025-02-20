<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //gets all of the users sensors
        $current_user = Auth::id();
        $user_sensors = Sensor::where('user_id', $current_user)->paginate(5);

        //gets all open source and activated sensors
        $opensource = Sensor::where('activated', 1)->where('opensource',1)->paginate(5);

        
        return view('sensors',compact('opensource','user_sensors'));

    }

    public function search(Request $request){

        $searchRequest = $request->search;
        $opensource_searchedSensors = Sensor::
        Where('sensor_name','like',"%$searchRequest%")
        ->orWhere('sensor_id','like',"%$searchRequest%")
        ->orWhere('location','like',"%$searchRequest%")
        ->where('activated',1)
        ->where('opensource',1)
        ->paginate(5)->withQueryString();

        $current_user = Auth::user()->id;

        $users_searchedSensors = Sensor::
        Where('sensor_name','like',"%$searchRequest%")
        ->orWhere('sensor_id','like',"%$searchRequest%")
        ->orWhere('location','like',"%$searchRequest%")
        ->where('user_id',$current_user)
        ->paginate(5)->withQueryString();


        return view('sensors')->with('opensource',$opensource_searchedSensors)->with('user_sensors',$users_searchedSensors);
    }

    public function sort(){

        $current_user = Auth::user()->id;
        if(array_key_exists('sort_by',$_REQUEST)){
            $sortBy = $_REQUEST['sort_by'];
            if($sortBy =='alph_asc'){
                $sensors = Sensor::orderBy('sensor_name','asc')->paginate(5)->withQueryString();
                $usersensors = Sensor::where('user_id',$current_user)->orderBy('sensor_name','asc')->paginate(5);
            }
            elseif($sortBy =='alph_des'){
                $sensors = Sensor::orderBy('sensor_name','desc')->paginate(5)->withQueryString();
                $usersensors = Sensor::where('user_id',$current_user)->orderBy('sensor_name','desc')->paginate(5);
            }



        }
        return view('sensors')->with('opensource',$sensors)->with('user_sensors',$usersensors);
    }

    public function activate(Request $request)
    {

        $request->validate([
            'sensor_name' => 'required|Max:255',
            'location' => 'required|Max:50',
            'body_of_water' => 'required|Max:50',
            'latitude' => 'required',
            'longitude' => 'required',
            'activation_key' => 'required|Max:16',
            'opensource' => 'required'
        ]);

        $current_user = Auth::user()->id;
        $updated_sensor = Sensor::where('activation_key',$request->activation_key)->where('activated',0)->first();

        if (is_null($updated_sensor)){
            session()->flash('warning','There is no inactive sensor with this Activation Key.');
            return to_route('sensors.index');
        }


        $updated_sensor->update([
            'sensor_name' => $request->sensor_name,
            'location' => $request->sensor_location,
            'body_of_water' => $request->body_of_water,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => $current_user,
            'activated' => 1,
            'opensource' => $request->opensource
        ]);
        $updated_sensor->save();


        return to_route('sensors.index');
    }

    public function update()
    {

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
