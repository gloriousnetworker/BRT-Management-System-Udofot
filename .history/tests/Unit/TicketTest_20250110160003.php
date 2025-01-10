<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTicket()
{
    $user = User::factory()->create();  // Create a user to act as the sender

    // Ensure user is authenticated
    $this->actingAs($user)
        ->post(route('tickets.store'), [
            'brt_code' => 'BRT12345',
            'reserved_amount' => 500,
            'status' => 'active',
            'receiver_id' => $user->id,  // You can change this to another user if needed
        ])
        ->assertRedirect()
        ->assertSessionHas('success', 'Ticket created successfully!');

    $this->assertDatabaseHas('tickets', [
        'brt_code' => 'BRT12345',
        'reserved_amount' => 500,
        'status' => 'active',
        'sender_id' => $user->id,  // Ensure sender_id is checked
    ]);
}


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
     * Test ticket relationships.
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

        $this->assertEquals($sender->id, $ticket->sender->id);
        $this->assertEquals($receiver->id, $ticket->receiver->id);
    }
}
