<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Church;
use App\Models\User;
use App\Models\Event;
use DataTables;
use Str;
use DB;
use Carbon\Carbon;
use Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $church_user_id = $request->church_user_id;
        $user = auth()->user();
        $login = $user->u_type;
        $church_user_id = ($login == 'ADM' ? $church_user_id : $user->id );
        $page = ($login == 'ADM' ? 'admin_church_show' : 'church_all_events');  
        $page2 = 'event_show';  

        $events = Event::latest()->get();
        $ch_member = Auth()->user();
        $church = Church::where('user_id',  $user->id)->first();

        if ($request->ajax()) {
            $data = Event::where('user_id', $user->id)->latest()->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use($church_user_id, $login, $page, $page2){
                        $btn = '';

                        $btn .= '<a href="'. route("events.edit", [$row->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]).'"  title="Edit"><i class="fa fa-edit"></i></a> &nbsp;';
                        $btn .= '<a href="'. route("events.show", [$row->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page2]).'"  title="Show"><i class="fa fa-eye"></i></a> &nbsp;';
                        $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        // $btn .= '<a href="'. route("events.massDestroy", [$row->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]).'"  title="Show"><i class="fa fa-trash"></i></a>';
                        
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->editColumn('description', function($row) {
                        return words($row->description, $words = 5, $end = '...');
                    } )
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('events.index', compact('events', 'church', 'login', 'church_user_id', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $login = $request->login;
        $church_user_id = $request->church_user_id;
        $page = $request->page;
        if(!$login && !$church_user_id && !$page)
        {
            abort('404');
        }
        $church = Church::where('user_id', $church_user_id)->first(); 

        $data = [
            'login' => $login,
            'church_user_id' => $church_user_id,
            'page' => $page,
            'church' => $church
         ];

        return view('events.create')->with($data);
        
        

    }

    /* events details store*/
    public function store(Request $request)
    {
        return self::createAndUpdateEvent($request);
    }

    /* event list Show*/
    public function show($id, Request $request)
    {
        $user_id = auth()->user()->id; 
        $event = Event::find($id);
        if(!$event)
        {
            return redirect()->back();
        }
        $church = Church::where('user_id', $event->user_id)->first(); 

        $login = $request->login;
        $church_user_id = $request->church_user_id;
        $page = $request->page;
        if(!$login && !$church_user_id && !$page)
        {
            abort('404');
        }

        return view('events.show', compact('user_id','event', 'church', 'login', 'church_user_id', 'page'));
    }

    /* event edit*/
    public function edit($id, Request $request)
    {
        $user_id = auth()->user()->id; 
        $event = Event::find($id);
        if(!$event)
        {
            return redirect()->back();
        }
        
        $church =Church::where('user_id', $event->user_id)->first();

        $login = $request->login;
        $church_user_id = $event->user_id;
        $page = $request->page;
        if(!$login && !$church_user_id && !$page)
        {
            abort('404');
        }
        
        return view('events.edit', compact('user_id','event', 'login', 'church_user_id', 'page', 'church'));
    }

    /* event update*/
    public function update(Request $request, $id)
    {
        return self::createAndUpdateEvent($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //
    }

    public function massDestroy($id)
    {
        $event = Event::find($id);
        if(!$event)
        {
            return redirect()->back();
        }
       $event = Event::where('id', $id)->delete();
       return redirect()->back()->with('success', 'Event details Deleted!');
    }


    //unique createAndUpdateEvent
    public function createAndUpdateEvent($request, $id = NULL)
    {
        $login = $request->login;
        $church_user_id = $request->church_user_id;
        $page = $request->page;
        if(!$login && !$church_user_id && !$page)
        {
            abort('404');
        }

        $this->validate($request, [
            'title' => 'required',
            'schedule' => 'required',
            'description' => 'required'
        ]);
        DB::beginTransaction();
        try
        {   
            $event = Event::updateOrCreate(
                ['id' => $id],[
                'user_id' => $request->church_user_id,
                'title' => $request->title,
                'schedule' => date('Y-m-d H:i:s', strtotime($request->schedule)),
                'description' => $request->description
            ]);
            
            if ($event) {
                switch ($page) {
                    case 'admin_church_show':
                        $church = Church::where('user_id', $church_user_id)->first();
                        DB::commit();
                        return redirect()->route('admin.churches.show', [$church->id])->with('success', 'Event details save done!');
                        break;
                    case 'church_all_events':
                        DB::commit();
                        return redirect()->route('events.index')->with('success', 'Event details save done!');
                        break;
                    case 'event_show':
                        DB::commit();
                        return redirect()->route('events.show', [$event->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page])->with('success', 'Event details save done!');
                        break;
                    case 'church_calendar':
                        DB::commit();
                        return redirect()->route('calendar')->with('success', 'Event details save done!');
                        break;
                    case 'admin_calendar':

                        DB::commit();
                        return redirect()->route('calendar')->with('success', 'Event details save done!');
                        break;
                    default:
                        return redirect()->route('/')->with('success', 'Event details save done!');
                }
                DB::commit();
                return redirect()->route('/')->with('success', 'Event details save done!');
            } else {
                return redirect()->back()->with('error', 'Failed to event details save! Try again.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }

        return $church;
    }

    //event Details Destroy
    public function eventDestroy(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $event = Event::where('id', $request->id)->first();
            if(isset($event))
            {
                $event->delete();
                DB::commit();
                Session::flash('success', 'Event details delete done!'); 
                return 1;
            }
            Session::flash('error', 'Event details not deleted!'); 
            return 2; 
        } catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('error', 'Event details not deleted!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }
}