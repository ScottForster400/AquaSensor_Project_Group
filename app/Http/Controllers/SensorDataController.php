<?php

namespace App\Http\Controllers;

use App\Models\Sensor_Data;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;
use Laravel\Pail\Options;



class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chart = Chartjs::build()
            ->name("UserRegistrationsChart")
            ->type("line")
            ->size(["width" => 400, "height" => 200])
            ->labels(["a","b","c","d"])
            ->datasets([
                [
                    "label" => "User Registrations",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" =>[1,2,3,4]
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => 'a',
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Monthly User Registrations'
                    ]
                ]
            ]);




        return view('data',compact("chart"));
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
