<?php

namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\Calendar;

Class CalendarUtil
{
    public function ownCalendar($request, $search = NULL)
    {
        $search = $request->search ?? Null;
        $calendarDetail = Calendar::where(function ($query) use ($search) {
            $query->orWhere('title', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%');
        })->where('user_id',auth()->user()->id)->orderBy('updated_at', 'desc')->get();   
        $response = [];
        foreach($calendarDetail as $event){
            $diaryArr = [
                'event_id'    => $event->id,
                'title'       => $event->title,
                'description' => $event->description,
                'schedule'    => $event->schedule,
                'time' => $event->schedule
            ];
            array_push($response, $diaryArr);
        }     
        return $response;
    }
}