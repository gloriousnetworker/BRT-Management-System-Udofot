<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BRT>
 */
class BRTFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brt_code' => $this->faker->unique()->word, // Generate a unique brt_code
            'reserved_amount' => $this->faker->randomNumber(),
            'status' => 'active',
            // Add other fields as needed
        ];
    }
}
