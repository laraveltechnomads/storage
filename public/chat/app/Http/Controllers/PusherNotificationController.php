<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Events\AlertEvent;

class PusherNotificationController extends Controller
{
    public function notification()
    {
        $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'), 
            $options
        );
        $data = array(
            'title' => 'New User',
            'icon' => '',
            'image' => '',
            'text1' => 'there is a new User',
            'linkurl'=> route('/')
        );
        $data['message'] = 'Hello Pusher';
        // $pusher->trigger('biblelaravel', 'App\\Events\\Notify', $data);  
        event(new AlertEvent($data));
    }
}
