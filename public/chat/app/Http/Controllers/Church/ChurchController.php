<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Church;
use Auth;
use App\Models\User;
use DB;
use Hash;

class ChurchController extends Controller
{
    public function dashboard()
    {
        return view('church.dashboard.index');
    }

    public function index(Request $request)
    {
	    $church = User::with('church')->find(Auth::user()->id);
	  	
        if ($request->ajax()) {
            $data = Church::latest()->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        $btn .= '<a href="'. route("admin.churches.edit", [$row->id]).'"  title="Edit"><i class="fa fa-edit"></i></a>';
                        
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('church.churches.index', compact('church'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('church.churches.create');
    }

    //unique createAndUpdateChurch
    public function createAndUpdateChurch($request, $id = NULL)
    {
        DB::beginTransaction();
        try
        {   
            if($church = Church::find($id))
            {
                $name = $church->church_image;
                $email = $church->email;
                $user_id = $church->user_id;
                $old_image = asset('storage/church').'/'.$church->church_image;
            
                if ($request->hasFile('church_image')) {
                    $image = $request->file('church_image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/storage/church/');
                    $image->move($destinationPath, $name);

                    if($old_image && isset($old_image) && file_exists($old_image)){
                        unlink($old_image);
                    };
                    $church->church_image = $name;
                }
                $church->church_name = $request->church_name;
                $church->latitude = $request->latitude;
                $church->longitude = $request->longitude;
                $church->location = $request->location;
                $church->mobile_number = $request->mobile_number;
                $church->website_url = $request->website_url;
                
                if($request->password)
                {
                    User::where('id', $church->user_id)->update(['password' => Hash::make($request->password)]);
                }

                $church->update();
                DB::commit();
                return redirect()->route('church.edit')->with('success', 'Church details save done!');
            }
            return redirect()->back()->with('error', 'Failed to church details save! Try again.');  
        } catch (\Throwable $th) {
            
            DB::rollBack();
            $bug = $th->getMessage();
            return redirect()->back()->with('error', $bug);
        }

        return $church;
    }

    /** Church create */
    public function store(Request $request)
    {
        return self::createAndUpdateChurch($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $church = Church::find(auth()->user()->church->id);
        return view('church.churches.show', compact('church'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    	$church = auth()->user()->church;
        return view('church.churches.edit', compact('church'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return self::createAndUpdateChurch($request, $id);
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


    // church name details check
    public function churchCheck(Request $request)
    { 
        if ($request->ajax())
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
    }


    public static function mailSend($church)
    {
        if($church->email)
        {
            $details = [
                'title' => 'Church Details Added!',
                'body' => 'This is for loan application payment.',
                'subject' => 'New Church Details Added!',
                'church' => $church
            ];

            \Mail::to($church->email)->send(new \App\Mail\ChurchMAil($church));
        }
    }
}
