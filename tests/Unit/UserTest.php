<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\BRT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a user has many BRTs.
     *
     * @return void
     */
    public function test_user_has_many_brts()
    {
        $user = User::factory()->create(); // Create a user
        $brt = BRT::factory()->create(['user_id' => $user->id, 'brt_code' => 'BRT123']); // Create a BRT associated with the user

        // Assert that the user has BRTs
        $this->assertTrue($user->brts->contains($brt));
    }

    /**
     * Test if a user is authenticated.
     *
     * @return void
     */
    public function test_user_authentication()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Assert that the user is authenticated
        $this->assertAuthenticatedAs($user);
    }
}
