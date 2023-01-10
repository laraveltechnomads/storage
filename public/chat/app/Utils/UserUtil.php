<?php
namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\Church;
use App\Models\Event;

Class UserUtil
{
    public function user($user_id = NULL)
    {
        return $user = User::where('id', $user_id)->where('u_type', 'USR')->first();
        return  $church = Church::whereHas('event')->whereHas('appUser')->with('event', 'appUser')->first();        
    }

    public function church($user_id = NULL)
    {
        $user_id = $user_id ?? auth()->user()->id;
       return $church = Church::whereHas('appUser')->with('appUser', function($q) use($user_id) {
            $q->where('id', $user_id);
         })->whereHas('event')->with('event')->first();
    }

    public function referenceUser($reference_name = NULL)
    {
        return $user = User::where('name', $reference_name)->where('u_type', 'USR')->first();    
    }
}