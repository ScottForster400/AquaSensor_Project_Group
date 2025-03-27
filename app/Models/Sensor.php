<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;

    protected $primaryKey = 'sensor_id';
}
