namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Get all tickets for the authenticated admin or user.
     */
    public function index()
    {
        $tickets = Auth::user()->is_admin
            ? Ticket::all() // Admin sees all tickets
            : Ticket::where('receiver_id', Auth::id())->get(); // Users see their tickets

        return response()->json($tickets);
    }

    /**
     * Update a ticket by ID.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Only allow the ticket's receiver or admin to update
        if (Auth::id() === $ticket->receiver_id || Auth::user()->is_admin) {
            $ticket->update($request->validate([
                'brt_code' => 'nullable|string|max:255',
                'reserved_amount' => 'nullable|numeric|min:0',
                'status' => 'nullable|string|in:active,expired,pending',
            ]));

            return response()->json(['message' => 'Ticket updated successfully!', 'ticket' => $ticket]);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Delete a ticket by ID.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Only allow the ticket's receiver or admin to delete
        if (Auth::id() === $ticket->receiver_id || Auth::user()->is_admin) {
            $ticket->delete();

            return response()->json(['message' => 'Ticket deleted successfully!']);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
