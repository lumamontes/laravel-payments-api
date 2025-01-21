<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_invoice()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/invoices', [
            'amount' => 100.50,
            'due_date' => '2024-06-01',
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'amount', 'status']);
    }

    public function test_unauthenticated_user_cannot_create_invoice()
    {
        $response = $this->postJson('/api/invoices', [
            'amount' => 100.50,
            'due_date' => '2024-06-01',
            'status' => 'pending',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_retrieve_their_invoices()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Invoice::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/invoices');

        $response->assertStatus(200)
                 ->assertJsonStructure([['id', 'amount', 'status']]);
    }

    public function test_user_cannot_access_another_users_invoices()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user1);

        Invoice::factory()->create(['user_id' => $user2->id]);

        $response = $this->getJson('/api/invoices');

        $response->assertStatus(200)
                 ->assertJsonCount(0);
    }

}
