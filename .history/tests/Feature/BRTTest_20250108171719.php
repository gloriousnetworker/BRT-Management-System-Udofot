<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BRT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
        $user = User::factory()->create();
        $this->actingAs($user); // Log the user in

        // Define BRT data
        $brtData = [
            'brt_code' => 'BRT123',
            'reserved_amount' => 500,
            'status' => 'active',
        ];

        // Send POST request to create a new BRT
        $response = $this->postJson('/api/brts', $brtData);

        // Assert the response status and the BRT is created in the database
        $response->assertStatus(201);
        $this->assertDatabaseHas('brts', $brtData);
    }

    /**
     * Test the user can retrieve all their BRTs.
     *
     * @return void
     */
    public function test_index_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id]);

        // Send GET request to retrieve the user's BRTs
        $response = $this->getJson('/api/brts');

        // Assert the response status and that the BRT is returned
        $response->assertStatus(200);
        $response->assertJsonFragment(['brt_code' => $brt->brt_code]);
    }

    /**
     * Test the user can update a BRT.
     *
     * @return void
     */
    public function test_update_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id]);

        // Define updated data
        $updatedData = [
            'brt_code' => 'BRT123-UPDATED',
            'reserved_amount' => 600,
            'status' => 'expired',
        ];

        // Send PUT request to update the BRT
        $response = $this->putJson('/api/brts/' . $brt->id, $updatedData);

        // Assert the response status and that the BRT was updated in the database
        $response->assertStatus(200);
        $this->assertDatabaseHas('brts', $updatedData);
    }

    /**
     * Test the user can delete a BRT.
     *
     * @return void
     */
    public function test_delete_brt()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BRT associated with the user
        $brt = BRT::factory()->create(['user_id' => $user->id]);

        // Send DELETE request to remove the BRT
        $response = $this->deleteJson('/api/brts/' . $brt->id);

        // Assert the response status and that the BRT is deleted from the database
        $response->assertStatus(204);
        $this->assertDatabaseMissing('brts', ['id' => $brt->id]);
    }
}
