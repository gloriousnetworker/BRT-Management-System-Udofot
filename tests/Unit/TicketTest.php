<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a ticket.
     */
    public function testCreateTicket()
    {
        $user = User::factory()->create();
        $ticket = Ticket::create([
            'sender_id' => $user->id,
            'receiver_id' => $user->id,
            'brt_code' => 'BRT98765',
            'reserved_amount' => 1000,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('tickets', [
            'brt_code' => 'BRT98765',
            'reserved_amount' => 1000,
            'status' => 'active',
        ]);
    }

    /**
     * Test ticket relationships (sender and receiver).
     */
    public function testTicketRelationships()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $ticket = Ticket::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'brt_code' => 'BRT98765',
            'reserved_amount' => 1000,
            'status' => 'active',
        ]);

        // Assert the ticket sender relationship
        $this->assertEquals($sender->id, $ticket->sender->id);
        // Assert the ticket receiver relationship
        $this->assertEquals($receiver->id, $ticket->receiver->id);
    }

    /**
     * Test the broadcasting functionality of ticket events.
     */
    public function testTicketBroadcasting()
    {
        // Test event broadcasting when creating a ticket
        $this->expectsEvents(TicketCreated::class);

        $user = User::factory()->create();
        Ticket::create([
            'sender_id' => $user->id,
            'receiver_id' => $user->id,
            'brt_code' => 'BRT98765',
            'reserved_amount' => 1000,
            'status' => 'active',
        ]);
    }
}
