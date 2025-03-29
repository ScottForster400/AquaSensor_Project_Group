<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SensorDataPageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_closest_sensor_search(): void
    {
        $response = $this->get('/sensorData');

        $response->assertStatus(200);

        $response = $this->get(route('sensorData.search', ['search' => '941170']));

        if ($response->status() === 302) {
            $response->assertRedirect(route('sensorData.index', ['sensor_id' => '941170']));
        } else {
            $response->assertStatus(200);
            $response->assertViewIs('data');
        }
    }

    public function test_search_bar_shows_correct_sensor(): void
    {
        $response = $this->get('/sensorData');

        $response->assertStatus(200);
        
        $response = $this->get(route('sensorData.index', ['sensor_id' => '941170']));

        if ($response->status() === 302) {
            $response->assertRedirect(route('sensorData.index', ['sensor_id' => '941170']));
        } else {
            $response->assertStatus(200);
            $response->assertViewIs('data');
        }

        $response = $this->get('/sensorData');

        $response->assertStatus(200);
        
        $response = $this->get(route('sensorData.index', ['sensor_id' => '94']));

        if ($response->status() === 302) {
            $response->assertRedirect(route('sensorData.index', ['sensor_id' => '94']));
        } else {
            $response->assertStatus(200);
            $response->assertViewIs('data');
        }

        $response->assertSee('No Sensor Data in system');
    }
}
