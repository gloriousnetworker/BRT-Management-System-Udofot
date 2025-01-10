<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing a new ticket.
     */
    public function testStoreTicket()
    {
        $user = User::factory()->create();

        // Acting as the user and sending a post request to create a ticket
        $response = $this->actingAs($user)
            ->post(route('tickets.store'), [
                'brt_code' => 'BRT12345',
                'reserved_amount' => 500,
                'status' => 'active',
                'receiver_id' => $user->id,
            ]);

        // Check the response for redirect and success message
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket created successfully!');

        // Assert the ticket is created in the database
        $this->assertDatabaseHas('tickets', [
            'brt_code' => 'BRT12345',
            'reserved_amount' => 500,
            'status' => 'active',
        ]);
    }

    /**
     * Test fetching tickets for both admin and regular user.
     */
    public function testIndexTickets()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        Ticket::factory()->create(['receiver_id' => $user->id]);

        // Admin view
        $response = $this->actingAs($admin)
            ->get(route('tickets.index'));
        $response->assertViewHas('tickets');

        // Regular user view
        $response = $this->actingAs($user)
            ->get(route('tickets.index'));
        $response->assertViewHas('tickets');
    }

    /**
     * Test updating a ticket.
     */
    public function testUpdateTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['status' => 'pending']);

        // Acting as the user and updating a ticket
        $response = $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                'brt_code' => 'UpdatedBRT123',
                'reserved_amount' => 700,
                'status' => 'active',
            ]);

        // Check the response for redirect and success message
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket updated successfully!');

        // Assert the ticket is updated in the database
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'brt_code' => 'UpdatedBRT123',
            'reserved_amount' => 700,
            'status' => 'active',
        ]);
    }

    /**
     * Test deleting a ticket.
     */
    public function testDeleteTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        // Acting as the user and deleting a ticket
        $response = $this->actingAs($user)
            ->delete(route('tickets.destroy', $ticket));

        // Check the response for redirect and success message
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket deleted successfully!');

        // Assert the ticket is deleted from the database
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }
}