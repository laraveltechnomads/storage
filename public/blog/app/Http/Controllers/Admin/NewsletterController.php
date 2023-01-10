<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{

    /* all newsltters list show*/
    public function index(Request $request) {
        $newsletter = Newsletter::select('*')->orderBy('created_at','DESC')->get();
        $data = [
            'newsletter' => $newsletter
        ];
        return view('admin.newsletter.index')->with($data);
    }


    /* newsltter list ajax datatable list*/
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Newsletter::select('*')
            ->orderBy('created_at','DESC')->get();;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {

                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">InActive</span>';
                    }

                })
                ->addColumn('action', function ($row) {
                    
                    return '<div>
                        <a href="javascript:void(0)" data-id="' . encrypt($row->id) . '" data-href="' . route("admin.newsletter.destroy", [encrypt($row->id)]) . '"  data-target="#confirm-delete" data-toggle="modal">
                            <i class="ml-2 fas fa-trash-alt click_me" style="color:black;font-size:20px;font-weight:normal;"></i>
                            </a>
                    </div>';

                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    /* selected newsltter destroy */
    public function destroy($id) {
        $find_cat = Newsletter::find(decrypt($id));
        if($find_cat)
        {
            $find_cat->delete();
            return redirect()->route('admin.newsletter.index')->with('success', 'Delete successfully.');
        }
        return 0;
    }
}
