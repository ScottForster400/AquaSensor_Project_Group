<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorDataController;

Route::get('/', [SensorDataController::class, 'index'])->name('sensorData.index');
Route::get('/', [SensorController::class, 'index'])->name('sensors.index');
Route::get('/', [AdminController::class, 'index'])->name('admin.index');

// Route::get('/dashboard', function () {
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
