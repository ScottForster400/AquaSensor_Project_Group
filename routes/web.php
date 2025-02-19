<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\DB;


Route::get('/', [SensorDataController::class, 'index'])->name('sensorData.index');

Route::get('/sensors', [SensorController::class, 'index'])->name('sensors.index');
Route::get('/sensors/search', [SensorController::class, 'search'])->name('sensors.search');
Route::get('/sensors/sort', [SensorController::class, 'sort'])->name('sensors.sort');



Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

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
