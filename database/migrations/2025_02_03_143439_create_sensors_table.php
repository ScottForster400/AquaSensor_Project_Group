<?php

use App\Models\User;
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
        Schema::create('sensors', function (Blueprint $table) {
            $table->string('sensor_id')->primary();
            $table->string('sensor_name')->nullable();
            $table->foreignIdFor(User::class,'user_id')->nullable();
            $table->string('location',50)->nullable();
            $table->string('body_of_water',50)->nullable();
            $table->float('longitude',12)->nullable();
            $table->float('latitude',12)->nullable();
            $table->boolean('opensource')->default(0);
            $table->string('activation_key',16);
            $table->boolean('activated')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
