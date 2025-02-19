<?php

namespace App\Http\Controllers;

use App\Models\Sensor_Data;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Sensors = Sensor::where('opensource', 1);

        return view('data')->with('Sensors', $Sensors);
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
