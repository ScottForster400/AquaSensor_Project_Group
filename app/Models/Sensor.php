<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public function sensor_data(){
        return $this->hasMany(Sensor_Data::class);
    }
}
