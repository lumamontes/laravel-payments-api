<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Balance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_make_a_payment()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/transactions', [
            'type' => 'payment',
            'payment_method' => 'credit_card',
            'amount' => $invoice->amount,
            'invoice_id' => $invoice->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'type', 'amount', 'status']);

        $this->assertEquals('paid', $invoice->fresh()->status);
    }

    public function test_authenticated_user_can_make_a_withdrawal()
    {
        $user = User::factory()->create();
        $balance = Balance::factory()->create(['user_id' => $user->id, 'balance' => 500]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/transactions', [
            'type' => 'withdrawal',
            'payment_method' => 'bank_transfer',
            'amount' => 100,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'type', 'amount', 'status']);

        $this->assertEquals(400, $balance->fresh()->balance);
    }

    public function test_user_cannot_withdraw_more_than_balance()
    {
        $user = User::factory()->create();
        $balance = Balance::factory()->create(['user_id' => $user->id, 'balance' => 50]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/transactions', [
            'type' => 'withdrawal',
            'payment_method' => 'paypal',
            'amount' => 100,
        ]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Insufficient balance']);
    }
}
