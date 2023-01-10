<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\WorkUs;
use App\Models\Church;
use DB;
use DataTables;
use Session;

class ContactUsController extends Controller
{
    /* contactIndex */
    public function contactIndex(Request $request)
    {
        $contact = ContactUs::has('user')->with('user')->latest()->select('*')->get();
        if ($request->ajax()) {
            $data = ContactUs::has('user')->with('user')->latest()->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                            $btn .= '<a href="'.route("church.contactus.message.view", [$row->id]).'"  title="Show" class="badge badge-info">View</a> &nbsp;';
                            $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';
                        return $div;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $dataList = array(
            'contact' => $contact,
        );
        return view('church.contactus.list')->with($dataList);
    }

    /* contactMessageView **/
    public function contactMessageView(ContactUs $ContactUs, Request $request)
    {
        $ContactUs = ContactUs::has('user')->with('user')->where('id', $ContactUs->id)->first();
        if(!$ContactUs){
            abort(404);
        }
        $data['contact'] = $ContactUs;
        return view('church.contactus.view')->with($data);
    }

    /* deleteContactUs */
    public function deleteContactUs(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $Contact = ContactUs::has('user')->with('user')->where('id', $request->id)->first();
            if(isset($Contact))
            {
                $Contact->delete();
                Session::flash('success', 'Contact Us details delete done!'); 
                DB::commit();
                return 1;
            }
            Session::flash('error', 'Contact Us details not deleted!'); 
            return 2; 
        } catch (\Throwable $e) {
            DB::rollBack();
            Session::flash('error', 'Contact Us details not deleted!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }


    /*   
    -----------------------------------------------
        workUsIndex
    ----------------------------------------------
    */
    public function workUsIndex(Request $request)
    {
        $contact = WorkUs::has('user')->with('user')->latest()->select('*')->get();
        if ($request->ajax()) {
            $data = WorkUs::has('user')->with('user')->latest()->select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                            $btn .= '<a href="'.route("church.workus.message.view", [$row->id]).'"  title="Show" class="badge badge-info">View</a> &nbsp;';
                            $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';
                        return $div;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $dataList = array(
            'contact' => $contact,
        );
        return view('church.work_with_us.list')->with($dataList);
    }

     /* workUsMessageView **/
     public function workUsMessageView(WorkUs $WorkUs, Request $request)
     {
            $WorkUs = WorkUs::has('user')->with('user')->where('id', $WorkUs->id)->first();
            if(!$WorkUs){
                abort(404);
            }
            $data['workus'] = $WorkUs;
            return view('church.work_with_us.view')->with($data);
     }

     /* deleteWorkWithUs */
     public function deleteWorkWithUs(Request $request)
     {
         DB::beginTransaction();
         try
         {
             $Contact = WorkUs::has('user')->with('user')->where('id', $request->id)->first();
             if(isset($Contact))
             {
                 $Contact->delete();
                 Session::flash('success', 'Contact Us details delete done!'); 
                 DB::commit();
                 return 1;
             }
             Session::flash('error', 'Contact Us details not deleted!'); 
             return 2; 
         } catch (\Throwable $e) {
             DB::rollBack();
             Session::flash('error', 'Contact Us details not deleted!'); 
             return 2;
             $bug = $e->getMessage();
             return redirect()->back()->with('error', $bug);
         }    
     }
}
