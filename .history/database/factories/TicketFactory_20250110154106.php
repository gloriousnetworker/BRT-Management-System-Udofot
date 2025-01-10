<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'brt_code' => $this->faker->unique()->word(),
            'reserved_amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['active', 'expired', 'pending']),
            'receiver_id' => 1, // Replace with valid user ID in testing
        ];
    }
}
