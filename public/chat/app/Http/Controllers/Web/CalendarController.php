<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Church;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
	public $sources = [
        [
            'model'      => '\\App\\Models\\Event',
            'date_field' => 'schedule',
            'field'      => 'title',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'events.edit',
        ],
    ];

    public function calendarShow(Request $request)
    {   
        Event::whereNotIn('user_id', User::pluck('id'))->forceDelete();
    	$user = auth()->user();
        $login = $user->u_type;
        $church_user_id = ($login == 'ADM' ? 0 : $user->id );
        $page = ($login == 'ADM' ? 'admin_calendar' : 'church_calendar');  

        $church = Church::where('user_id', $church_user_id)->get();
   		$eventsList = Event::where('user_id', 'church_user_id')->get();

        $loging_user_id = NULL;
        if($church_user_id != 0)
        {
            $loging_user_id = $church_user_id;
        }
        $loging_user_id;
 
        $events = [];
        foreach ($this->sources as $source) {
        	$source;
            // $calendarEvents = $source['model']::when(request('event_id') && $source['model'] == '\App\Models\Event', function($query) {
            //     return $query->where('event_id', request('event_id'));
            // })->get();
            $calendarEvents = $source['model']::whereIn('user_id', User::pluck('id'))->when($loging_user_id && $source['model'] == '\App\Models\Event', function($query) use($loging_user_id) {
                return $query->whereIn('user_id', [$loging_user_id]);
            })->get();
            foreach ($calendarEvents as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                if (!$crudFieldValue) {
                    continue;
                }
                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    'url'   => route($source['route'], [ $model->id, 'church_user_id' => $model->user_id, 'login' => $login, 'page' => $page]),
                ];
            //    return $events;
                // return  count($events);
            }
            // return $events;
            // return  count($events);
        }
        $events;
        // return count($events);

        return view('events.calendar', compact('church', 'eventsList', 'events') );
    }
}
