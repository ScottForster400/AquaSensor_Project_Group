<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor_Data extends Model
{
    use HasFactory;

    protected $table = 'sensor__data'; 

    protected $primaryKey = 'sensor_data_id';

    protected $fillable = [
        'sensor_id',
        'sensor_data_date',
        'dissolved_oxygen',
        'temperature',
    ];

    public $timestamps = true;

    protected $dates = ['sensor_data_date'];

    // Relationship: Each SensorData belongs to a Sensor
    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }
}
