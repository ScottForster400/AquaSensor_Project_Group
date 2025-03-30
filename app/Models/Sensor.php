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

    protected $fillable = ['latitude', 'longitude', 'sensor_id', 'user_id', 'sensor_name', 'location', 'body_of_water','opensource','activation_key','activated','created_at','updated_at'];

    public function getLatitudeAttribute($value)
    {
        if ($value != null) {
            return Crypt::decryptString($value);
        }
    }

    public function getLongitudeAttribute($value)
    {
        if ($value != null) {
            return Crypt::decryptString($value);
        }
    }
}
