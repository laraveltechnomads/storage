<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Song;
use App\Models\User;
use DataTables;
use Str;
use DB;
use Session;

class AdminSongsController extends Controller
{
    /** all songs list. */
    public function index(Request $request)
    {
        $song = Song::latest()->get();

        if ($request->ajax()) {
            $data = Song::latest()->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'. route("admin.songs.edit", [$row->id]).'" tooltip="Edit"><i class="fa fa-edit"></i></a> &nbsp;';
                        $btn .=  '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.songs.index', compact('song'));
    }

    /* song create page */
    public function create()
    {
        return view('admin.songs.create');
    }

    //unique createAndUpdateSong
    public function createAndUpdateSong($request, $id = NULL)
    {
        DB::beginTransaction();
        try
        {
            $song = Song::updateOrCreate(
                ['id' => $id],[
                'song_name' => $request->song_name,
                'song_link' => $request->song_link
            ]);
            DB::commit();
            if ($song) {
                return redirect()->route('admin.songs.index')->with('success', 'Song details save done!');
            } else {
                return redirect()->back()->with('error', 'Failed to song details save! Try again.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }

        
        return $song;
    }

    /** song create */
    public function store(Request $request)
    {
        return self::createAndUpdateSong($request);
    }
    

    /* song details show*/
    public function show($id)
    {
        //
    }

    /** edit song */
    public function edit($id)
    {
        $song = Song::find($id);
        return view('admin.songs.edit', compact('song'));
    }

    /* song update */
    public function update(Request $request, $id)
    {
        
        return self::createAndUpdateSong($request, $id);
    }

    /* song remove */
    // public function destroy($id)
    // {
    //     //
    // }

    //song Details Destroy
    public function songDestroy(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $song = Song::where('id', $request->id)->first();
            if(isset($song))
            {
                $song->delete();
                DB::commit();
                Session::flash('success', 'Song details delete done!'); 
                return 1;
            }
            Session::flash('error', 'Song details not deleted!'); 
            return 2; 
        } catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('error', 'Song details not deleted!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }


    // song name details check
    public function songCheck(Request $request)
    { 
        if ($request->ajax())
        {       
            if($request->song_id)
            {
                $song = Song::where('song_name', $request->song_name)->where('id', $request->song_id)->first();
                if($song)
                {
                   return response()
                    ->json(['status' => '200', 'message' => 'Song name accepted!', 'data' => [] ])
                    ->withCallback($request->input('callback'));
                }
            }
            $song = Song::where('song_name', $request->song_name)->first();     
            if(!$song)
            {
                return response()
                ->json(['status' => '200', 'message' => 'Song name accepted!', 'data' => [] ])
                ->withCallback($request->input('callback'));
            }
           return response()
            ->json(['status' => '404', 'message' => $request->song_name .' has already been taken.'])
            ->withCallback($request->input('callback'));
        }
    }
}
