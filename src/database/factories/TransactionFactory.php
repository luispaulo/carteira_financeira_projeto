<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'type' => $this->faker->randomElement(['deposit', 'transfer']),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'status' => 'completed',
            'reversed_transaction_id' => null,
            'created_at' => now(),
        ];
    }

    /**
     * State for deposit transaction.
     */
    public function deposit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'deposit',
            'sender_id' => null,
        ]);
    }

    /**
     * State for transfer transaction.
     */
    public function transfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'transfer',
        ]);
    }

    /**
     * State for reversal transaction.
     */
    public function reversal(Transaction $original): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'reversal',
            'amount' => $original->amount,
            'sender_id' => $original->receiver_id,
            'receiver_id' => $original->sender_id,
            'reversed_transaction_id' => $original->id,
        ]);
    }
}
