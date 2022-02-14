<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    // use RefreshDatabase;

    public function test_access_admin_service_it_redirect_when_user_doesnt_login()
    {
        $response = $this->get('/admin/service');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response = $this->get('/admin/service/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $service = Service::factory()->create();
        $response = $this->get('/admin/service/' . $service->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function test_access_admin_service_return_403_when_role_doesnt_admin()
    {
        $user = User::factory()->create(['role' => 'officer']);
        $response = $this->actingAs($user)->get('/admin/service');
        $response->assertStatus(403);


        $response = $this->actingAs($user)->get('/admin/service/create');
        $response->assertStatus(403);

        $service = Service::factory()->create();
        $response = $this->actingAs($user)->get('/admin/service/' . $service->id . '/edit');
        $response->assertStatus(403);
    }
    public function test_access_admin_service_return_200_when_role_is_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/admin/service');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/admin/service/create');
        $response->assertStatus(200);

        $service = Service::factory()->create();
        $response = $this->actingAs($user)->get('/admin/service/' . $service->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_store_service()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post('/admin/service', [
            'name' =>  Str::random(8),
            'code' => strtoupper(Str::random(3)),
            'status' => 1
        ]);
        $response->assertRedirect('/admin/service');
        $response->assertSessionHas('status', 'New Service Successfully Added');

        $response = $this->actingAs($user)->post('/admin/service', [
            'code' => strtoupper(Str::random(3)),
            'status' => 1
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_update_service()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $service = Service::factory()->create();
        $response = $this->actingAs($user)->put('/admin/service/' . $service->id, [
            'name' => 'Test2',
            'status' => $service->status,
            'code' => $service->status,
        ]);
        $response->assertRedirect('/admin/service');
        $response->assertSessionHas('status', 'Service Successfully Updated');
        $this->assertDatabaseHas(Service::class, ['name' => 'Test2']);
        
        $response = $this->actingAs($user)->put('/admin/service/' . $service->id, [
            'code' => $service->code,
            'status' => $service->status
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_destroy_service()
    {    
        $user = User::factory()->create(['role' => 'admin']);
        $this->assertDatabaseHas(Service::class, ['name' => 'Test2']);
        $service = Service::where('name','Test2')->first();
        $this->assertEquals('Test2', $service['name']);
        $response = $this->actingAs($user)->delete('/admin/service/' . $service['id']);
        $response->assertRedirect('admin/service');
        $this->assertDatabaseMissing(Service::class, ['name' => 'Test2']);
    }
}