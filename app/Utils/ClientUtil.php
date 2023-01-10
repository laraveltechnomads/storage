<?php

namespace App\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use DB;
use App\Models\Client\Client;
use Illuminate\Support\Facades\Validator;


Class ClientUtil
{
    public function isClient($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('client');
        }
        return false;
    }

    /*  validation Email  */
    public function validationEmail($request)
    {
        if(!Client::where('email_address', $request->email_address)->first() )
        {
            if($request->client_id)
            {
                $client = Client::where('email_address', $request->email_address)->where('id', $request->client_id)->first();
                if($client)
                {
                return response()
                    ->json(['success' => '200', 'message' => 'Client email address accepted!', 'data' => [] ])
                    ->withCallback($request->input('callback'));
                }
            }
            $client = Client::where('email_address', $request->email_address)->first();     
            if(!$client)
            {
                return response()
                ->json(['success' => '200', 'message' => 'Client email address accepted!', 'data' => [] ])
                ->withCallback($request->input('callback'));
            }
        }
        return response()
        ->json(['success' => '404', 'message' => $request->email_address .' has already been taken.'])
        ->withCallback($request->input('callback'));
    }

    /*  validation SubDomain  */
    public function validationSubDomain($request)
    {
        if(!Client::where('subdomain', $request->subdomain)->first() )
        {
            if($request->client_id)
            {
                $client = Client::where('subdomain', $request->subdomain)->where('id', $request->client_id)->first();
                if($client)
                {
                return response()
                    ->json(['success' => '200', 'message' => 'Client Subdomain accepted!', 'data' => [] ])
                    ->withCallback($request->input('callback'));
                }
            }
            $client = Client::where('subdomain', $request->subdomain)->first();     
            if(!$client)
            {
                return response()
                ->json(['success' => '200', 'message' => 'Client Subdomain accepted!', 'data' => [] ])
                ->withCallback($request->input('callback'));
            }
        }
        return response()
        ->json(['success' => '404', 'message' => $request->subdomain .' has already been taken.'])
        ->withCallback($request->input('callback'));
    }
}