<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    protected $primaryKey = 'sensor_id';
}
