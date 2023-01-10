<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }
    public function contactIndex(Request $request){
        if ($request->ajax()) {
            $data = ContactUs::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {

                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Done</span>';
                    } else {
                        return '<span class="badge badge-info cursor-pointer" data-id = "'.$row->id.'">Pending</span>';
                    } 

                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.contactUs.index');
    }
    public function updateContact($id){
        $contact = ContactUs::find($id);
        if($contact){
            $contact->update(['status' => 1]);
        }
        return response()->json(['msg' => true]);
    }
}
