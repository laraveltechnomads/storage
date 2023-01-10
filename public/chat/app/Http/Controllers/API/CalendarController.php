<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Utils\ChurchUtil;
use App\Utils\UserUtil;
use App\Utils\EventUtil;
use App\Utils\CalendarUtil;
use DB;

class CalendarController extends Controller
{
    protected $churchUtill;
    protected $userUtill;
    protected $eventUtill;
    protected $calendarUtil;

    public function __construct(ChurchUtil $churchUtill, UserUtil  $userUtill, EventUtil $eventUtill, CalendarUtil $calendarUtil)
    {
        $this->churchUtill = $churchUtill;
        $this->userUtill = $userUtill;
        $this->eventUtill = $eventUtill; 
        $this->calendarUtil = $calendarUtil;
    }

    //user selected church events  
    public function userChurchEvents()
    {        
        $response = $this->eventUtill->appUserEvents(auth()->user()->church_id);

        foreach($response as $key =>  $event){
            $event['isFavourite'] = FavouriteCheckHelper(config('constants.favourite.calendar_events.key'), $event->id);
        }

        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$response,
        ], config('constants.validResponse.statusCode'));
        
    }

    //church list and events
    public function churchCalendar(Request $request)
    {        
        $search = $request->search ?? Null;     
        $filter = $request->filter ?? Null;
      
        $response = $this->churchUtill->churchCalendar(auth()->user()->church_id, $search, $filter);
        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$response,
        ], config('constants.validResponse.statusCode'));
        
    }

    public function list(Request $request)
    {  
        $response = $this->calendarUtil->ownCalendar($request);
        return response([
            'success' => true,
            'message' => 'success',
            'data' =>$response,
        ], config('constants.validResponse.statusCode'));
    }

    public function create(Request $request) {
        DB::beginTransaction();
        try {

            $is_created = Calendar::create([
                'user_id'     => auth()->user()->id,
                'title'       => $request->title,
                'description' => $request->description,
                'schedule'    => $request->schedule,
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Calendar event created successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function update(Request $request) {
        DB::beginTransaction();
        try {
            Calendar::where('id', $request->event_id)->update([
                'title'       => $request->title,
                'description' => $request->description,
                'schedule'    => $request->schedule,
                'updated_at' =>Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Calendar event updated successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    public function delete(Request $request) {
        DB::beginTransaction();
        try {
            Calendar::where('id', $request->event_id)->delete();
            DB::commit();
            return response()->json([
                'message' => 'Calendar event deleted successfully.',
                'data'    => Config('constants.emptyData'),
            ], Config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }



    

}
