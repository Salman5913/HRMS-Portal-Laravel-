<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;
use Log;
class TicketChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $username;
    public $message;
    public $login_user_id;
    public $ticket_id;
    /**
     * Create a new event instance.
     */
    public function __construct($username, $message,$login_user_id,$ticket_id)
    {
        $this->username = $username;
        $this->message = $message;
        $this->login_user_id = $login_user_id;
        $this->ticket_id = $ticket_id;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat'.$this->ticket_id);
    }
    public function broadcastAs()
    {
        return 'ticketchat';
    }
}
