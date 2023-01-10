<?php

namespace App\Http\Controllers\API\V1\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendSMSController extends Controller
{
    public function index()
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('key', 'secret');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '9181600*****',
            'from' => 'Nexmo',
            'text' => 'A text message sent using the Nexmo SMS API'
        ]);

        dd('message send successfully');
    }
}
