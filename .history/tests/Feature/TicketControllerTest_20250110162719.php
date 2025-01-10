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
     * Test storing a new ticket.
     */
    public function testStoreTicket()
    {
        $user = User::factory()->create();

        // Fake broadcasting
        Broadcast::fake();

        // Acting as the user and sending a post request to create a ticket
        $response = $this->actingAs($user)
            ->post(route('tickets.store'), [
                'brt_code' => 'BRT12345',
                'reserved_amount' => 500,
                'status' => 'active',
                'receiver_id' => $user->id,
            ]);

        // Assert the response
        $response->assertRedirect()
                 ->assertSessionHas('success', 'Ticket created successfully!');

        // Assert the ticket is created in the database
        $this->assertDatabaseHas('tickets', [
            'brt_code' => 'BRT12345',
            'reserved_amount' => 500,
            'status' => 'active',
        ]);

        // Assert broadcasting event was triggered
        Broadcast::assertDispatched(TicketCreated::class, function ($event) use ($user) {
            return $event->ticket->sender_id === $user->id;
        });
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
            return $event->ticket->id === $ticket->id;
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

        // Assert broadcasting event was triggered
        Broadcast::assertDispatched(TicketDeleted::class, function ($event) use ($ticket) {
            return $event->ticket->id === $ticket->id;
        });
    }
}
