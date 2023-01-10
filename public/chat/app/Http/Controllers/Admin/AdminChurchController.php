<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Church;
use DataTables;
use Str;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Event;
use Hash;
use App\Http\Controllers\UniqueController;
use Session;
use App\Utils\ChurchUtil;

class AdminChurchController extends Controller
{
    /**
     * Display a listing of the resource.
     * All Utils instance.
     * @return \Illuminate\Http\Response
     */
    protected $churchUtil;
    public function __construct(ChurchUtil $churchUtil)
    {
        $this->churchUtil = $churchUtil;
    }

    public function index(Request $request)
    {
        $church =Church::withTrashed()->first();
        if ($request->ajax()) {
            $data = Church::withTrashed()->take(1)->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        if($row->deleted_at != NULL)
                        {
                            return $row->deleted_at;
                        }
                        return null;
                        
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row->deleted_at != NULL)
                        {
                            $btn .= '<a class="" onclick="statusChange('.$row->id.')" tooltip="Active" title="Active"><i class="fa fa-toggle-on"></i></a>';
                        }else{
                            $btn .= '<a href="'. route("admin.churches.edit", [$row->id]).'"  title="Edit"><i class="fa fa-edit"></i></a> &nbsp;';
                            $btn .= '<a href="'. route("admin.churches.show", [$row->id]).'"  title="Show"><i class="fa fa-eye"></i></a> &nbsp;';
                            $btn .= '<a class="" onclick="statusChange('.$row->id.')" tooltip="Inactive" title="Inactive"><i class="fa fa-toggle-on text-red" ></i></a>';
                        }
                        // $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        // $btn .= '<a href="'. route("admin.church.massDestroy", [$row->id]).'"  title="Delete"><i class="fa fa-trash"></i></a>';
                        
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.churches.index', compact('church'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $church = Church::first();
        if($church)
        {
            return view('admin.churches.edit', compact('church'));
        }
        return view('admin.churches.create');
    }

    //unique createAndUpdateChurch
    public function createAndUpdateChurch($request, $id = NULL)
    {
        DB::beginTransaction();
        try
        {   
            if($church = Church::find($id))
            {
                $file = $church->church_image;
                $old_image = public_path('/storage/church/').$church->church_image;
                $user = User::find($church->user_id);
            }else{
                $file = null;
                $old_image = null;
                $email = $request->email;

                $userCreate = User::Create([
                    'name' => $request->church_name,
                    'email' => $email,
                    'password' => Hash::make($request->password),
                    'u_type' => 'CHR',
                    'uniqid' => strtotime("now"),
                    'email_verified_at' => now()
                ]);
                $user = User::find($userCreate->id);
            }

            if ($request->hasFile('church_image')) {
                $file = uploadFile($request->file('church_image'), 'church');
                if($old_image && $church->church_image)
                {
                    removeFile($church->church_image, 'church');
                }
            }

            $church = Church::updateOrCreate(
                ['id' => $id],[
                'email' => $user->email,
                'password' => ($request->password ? Crypt::encryptString($request->password) : $user->password),
                'uniqid' => $user->uniqid,
                'user_id' => $user->id,
                'church_name' => $request->church_name,
                'location' => $request->location,
                'mobile_number' => $request->mobile_number,
                'website_url' => $request->website_url,
                'church_image' => $file,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            

            if(!Church::find($id))
            {
                self::mailSend($church); 
            }
            DB::commit();
            if ($church) {
                return redirect()->route('admin.churches.index')->with('success', 'Church details save done!');
            } else {
                return redirect()->back()->with('error', 'Failed to church details save! Try again.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
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
    public function show($id, Request $request)
    {
        $user = auth()->user();
        $login = $user->u_type;
        $u_type = $user->u_type;
        $page = 'admin_church_show';

        $church = Church::first();
        $church_id = $church->id;
        $events = Event::latest()->get();
        if ($request->ajax()) {
            $data = Event::where('user_id', $church->user_id)->latest()->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use($church, $login, $page){
                        $btn = '';
                        $btn .= '<a href="'. route("events.edit", [$row->id, "church_user_id" => $church->user_id, "login" => $login, "page" => $page]).'"  title="Edit"><i class="fa fa-edit"></i></a> &nbsp;';
                        $btn .= '<a href="'. route("events.show", [$row->id, 'church_user_id' => $church->user_id, 'login' => $login, 'page' => $page]).'"  title="Show"><i class="fa fa-eye"></i></a> &nbsp;';
                        $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        // $btn .= '<a href="'. route("events.massDestroy", [$row->id, 'church_user_id' => $church->user_id, 'login' => $login, 'page' => $page]).'"  title="Show"><i class="fa fa-trash"></i></a>';
                        
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
        return view('admin.churches.show', compact('church', 'u_type', 'church_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $church = Church::first();
        return view('admin.churches.edit', compact('church'));
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
        $id = null;
        $church = Church::first();
        if($church){
            $id = $church->id;
        }
         
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

    //church delete
    public function churchDestroyDirect($id)
    {
        $churchTable = new UniqueController;
        $church =  $churchTable->churchTable($id);
        return $churchTable->deleteChurchTable($church->user_id);
    }


    // church name details check
    public function churchCheck(Request $request)
    { 
        if ($request->ajax())
        {    
         
            if($request->email)
            {
                return $this->churchUtil->validationEmail($request);
            }
            if($request->latitude)
            {
                return $this->churchUtil->validationLatitude($request);
            }
            if($request->longitude)
            {
                return $this->churchUtil->validationLongitude($request);
            }
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

    public function churchDestroy(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $churchTable = new UniqueController;
            $church =  $churchTable->churchTable($request->id);
            if(isset($church))
            {   
                $churchTable->deleteChurchTable($church->user_id);
                DB::commit();
                Session::flash('success', 'Church details delete done!'); 
                return 1;
            }
            Session::flash('error', 'Church details not deleted!'); 
            return 2; 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Church details not deleted!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }

    // church status change
    public function statusChangeChurchTable(Request $request)
    {
        DB::beginTransaction();
        try {
            $chr = Church::onlyTrashed()->where('id', $request->id)->first();
            if($chr)
            {
                User::withTrashed()->where('id', $chr->user_id)->restore();
                Church::withTrashed()->where('user_id', $chr->user_id)->restore();
                Event::withTrashed()->where('user_id', $chr->user_id)->restore();
                DB::commit();
                Session::flash('success', 'Church status changed done!'); 
            }else{
                $chr = Church::where('id', $request->id)->first();
                if($chr)
                {
                    User::where('id', $chr->user_id)->delete();
                    Church::whereNotIn('user_id', User::pluck('id'))->delete();
                    Event::whereNotIn('user_id', User::pluck('id'))->delete();
                    DB::commit();
                    Session::flash('success', 'Church status changed done!'); 
                }
            }
            return 1;
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            Session::flash('error', 'Church status not changed!'); 
            return 2;
        }
    }
}