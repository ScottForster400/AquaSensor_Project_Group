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

    public function test_user_can_activate_sensor(): void{
        $user = User::factory()->create(['id' => 1]);
        $sensor = Sensor::factory()->create([
            'sensor_name' => null,
            'location' => null,
            'body_of_water' => null,
            'latitude' => null,
            'longitude' => null,
            'activated' => 0,
            'activation_key' => 'activationkey001',
            'opensource' => 0,
        ]);


        $response = $this->actingAs($user)->post('sensors/activate',[
            'sensor_name' => 'Derwent 99',
            'location' => 'Hope Valley',
            'body_of_water' => 'River Derwent',
            'latitude' => 5,
            'longitude' => 6,
            'activated' => 1,
            'activation_key' => $sensor->activation_key,
            'opensource' => 0,
       ]);

       $this->assertDatabaseHas('sensors',[
        'sensor_name' => 'Derwent 99',
        'location' => 'Hope Valley',
        'body_of_water' => 'River Derwent',
        'latitude' => 5,
        'longitude' => 6,
        'activated' => 1,
        'activation_key' => $sensor->activation_key,
        'opensource' => 0,
        ]);

        $response->assertRedirectToRoute('sensors.index');



    }



}
