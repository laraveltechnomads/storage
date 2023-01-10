<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use Auth;
use DB;

Class RequiredUtil
{
    public function requiredField($request, $required)
    {
        $data = Validator::make($request,[
            $required => 'required'
        ]);    
        if ($data->fails())
        {
            foreach ($data->messages()->getMessages() as $field_name => $messages)
            {
                return response([
                    'success' => false,
                    'message' => $messages[0],
                    'data' => Config('constants.emptyData'),
                ], config('constants.invalidResponse.statusCode')); 
            }
        }
    }
}