<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sensor_Data;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * Store a newly created resource in storage.
     */
    public function createUser(Request $request)
    {
        $request ->validate([
            'name'=> 'required|max:255|string',
            'email'=> 'required|max:255|string|lowercase|email|unique:App\Models\user,email',
            'password'=> 'required|max:255',
            'admin'=> 'boolean',
        ]);
        $newUser = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->admin,
        ]);
        $newUser ->save();
        return view('admin.index', ["New user made successfully"]);
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
        if (Auth::user()->admin != 1) {
            abort(403);
        }
        
        $ownedSensors = Sensor::where('id', $user->id);
        foreach ($ownedSensors as $sensor) {
            Sensor_Data::where('sensor_id', $sensor->id)->delete();
            $sensor->delete();
        }
        $user->delete();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createSensor(Request $request)
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
        if (Auth::user()->admin != 1) {
            abort(403);
        }
        
        $sensor->delete();
        Sensor_Data::where('sensor_id', $sensor->id)->delete();
    }
}
