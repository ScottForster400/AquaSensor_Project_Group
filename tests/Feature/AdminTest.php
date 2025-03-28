<?php

namespace Tests\Feature;

use App\Models\Sensor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_admin_can_view_admin_page(): void{

        $admin = User::factory()->create(['admin' => '1']);
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

    }

    public function test_non_admin_cant_view_admin_page(): void{
        $nonadmin = User::factory()->create(['admin' => '0']);
        $response = $this->actingAs($nonadmin)->get('/admin');
        $response->assertStatus(302);

    }

    public function test_admin_can_create_sensor(): void{
        $admin = User::factory()->create(['id' => '1']);
        $response = $this->actingAs($admin)->post('admin/createSensor', [
            'sensor_id' => 'sensor50',
            'opensource' => 0,
            'activation_key' => '1234567891234563',
            'activated' => 0
        ]);

        $this->assertDatabaseHas('sensors',[
            'sensor_id' => 'sensor50',
            'opensource' => 0,
            'activation_key' => '1234567891234563',
            'activated' => 0
       ]);

       $response->assertRedirectToRoute('admin.index');

    }

    public function test_admin_can_delete_sensor(): void{

        $admin = User::factory()->create([
            'id' => 1
       ]);

       $sensor = Sensor::factory()->create([
            'sensor_id' => 'sensor049'

       ]);

        $response = $this->actingAs($admin)->delete('/admin/'.$sensor->id);

        $this->assertDatabaseMissing('sensors',[
            'sensor_id' => $sensor->id,
        ]);


    }

    public function test_admin_can_create_user(): void{

        $admin = User::factory()->create(['id' => '1']);
        $response = $this->actingAs($admin)->post('admin/createUser', [
            'name' => 'sensor50',
            'email' => 0,
            'company_name' => '1234567891234563',
            'password' => 0,
            'admin' => 0
        ]);

        $this->assertDatabaseHas('sensors',[
            'sensor_id' => 'sensor50',
            'opensource' => 0,
            'activation_key' => '1234567891234563',
            'activated' => 0
       ]);


    }






}
