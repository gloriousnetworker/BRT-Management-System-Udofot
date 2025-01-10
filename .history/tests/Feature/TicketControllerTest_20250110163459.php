<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Events\TicketDeleted;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching tickets for both admin and regular user.
     */
    public function testIndexTickets()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['receiver_id' => $user->id]);

        // Admin view
        $response = $this->actingAs($admin)
            ->get(route('tickets.index'));
        $response->assertViewHas('tickets');
        $response->assertStatus(200);

        // Regular user view
        $response = $this->actingAs($user)
            ->get(route('tickets.index'));
        $response->assertViewHas('tickets');
        $response->assertStatus(200);
    }

    /**
     * Test updating a ticket.
     */
    public function testUpdateTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['status' => 'pending']);

        // Fake broadcasting
        Broadcast::fake();

        // Acting as the user and updating a ticket
        $response = $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                'brt_code' => 'UpdatedBRT123',
                'reserved_amount' => 700,
                'status' => 'active',
            ]);

        // Assert the response
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket updated successfully!');

        // Assert the ticket is updated in the database
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'brt_code' => 'UpdatedBRT123',
            'reserved_amount' => 700,
            'status' => 'active',
        ]);

        // Assert broadcasting event was triggered
        Broadcast::assertDispatched(TicketUpdated::class, function ($event) use ($ticket) {
            return $event->ticketId === $ticket->id;  // Check for the correct ticket ID
        });
    }

    /**
     * Test deleting a ticket.
     */
    public function testDeleteTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        // Fake broadcasting
        Broadcast::fake();

        // Acting as the user and deleting a ticket
        $response = $this->actingAs($user)
            ->delete(route('tickets.destroy', $ticket));

        // Assert the response
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket deleted successfully!');

        // Assert the ticket is deleted from the database
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);

        // Assert broadcasting event was triggered (ensure you have the correct event, TicketDeleted)
        Broadcast::assertDispatched(TicketDeleted::class, function ($event) use ($ticket) {
            return $event->ticketId === $ticket->id;  // Check for the correct ticket ID
        });
    }

    /**
     * Test storing a new ticket.
     */
    public function testStoreTicket()
    {
        $user = User::factory()->create();

        // Fake broadcasting
        Broadcast::fake();

        // Acting as the user and storing a new ticket
        $response = $this->actingAs($user)
            ->post(route('tickets.store'), [
                'brt_code' => 'BRT123',
                'reserved_amount' => 500,
                'status' => 'active',
                'receiver_id' => 2, // Assuming user with ID 2 exists
            ]);

        // Assert the response
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket created successfully!');

        // Assert the ticket is in the database
        $this->assertDatabaseHas('tickets', [
            'brt_code' => 'BRT123',
            'reserved_amount' => 500,
            'status' => 'active',
        ]);

        // Assert broadcasting event was triggered
        Broadcast::assertDispatched(TicketCreated::class, function ($event) {
            return $event->ticket->brt_code === 'BRT123';  // Check for the correct ticket
        });
    }
}
