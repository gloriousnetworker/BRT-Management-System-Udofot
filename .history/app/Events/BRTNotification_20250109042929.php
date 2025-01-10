namespace App\Events;

use App\Models\BRT;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BRTNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $brt;

    public function __construct($message, BRT $brt)
    {
        $this->message = $message;
        $this->brt = $brt;
    }

    public function broadcastOn()
    {
        return new Channel('brt-channel'); // Channel name
    }

    public function broadcastAs()
    {
        return 'brt-event'; // Event name
    }
}
