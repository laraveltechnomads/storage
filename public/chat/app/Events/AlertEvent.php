<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $title;
    public $icon;
    public $image;
    public $linkurl;
    
    public function __construct($title,$message, $icon='', $image= '', $linkurl='')
    {
        $this->message = $message;
        $this->title = $title;
        $this->icon = $icon;
        $this->image = $image;
        $this->linkurl = $linkurl;
        $title = 'User Created';
        $icon = logo_pic_path();
        $image = '';
        $message = $user->name . ' : User created.';
        $linkurl= route("admin.users.show", [$user->id]);
        pushNotificationToAdmin($title, $message, $icon, $image,$linkurl);
    }

    public function broadcastOn()
    {
        return new PrivateChannel(env('PUSHER_APP_CHANNELNAME') );
    }

    public function broadcastAs()
    {
        return env('PUSHER_APP_EVENTNAME');
    }
}
