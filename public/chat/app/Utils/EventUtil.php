<?php 

namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\Church;
use App\Models\Event;

Class EventUtil
{
    public function appUserEvents($church_id)
    {
        return $eventsList = Event::whereHas('church', function ($q) use ($church_id) {
            $q->where('id', $church_id);
        } )->get();
    }
}