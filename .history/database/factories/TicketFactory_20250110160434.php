<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        // Get a random user for sender and receiver
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        return [
            'brt_code' => $this->faker->unique()->word(), // Unique BRT code
            'reserved_amount' => $this->faker->randomFloat(2, 10, 1000), // Random reserved amount between 10 and 1000
            'status' => $this->faker->randomElement(['active', 'expired', 'pending']), // Random status
            'sender_id' => $sender->id, // Sender is a valid user
            'receiver_id' => $receiver->id, // Receiver is a valid user
        ];
    }
}
