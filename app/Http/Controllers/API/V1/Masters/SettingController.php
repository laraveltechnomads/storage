<?php

namespace App\Http\Controllers\API\V1\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function sendMail()
    {
        try
        {
            //Set mail configuration
            setMailConfig();

            $data = ['name' => "Testing Name"];

            Mail::send(['text' => 'mail'], $data, function ($message)
            {
                $message->to('abc@gmail.com', 'Lorem Ipsum')
                    ->subject('Laravel Basic Testing Mail');
                $message->from('xyz@gmail.com', $data['name']);
            });

            // Mail::send('emails.verification', ['otp' => $otp, 'email' => $request->email], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });
            return 'success mail';
            
        }
        catch(\Exception $e)
        {
            return $e;
        }
    }
}
