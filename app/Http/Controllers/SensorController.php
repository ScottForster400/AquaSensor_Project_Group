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


class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //displays the array data for testing
        //dd($data);

        //gets all of the users sensors
        $current_user = Auth::user()->id;
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

        $current_user = Auth::user()->user_id;

        $users_searchedSensors = Sensor::
        Where('sensor_name','like',"%$searchRequest%")
        ->orWhere('sensor_id','like',"%$searchRequest%")
        ->orWhere('location','like',"%$searchRequest%")
        ->where('user_id',$current_user)
        ->paginate(5)->withQueryString();


        return view('sensors')->with('opensource',$opensource_searchedSensors)->with('user_sensors',$users_searchedSensors);
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
}
