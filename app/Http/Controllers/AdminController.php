<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sensor;
use App\Models\Sensor_Data;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $current_user = Auth::id();

        $allsensors = Sensor::paginate(4);
        $allusers = User::where('id','!=',$current_user)->paginate(5);
        return view('admin',compact('allsensors','allusers'));
    }

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
            'sensor_id'=> 'required|string|max:255|unique:App\Models\Sensor,sensor_id',
            'activation_key'=> 'string|max:16'
        ]);
        $sensor = new Sensor([
            'sensor_id' => $request->sensor_id,
            'opensource' => 0,
            'activated' => 0,
            'activation_key' => $request->activation_key
        ]);
        $sensor->save();
        return to_route('admin.index')->with('success', "New sensor made successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroySensor(Request $request)
    {
        if (Auth::user()->admin != 1) {
            abort(403);
        } else {
            Sensor::where("sensor_id", $request->sensor_id)->delete();
            Sensor_Data::where('sensor_id', $request->sensor_id)->delete();
        }
        return to_route('admin.index')->with('success', "Sensor successfully deleted");
    }
}