<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Sensor;
use Tests\TestCase;

class SensorListPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_activate_sensor(): void
    {

        $response = $this->get('/sensors');

        $sensor = Sensor::factory()->create([
            'sensor_id' => 'TestingActivation',
            'activation_key' => '1234',
        ]);

        $response->assertStatus(200);

        $response = $this->post(route('sensors.activate', ['sensor_name' => 'Test2', 'sensor_location' => 'Test2', 'body_of_water' => 'Test2', 'latitude' => '1', 'longitude' => '1', 'activation_key' => '1234', 'opensource' => '1']));

        $this->assertDatabaseHas('sensors', [
            'sensor_id' => 'TestingActivation',
            'sensor_name' => 'Test2',
            'location' => 'Test2',
            'body_of_water' => 'Test2',
            'latitude' => '1',
            'longitude' => '1',
            'activation_key' => '1234',
            'opensource' => 1,
        ]);

        $response->dump();
        $response->assertStatus(302);
    }

    public function test_editing_sensors(): void
    {
        
        $response = $this->get('/sensors');

        $sensor = Sensor::factory()->create([
            'sensor_id' => 'TestingActivation',
            'sensor_name' => 'Test2',
            'location' => 'Test2',
            'body_of_water' => 'Test2',
            'latitude' => '1',
            'longitude' => '1',
            'activation_key' => '1234',
            'opensource' => 1,
        ]);

        $response = $this->post(route('sensors.update', ['sensor' => $sensor->sensor_id]), [
            'sensor_name' => 'Test1',
            'sensor_location' => 'Test1',
            'body_of_water' => 'Test1',
            'latitude' => '2',
            'longitude' => '2',
            'activation_key' => '1234',
            'opensource' => 1,
        ]);

        $this->assertDatabaseHas('sensors', [
            'sensor_id' => $sensor->sensor_id,
            'sensor_name' => 'Test1',
            'location' => 'Test1',
            'body_of_water' => 'Test1',
            'latitude' => '2',
            'longitude' => '2',
            'activation_key' => '1234',
            'opensource' => 1,
        ]);
    }
}
