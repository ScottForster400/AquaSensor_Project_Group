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
use Illuminate\Support\Facades\Crypt;

use function Laravel\Prompts\search;

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
        $sensors = Sensor::where('opensource',1)->where('activated',1)->get();
        //?start=04%2F03%2F2025&end=20%2F03%2F2025
        return view('sensors',compact('opensource','user_sensors'))->with('Sensors',$sensors);

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

        if(Auth::check()){

            $current_user = Auth::user()->id;

            $users_searchedSensors = Sensor::
            Where('sensor_name','like',"%$searchRequest%")
            ->orWhere('sensor_id','like',"%$searchRequest%")
            ->orWhere('location','like',"%$searchRequest%")
            ->where('user_id',$current_user)
            ->paginate(5)->withQueryString();

            $sensors = Sensor::where('opensource',1)->where('activated',1)->get();
            return view('sensors')->with('opensource',$opensource_searchedSensors)->with('user_sensors',$users_searchedSensors)->with('Sensors',$sensors);

        }
        $sensors = Sensor::where('opensource',1)->where('activated',1)->get();
        return view('sensors')->with('opensource',$opensource_searchedSensors)->with('Sensors',$sensors);;
    }

    public function sort(){

        if(Auth::check()){
            $current_user = Auth::user()->id;
            if(array_key_exists('sort_by',$_REQUEST)){
                $sortBy = $_REQUEST['sort_by'];
                if($sortBy =='alph_asc'){
                    $sensors = Sensor::orderBy('sensor_name','asc')->paginate(5)->withQueryString();
                    $usersensors = Sensor::where('user_id',$current_user)->orderBy('sensor_name','asc')->paginate(5)->withQueryString();
                }
                elseif($sortBy =='alph_des'){
                    $sensors = Sensor::orderBy('sensor_name','desc')->paginate(5)->withQueryString();
                    $usersensors = Sensor::where('user_id',$current_user)->orderBy('sensor_name','desc')->paginate(5)->withQueryString();
                }

            }
            return view('sensors')->with('opensource',$sensors)->with('user_sensors',$usersensors)->with('Sensors',$sensors);

        } else{

            if(array_key_exists('sort_by',$_REQUEST)){
                $sortBy = $_REQUEST['sort_by'];
                if($sortBy =='alph_asc'){
                    $sensors = Sensor::orderBy('sensor_name','asc')->paginate(5)->withQueryString();
                }
                elseif($sortBy =='alph_des'){
                    $sensors = Sensor::orderBy('sensor_name','desc')->paginate(5)->withQueryString();
                }

            }

            return view('sensors')->with('opensource',$sensors)->with('Sensors',$sensors);


        }

    }

    public function sortSearch(){



        if(Auth::check()){

            $current_user = Auth::user()->id;


            $searchRequestarray = $_REQUEST['search'];
            $searchRequest = $searchRequestarray['search'];


            if(array_key_exists('sort_by',$_REQUEST) && array_key_exists('search',$searchRequestarray)){
                $sortBy = $_REQUEST['sort_by'];
                if($sortBy =='alph_asc'){
                    $opensource_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('activated',1)
                    ->where('opensource',1)
                    ->orderBy('sensor_name','asc')
                    ->paginate(5)->withQueryString();

                    $users_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('user_id',$current_user)
                    ->orderBy('sensor_name','asc')
                    ->paginate(5)->withQueryString();


                }
                elseif($sortBy =='alph_des'){
                    $opensource_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('activated',1)
                    ->where('opensource',1)
                    ->orderBy('sensor_name','desc')
                    ->paginate(5)->withQueryString();

                    $users_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('user_id',$current_user)
                    ->orderBy('sensor_name','desc')
                    ->paginate(5)->withQueryString();

                }


            }

            $sensors = Sensor::where('opensource',1)->where('activated',1)->get();
            return view('sensors')->with('opensource',$opensource_searchedSensors)->with('user_sensors',$users_searchedSensors)->with('Sensors', $sensors);

        }
        else{

            $searchRequestarray = $_REQUEST['search'];
            $searchRequest = $searchRequestarray['search'];

            if(array_key_exists('sort_by',$_REQUEST) && array_key_exists('search',$searchRequestarray)){
                $sortBy = $_REQUEST['sort_by'];
                if($sortBy =='alph_asc'){
                    $opensource_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('activated',1)
                    ->where('opensource',1)
                    ->orderBy('sensor_name','asc')
                    ->paginate(5)->withQueryString();

                }
                elseif($sortBy =='alph_des'){
                    $opensource_searchedSensors = Sensor::
                    Where('sensor_name','like',"%$searchRequest%")
                    ->orWhere('sensor_id','like',"%$searchRequest%")
                    ->orWhere('location','like',"%$searchRequest%")
                    ->where('activated',1)
                    ->where('opensource',1)
                    ->orderBy('sensor_name','desc')
                    ->paginate(5)->withQueryString();

                }
            }
            return view('sensors')->with('opensource',$opensource_searchedSensors)->with('Sensors', $opensource_searchedSensors);

        }

    }

    public function activate(Request $request)
    {
        $inappropriate_language = file_get_contents(resource_path('textfiles\offensive_language.txt'));
        $words = explode("\n", $inappropriate_language);
        foreach($words as $word){
            if($request->sensor_name == $word){
                session()->flash('warning','Inappropriate Language is not Tolerated');
                return to_route('sensors.index');
            }
        }



        $request->validate([
             'sensor_name' => 'required|Max:255',
             'sensor_location' => 'required|Max:50',
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

        // $EncryptedLatitude = Crypt::encryptString($request->latitude);
        // $EncryptedLongitude = Crypt::encryptString($request->longitude);


        $updated_sensor->update([
            'sensor_name' => $request->sensor_name,
            'location' => $request->sensor_location,
            'body_of_water' => $request->body_of_water,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            // 'latitude' => $EncryptedLatitude,
            // 'longitude' => $EncryptedLongitude,
            'user_id' => $current_user,
            'activated' => 1,
            'opensource' => $request->opensource
        ]);
        $updated_sensor->save();


        return to_route('sensors.index');
    }

    public function update(Request $request, Sensor $sensor)
    {

        $inappropriate_language = file_get_contents(resource_path('textfiles\offensive_language.txt'));
        $words = explode("\n", $inappropriate_language);
        foreach($words as $word){
            if($request->sensor_name == $word){
                session()->flash('warning','Inappropriate Language is not Tolerated');
                return to_route('sensors.index');
            }
        }

        $request->validate([
             'sensor_name' => 'required|Max:255',
             'sensor_location' => 'required|Max:50',
             'body_of_water' => 'required|Max:50',
             'latitude' => 'required',
             'longitude' => 'required',
        ]);

        $updated_sensor = Sensor::where('sensor_id',$sensor->sensor_id)->first();

        // $EncryptedLatitude = Crypt::encryptString($request->latitude);
        // $EncryptedLongitude = Crypt::encryptString($request->longitude);

        $updated_sensor->update([
             'sensor_name' => $request->sensor_name,
             'location' => $request->sensor_location,
             'body_of_water' => $request->body_of_water,
             'latitude' => $request->latitude,
             'longitude' => $request->longitude,
            //  'latitude' => $EncryptedLatitude,
            //  'longitude' => $EncryptedLongitude,
             'opensource' => $request->opensource
         ]);
        $updated_sensor->save();


        return to_route('sensors.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        dd("AFE");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        DD("DGADGQYGQIS");
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
    {
        DD("DGADGQYGQIS");
    }
}
