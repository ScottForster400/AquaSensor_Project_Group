<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'sensor_name',
        'opensource',
        'activated',
        'activation_key'
    ];
}
