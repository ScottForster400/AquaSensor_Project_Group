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
            $table->string('sensor_data_id')->primary();
            $table->string('sensor_name');
            $table->string('sensor_id')->foreignIdFor(Sensor::class);
            $table->string('sensor_data_date');
            $table->time('sensor_data_time');
            $table->integer('packet_counter');
            $table->float('temperature');
            $table->float('%dissolved_oxygen');
            $table->float('mg/l_dissolved_oxygen');
            $table->longText('data')->nullable();
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
