<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Sensor extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;

    protected $primaryKey = 'sensor_id';

    protected $fillable = ['latitude', 'longitude'];

    public function getLatitudeAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getLongitudeAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
