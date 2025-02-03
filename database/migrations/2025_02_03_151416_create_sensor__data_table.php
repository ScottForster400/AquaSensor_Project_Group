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
            $table->foreignIdFor(Sensor::class,'sensor_id');
            $table->dateTime('sensor_data_date');
            $table->float('dissolved_oxygen');
            $table->float('temperature');
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
