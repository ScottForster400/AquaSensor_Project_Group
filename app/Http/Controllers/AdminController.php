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
            'companyname'=> 'required|max:255|string'
        ]);
        $newUser = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->admin,
            'company_name' => $request->companyname
        ]);
        $newUser ->save();
        return to_route('admin.index')->with('success', "New user made successfully");
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
            'confirm'=> 'required|starts_with:confirm|size:7'
        ]);
        dd($request);
        $sensor = new Sensor([
            'opensource' => 0,
            'activated' => 0
        ]);
        $sensor->save();
        return to_route('admin.index')->with('success', "New sensor made successfully");
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
