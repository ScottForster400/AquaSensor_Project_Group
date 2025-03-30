<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Sensor;
use App\Models\User;
use Tests\TestCase;

class SensorListPageTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_edit_sensor(): void
    {

    $user = User::factory()->create(['id' => 1]);

    $sensor = Sensor::factory()->create([
        'sensor_name' => 'sensor_name',
        'location' => null,
        'body_of_water' => null,
        'latitude' => null,
        'longitude' => null,
        'activated' => 1,
        'activation_key' => 'activationkey001',
        'opensource' => 0,
    ]);

    $response = $this->actingAs($user)->post(route('sensors.update'. $sensor->id), [
        'sensor_name' => 'updated_name',
        'location' => 'Hope Valley',
        'body_of_water' => 'River Derwent',
        'latitude' => 5,
        'longitude' => 6,
    ]);

    $this->assertDatabaseHas('sensors', [
        'id' => $sensor->id,
        'sensor_name' => 'updated_name',
        'location' => 'Hope Valley',
        'body_of_water' => 'River Derwent',
        'latitude' => 5,
        'longitude' => 6,
        'activated' => 1,
        'activation_key' => 'activationkey001',
        'opensource' => 0,
    ]);

    $response->assertRedirect(route('sensors.index'));

    }


}
