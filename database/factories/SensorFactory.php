<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sensor;

class SensorFactory extends Factory
{
    protected $model = Sensor::class;

    public function definition()
    {
        return [
            'sensor_id' => $this->faker->unique()->uuid,
            'sensor_name' => $this->faker->word,
            'location' => $this->faker->city,
            'body_of_water' => $this->faker->word,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'activation_key' => '1234',
            'opensource' => 1,
        ];
    }
}

?>