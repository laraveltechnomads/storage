<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $username;
    public $data;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

        $userADM = User::where('u_type', 'ADM')->first();
        $count = $userADM->unreadNotifications()->count();
        $this->count = $count;
        // $this->username = $username;
        // $this->message  = "{$username} liked your status";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return env('PUSHER_APP_CHANNELNAME');
    }

    public function broadcastAs()
    {
        return env('PUSHER_APP_EVENTNAME');
    }
}
