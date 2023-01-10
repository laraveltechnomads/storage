<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Str;
use DB;
use Session;
use App\Models\User;
use App\Http\Controllers\UniqueController;
use File;

class AdminUserController extends Controller
{
    /** All Users List */
    public function index(Request $request)
    {
        $userTable = new UniqueController;
        $users = $userTable->allUserList();

        if ($request->ajax()) {
            $data = User::withTrashed()->whereIn('u_type', ['USR'])->with('churchData')->latest()->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        if($row->email_verified_at != NULL)
                        {
                            return $row->deleted_at;
                        }
                        return 0;
                        
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'. route("admin.users.show", [$row->id]).'"  title="Show"><i class="fa fa-eye"></i></a> &nbsp;';
                        if($row->email_verified_at != NULL)
                        {
                            if($row->deleted_at != NULL)
                            {
                                $btn .= '<a class="" onclick="statusChange('.$row->id.')" tooltip="InActive" title="Inactive"><i class="fa fa-toggle-on text-red" ></i></a>';
                            }else{
                                $btn .= '<a class="" onclick="statusChange('.$row->id.')" tooltip="Active" title="Active"><i class="fa fa-toggle-on"></i></a>';
                            }
                        }

                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userTable = new UniqueController;
        $user =  $userTable->userTable($id);
        $userADM = \App\Models\User::find(1);
        foreach ($userADM->unreadNotifications as $notification) {
            if($notification->type == 'App\Notifications\UserNewAdd') {
                if($notification->data['user_id'] == $user->id){
                    $notification->markAsRead();
                }
            }
        }

        $existImage = storage_path() . '/app/public/pics/' .$user->pic;
        if (File::exists($existImage)) {
            $image = $existImage;
        }else{
            $image = NULL;
        }
        
        return view('admin.users.show', compact('user', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function userStatus(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $userTable = new UniqueController;
            $user =  $userTable->userTable($request->id);
            if(isset($user))
            {   
                if($user->deleted_at != NULL)
                {
                    $user->restore();
                }else{
                    $user->delete();
                }
                DB::commit();
                Session::flash('success', 'User status change done!'); 
                return 1;
            }
            Session::flash('error', 'User status not changed!'); 
            return 2; 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'User status not changed!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }
}
