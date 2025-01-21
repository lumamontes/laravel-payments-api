<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Balance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_balance()
    {
        $user = User::factory()->create();
        $balance = Balance::factory()->create(['user_id' => $user->id, 'balance' => 1000]);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/balance');

        $response->assertStatus(200)
                 ->assertJson(['balance' => 1000]);
    }

    public function test_unauthenticated_user_cannot_access_balance()
    {
        $response = $this->getJson('/api/balance');
        $response->assertStatus(401);
    }
}
