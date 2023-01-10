<?php

namespace App\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\Church;
use Illuminate\Support\Facades\Validator;

Class ChurchUtil
{
    public function churchCalendar($church_id, $search = NULL, $filter = NULL)
    {
        if(!$filter)
        {
            return $events = Church::where('id', $church_id)->whereHas('event', function ($query) use ($search){
                $query->where('title', 'like', '%'.$search.'%');
            })->with('event', function ($query) use ($search){
                $query->where('title', 'like', '%'.$search.'%');
            })->get();
        }

        return $events = Church::where('id', $church_id)->whereHas('event', function ($query) use ($search, $filter){
            $query->where('title', 'like', '%'.$search.'%')
            ->whereBetween('schedule', [$filter." 00:00:00",$filter." 23:59:59"]);
        })->with('event', function ($query) use ($search, $filter){
            $query->where('title', 'like', '%'.$search.'%')
            ->whereBetween('schedule', [$filter." 00:00:00",$filter." 23:59:59"]);
        })->get();

        $response = [];
        foreach($diaryDetail as $diary){

            $diaryArr = [
                'diary_id'    => $diary->id,
                'title'       => $diary->title,
                'description' => $diary->description,
                'image'       => responseMediaLink($diary->image,'diary'),
                'created_at'  => $diary->created_at
            ];
            array_push($response, $diaryArr);
        }
    }

    /*  validation latitude */
    public function validationEmail($request)
    {
        if(!User::where('email', $request->email)->first() )
        {
            if($request->church_id)
            {
                $church = Church::where('email', $request->email)->where('id', $request->church_id)->first();
                if($church)
                {
                return response()
                    ->json(['status' => '200', 'message' => 'Church email accepted!', 'data' => [] ])
                    ->withCallback($request->input('callback'));
                }
            }
            $church = Church::where('email', $request->email)->first();     
            if(!$church)
            {
                return response()
                ->json(['status' => '200', 'message' => 'Church email accepted!', 'data' => [] ])
                ->withCallback($request->input('callback'));
            }
        }
        return response()
        ->json(['status' => '404', 'message' => $request->email .' has already been taken.'])
        ->withCallback($request->input('callback'));
    }
    /*  validation latitude */
    public function validationLatitude($request)
    {
        $validator = Validator::make($request->all(),[
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['status' => '404', 'message' => 'The latitude format is invalid.'])
                ->withCallback($request->input('callback'));
        }
        return response()
                ->json(['status' => '200', 'message' => '', 'data' => [] ])
                ->withCallback($request->input('callback'));
    } 

    /*  validation latitude */
    public function validationLongitude($request)
    {
        $validator = Validator::make($request->all(),[
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['status' => '404', 'message' => 'The longitude format is invalid.'])
                ->withCallback($request->input('callback'));
        }
        return response()
                ->json(['status' => '200', 'message' => '', 'data' => [] ])
                ->withCallback($request->input('callback'));
    } 
}