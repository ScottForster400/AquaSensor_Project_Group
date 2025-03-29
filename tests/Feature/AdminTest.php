<?php

namespace Tests\Feature;

use App\Models\Sensor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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

        $admin = User::factory()->create(['admin' => '1']);

        $response = $this->actingAs($admin)->post('admin/createSensor', [
            'sensor_id' => 'sensor50',
            'opensource' => 0,
            'activation_key' => '1234567891234563',
            'activated' => 0
        ]);

        $this->assertDatabaseHas('sensors', [
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

        $response = $this->actingAs($admin)->delete('/admin/destroySensor/'.$sensor->id);

        $this->assertDatabaseMissing('sensors',[
            'sensor_id' => $sensor->id,
        ]);


    }

    public function test_admin_can_create_user(): void{

       $admin = User::factory()->create(['id' => '1']);
       $response = $this->actingAs($admin)->post('admin/createUser', [
        'name' => 'bob',
        'email' => 'bob@bobmail',
        'company_name' => 'bobtown',
        'password' => 'password',
        'admin' => 0
       ]);

       $this->assertDatabaseHas('users',[
        'name' => 'bob',
        'email' => 'bob@bobmail',
        'company_name' => 'bobtown',
        'admin' => 0
      ]);

      $response->assertRedirectToRoute('admin.index');


    }

    public function test_admin_can_delete_user(): void{

        $admin = User::factory()->create(['id' => 1, 'admin' => 1]);

        $user = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/destroyUser', ['user_id' => $user->id]);

        $response->assertRedirect(route('admin.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);


    }
    public function test_sensor_cant_be_made_if_sensor_id_already_exist(): void{

        $sensor1 = Sensor::factory()->create([
            'sensor_id' => 'sensor001',
        ]);

        $admin = User::factory()->create(['id' => '1']);
        $response = $this->actingAs($admin)->post('admin/createSensor', [
            'sensor_id' => 'sensor001',
        ]);

        $response->assertSessionHasErrors('sensor_id');

    }

    public function test_sensor_cant_be_made_if_activation_key_already_exist(): void{

        $sensor1 = Sensor::factory()->create([
            'activation_key' => 'activationkey01',
        ]);

        $admin = User::factory()->create(['id' => '1']);
        $response = $this->actingAs($admin)->post('admin/createSensor', [
            'activation_key' => 'activationkey01',
        ]);

        $response->assertSessionHasErrors('activation_key');

    }

    public function test_user_cant_be_made_if_email_already_exist(): void{

        $user1 = User::factory()->create([
            'email' => 'bob@bobmail',
        ]);

        $admin = User::factory()->create(['id' => '1']);
        $response = $this->actingAs($admin)->post('admin/createUser', [
            'email' => 'bob@bobmail',
        ]);

        $response->assertSessionHasErrors('email');

    }






}
