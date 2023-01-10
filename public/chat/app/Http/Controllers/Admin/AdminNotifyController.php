<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Session;

class AdminNotifyController extends Controller
{
    //all notifications
    public function index(Request $request)
    {
        $userADM = User::where('u_type', 'ADM')->first();
        $admNotifications = $userADM->unreadNotifications()->where('type', 'App\Notifications\UserNewAdd')->paginate(10);
        return view('admin.notifications.index', compact('userADM', 'admNotifications'));
    }

    //deleteNotification
    public function deleteNotification(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $userADM = User::where('u_type', 'ADM')->first();
            $notify = $userADM->notifications->find($request->notification_id);
            if(isset($notify))
            {   
                $notify->delete();
                DB::commit();
                Session::flash('success', 'Notification delete done!'); 
                return redirect()->back();
            }
            Session::flash('error', 'Notification not deleted!'); 
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Notification not deleted!'); 
            return redirect()->back();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }   
    }

    //bellNotifications
    public function bellNotifications(Request $request)
    {
        return view('admin.partials.notify');
    }
}