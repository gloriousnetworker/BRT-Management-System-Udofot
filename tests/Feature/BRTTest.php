<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BRT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BRTTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the user can create a BRT.
     *
     * @return void
     */
    public function test_create_brt()
    {
        // Create a user
        $user = User::factory()->create();

        // Get JWT token for the user (ensure you have a login API to get the token)
        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password', // or use a password you defined in the factory
        ])->json('token');

        // Define BRT data
        $brtData = [
            'brt_code' => 'BRT123',
            'reserved_amount' => 500,
            'status' => 'active',
        ];

        // Send POST request with the JWT token
        $response = $this->postJson('/api/brts', $brtData, [
            'Authorization' => "Bearer $token",
        ]);

        // Assert the response status and the BRT is created in the database
        $response->assertStatus(201);
        $this->assertDatabaseHas('brts', $brtData);
    }

    public function test_index_brt()
    {
        // Create a user
        $user = User::factory()->create();

        // Get JWT token for the user
        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->json('token');

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id, 'brt_code' => 'BRT123']);

        // Send GET request with the JWT token
        $response = $this->getJson('/api/brts', [
            'Authorization' => "Bearer $token",
        ]);

        // Assert the response status and that the BRT is returned
        $response->assertStatus(200);
        $response->assertJsonFragment(['brt_code' => $brt->brt_code]);
    }

    public function test_update_brt()
    {
        // Create a user
        $user = User::factory()->create();

        // Get JWT token for the user
        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->json('token');

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id, 'brt_code' => 'BRT123']);

        // Define updated data
        $updatedData = [
            'brt_code' => 'BRT123-UPDATED',
            'reserved_amount' => 600,
            'status' => 'expired',
        ];

        // Send PUT request with the JWT token
        $response = $this->putJson('/api/brts/' . $brt->id, $updatedData, [
            'Authorization' => "Bearer $token",
        ]);

        // Assert the response status and that the BRT was updated in the database
        $response->assertStatus(200);
        $this->assertDatabaseHas('brts', $updatedData);
    }

    public function test_delete_brt()
    {
        // Create a user
        $user = User::factory()->create();

        // Get JWT token for the user
        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->json('token');

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id, 'brt_code' => 'BRT123']);

        // Send DELETE request with the JWT token
        $response = $this->deleteJson('/api/brts/' . $brt->id, [], [
            'Authorization' => "Bearer $token",
        ]);

        // Assert the response status and that the BRT is deleted from the database
        $response->assertStatus(204);
        $this->assertDatabaseMissing('brts', ['id' => $brt->id]);
    }

}
