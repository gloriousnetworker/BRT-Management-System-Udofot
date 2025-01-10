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

        $this->actingAs($user)
            ->post(route('tickets.store'), [
                'brt_code' => 'BRT12345',
                'reserved_amount' => 500,
                'status' => 'active',
                'receiver_id' => $user->id,
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Ticket created successfully!');

        $this->assertDatabaseHas('tickets', [
            'brt_code' => 'BRT12345',
            'reserved_amount' => 500,
            'status' => 'active',
        ]);
    }

    /**
     * Test fetching tickets.
     */
    public function testIndexTickets()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        Ticket::factory()->create(['receiver_id' => $user->id]);

        // Admin view
        $this->actingAs($admin)
            ->get(route('tickets.index'))
            ->assertViewHas('tickets');

        // User view
        $this->actingAs($user)
            ->get(route('tickets.index'))
            ->assertViewHas('tickets');
    }

    /**
     * Test updating a ticket.
     */
    public function testUpdateTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['status' => 'pending']);

        $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                'brt_code' => 'UpdatedBRT123',
                'reserved_amount' => 700,
                'status' => 'active',
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Ticket updated successfully!');

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

        $this->actingAs($user)
            ->delete(route('tickets.destroy', $ticket))
            ->assertRedirect()
            ->assertSessionHas('success', 'Ticket deleted successfully!');

        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }
}
