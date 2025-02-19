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
        $sensor = Sensor::Get();
        $user = User::Get();
        return view('admin')->with('sensor', $sensor)->with('user', $user);
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
            'ID'=> 'required|string|max:255|unique:App\Models\Sensor,sensor_id',
            'name'=> 'string|max:255|nullable',
            'ActivationKey'=> 'string|size:16|unique:App\Models\Sensor,activation_key'
        ]);
        $sensor = new Sensor([
            'sensor_id' => $request->ID,
            'sensor_name' => $request->name,
            'opensource' => 0,
            'activated' => 0,
            'activation_key' => $request->ActivationKey
        ]);
        $sensor->save();
        return to_route('admin.index')->with('success', "New sensor made successfully");
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
