<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing a new ticket.
     */
    // In your TicketController:
public function store(Request $request)
{
    $ticket = Ticket::create($request->all());
    broadcast(new TicketCreated($ticket)); // Ensure you're dispatching TicketCreated here.
    return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
}

public function update(Request $request, Ticket $ticket)
{
    $ticket->update($request->all());
    broadcast(new TicketUpdated($ticket)); // Ensure you're dispatching TicketUpdated here.
    return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully!');
}

public function destroy(Ticket $ticket)
{
    $ticket->delete();
    broadcast(new TicketDeleted($ticket)); // Dispatch TicketDeleted here.
    return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
}


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

    // Assert broadcasting event was triggered (make sure to use TicketDeleted if that is the event)
    Broadcast::assertDispatched(TicketDeleted::class, function ($event) use ($ticket) {
        return $event->ticket->id === $ticket->id;
    });
}
}
