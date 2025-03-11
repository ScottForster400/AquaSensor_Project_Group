<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Sensor_Data;
use Illuminate\Support\Facades\DB;


Route::get('/', [SensorDataController::class, 'index'])->name('sensorData.index');

Route::get('/sensors', [SensorController::class, 'index'])->name('sensors.index');
Route::get('/sensors/search', [SensorController::class, 'search'])->name('sensors.search');
Route::get('/sensors/sort', [SensorController::class, 'sort'])->name('sensors.sort');
Route::post('/sensors/activate', [SensorController::class, 'activate'])->name('sensors.activate');
Route::post('/sensors/update', [SensorController::class, 'update'])->name('sensors.update');
Route::get('/sensor_graph_data',[SensorDataController::class,'sensor_data_index'])->name('sensor_data.index');
Route::get('/sensorData/search', [SensorDataController::class, 'search'])->name('sensorData.search');


//Route::get('/dashboard', function () {
//     return view('');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('sensors',SensorController::class);

Route::resource('sensorData',SensorDataController::class);


Route::Get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.index');
Route::Post('/admin/createUser', [AdminController::class, 'createUser'])->middleware(['auth', 'verified'])->name('admin.createUser');
Route::Post('/admin/destroyUser', [AdminController::class, 'destroyUser'])->middleware(['auth', 'verified'])->name('admin.destroyUser');
Route::Post('/admin/createSensor', [AdminController::class, 'createSensor'])->middleware(['auth', 'verified'])->name('admin.createSensor');
Route::Post('/admin/destroySensor', [AdminController::class, 'destroySensor'])->middleware(['auth', 'verified'])->name('admin.destroySensor');
