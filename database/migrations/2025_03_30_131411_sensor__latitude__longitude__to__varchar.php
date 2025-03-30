<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sensors', function (Blueprint $table) {
            // Drop the existing columns
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
    
            // Add them back as strings
            $table->string('latitude');
            $table->string('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sensors', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
    
            // Re-add them as floats
            $table->float('latitude');
            $table->float('longitude');
        });
    }
};
