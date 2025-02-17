<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sensor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showUser(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(User $user)
    {
        //
    }


    public function createSensor()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSensor(Request $request)
    {
        $request->validate([
            'activation_key' => 'required|max:16'
        ]);

        $sensor = new Sensor([
            'activation_key' => $request->activation_key,
            'opensource' => 0,
            'activated' => 0
        ]);
        $sensor->save();
    }

    /**
     * Display the specified resource.
     */
    public function showSensor(Sensor $sensor)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroySensor(Sensor $sensor)
    {
        //
    }
}
