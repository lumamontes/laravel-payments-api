<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'invoice_id' => Invoice::factory(),
            'type' => $this->faker->randomElement(['payment', 'withdrawal']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'status' => 'completed',
            'transaction_date' => now(),
        ];
    }
}
