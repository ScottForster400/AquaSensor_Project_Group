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
            $table->id('sensor_id');
            $table->foreignIdFor(User::class,'user_id');
            $table->string('location',50);
            $table->string('body_of_water',50);
            $table->float('longitude',12);
            $table->float('latitude',12);
            $table->boolean('opensource');
            $table->string('activation_key',16);
            $table->boolean('activated');
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
