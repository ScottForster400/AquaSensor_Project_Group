<?php

use App\Models\Sensor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor__data', function (Blueprint $table) {
            $table->id('sensor_data_id');
            $table->foreignIdFor(Sensor::class,'sensor_id')->nullable();
            $table->dateTime('sensor_data_date')->nullable();
            $table->float('dissolved_oxygen')->nullable();
            $table->float('temperature')->nullable();
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor__data');
    }
};
