<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Counter;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCounterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;
    use RefreshDatabase;
    public function test_access_admin_counter_user_doesnt_login()
    {
        $response = $this->get('/admin/counter');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response = $this->get('/admin/counter/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $counter = Counter::factory()->create();
        $response = $this->get('/admin/counter/' . $counter->id . '/edit');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_access_admin_counter_role_doesnt_admin()
    {
        $user = User::factory()->create(['role' => 'officer']);
        $response = $this->actingAs($user)->get('/admin/counter');
        $response->assertStatus(403);


        $response = $this->actingAs($user)->get('/admin/counter/create');
        $response->assertStatus(403);

        $counter = Counter::factory()->create();
        $response = $this->actingAs($user)->get('/admin/counter/' . $counter->id . '/edit');
        $response->assertStatus(403);
    }

    public function test_access_admin_counter_when_role_is_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/admin/counter');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/admin/counter/create');
        $response->assertStatus(200);

        $counter = Counter::factory()->create();
        $response = $this->actingAs($user)->get('/admin/counter/' . $counter->id . '/edit');
        $response->assertStatus(200);
    }

    public function test_store_counter()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $counter_number = random_int(1, 10);
        $response = $this->actingAs($user)->post('/admin/counter', [
            'number' => $counter_number,
            'status' => 0
        ]);
        $response->assertRedirect('/admin/counter');
        $response->assertSessionHas('status', 'Your Counter Successfully Added');
        $this->assertDatabaseHas(Counter::class, ['number' => $counter_number]);

        $response = $this->actingAs($user)->post('/admin/counter', [
            'status' => 1
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_update_counter()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $counter_number = random_int(100, 999);
        $counter = Counter::factory()->create();
        $response = $this->actingAs($user)->put('/admin/counter/' . $counter->id, [
            'from' => 'admin',
            'number' => $counter_number,
            'status' => $counter->status,
        ]);
        $response->assertRedirect('/admin/counter');
        $response->assertSessionHas('status', 'Your Counter Successfully Updated');
        $this->assertDatabaseHas(Counter::class, ['number' => $counter_number]);

        $response = $this->actingAs($user)->put('/admin/counter/' . $counter->id, [
            'from' => 'admin',
            'status' => $counter->status
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_destroy_counter()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $counter = Counter::factory()->create(['number' => 97]);
        $this->assertDatabaseHas(Counter::class, ['number' => 97]);
        $response = $this->actingAs($user)->delete('/admin/counter/' . $counter->id);
        $response->assertRedirect('admin/counter');
        $this->assertDatabaseMissing(Counter::class, ['number' => 97]);
    }
}