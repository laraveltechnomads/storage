<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Church;
use App\Models\User;
use DataTables;
use Str;
use DB;
use Carbon\Carbon;
use Session;
use App\Models\ChurchBanner;
use File;


class ChurchBannerController extends Controller
{
    /* Church banner create page*/
    public function bannerCreate($u_type, $church_id)
    {
        $church = Church::find($church_id);
        $data = [
            'u_type' => $u_type,
            'church' => $church
        ];
        return view('banners.create')->with($data);
    }

    /*church banner store  */
    public function bannerStore(Request $request, $u_type, $church_id)
    {
        return $this->createAndUpdateBanner($request, Null, $u_type, $church_id);
    }

    public function createAndUpdateBanner($request, $id = NULL, $u_type, $church_id)
    {
        DB::beginTransaction();
        try
        {   
            
            $serial_number = NULL;
            if($banner = ChurchBanner::find($id))
            {
                $file = $banner->banner_image;
                $old_image = banner_public_path().$banner->banner_image;

                if($request->serial_number)
                {
                    $old = ChurchBanner::where('church_id', $church_id)->where('serial_number', $request->serial_number)->first();
                    if($old)
                    {
                        $old->serial_number = NULL;
                        $old->save();
                    }
                    $serial_number = $request->serial_number;
                }
            }else{
                $file = null;
                $old_image = null;
            }
            

            if ($request->hasFile('banner_image')) {
                $file = uploadFile($request->file('banner_image'), 'banner');
                if($old_image && $banner->banner_image)
                {
                    removeFile($banner->banner_image, 'banner');
                }
            }

            $banner = ChurchBanner::updateOrCreate(
                ['id' => $id],[
                'church_id' => $church_id,
                'banner_image' => $file,
                'serial_number' => $serial_number 
            ]);

            DB::commit();
            if ($banner) {
                if($u_type == 'ADM')
                {
                    return redirect()->route('admin.churches.show', [$church_id])->with('success', 'Banner details save done!');
                }else{
                    return redirect()->route('banners.list', ['u_type' => $u_type, 'church_id' => $church_id])->with('success', 'Banner details save done!');
                }
                return redirect()->back();
            } else {
                return redirect()->back()->with('error', 'Failed to Banner details save! Try again.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }

        return $church;
    }

    /* list  */
    public function bannerList(Request $request, $u_type, $church_id)
    {
        $churchBanner = ChurchBanner::where('church_id', $church_id)->with('church.user')->latest('serial_number')->select('*')->get();
        $data = [
            'u_type' => $u_type,
            'church_id' => $church_id,
            'churchBanner' => $churchBanner
        ];
	  	return view('banners.index')->with($data);
    }

    /* ajax datatable banner list show  */
    public function bannerIndex(Request $request, $u_type, $church_id)
    {
        if ($request->ajax()) {
            
            $data = ChurchBanner::where('church_id', $church_id)->with('church.user')->latest('serial_number')->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('church_name', function($row){
                        return $row->church->church_name;
                    })
                    ->addColumn('banner_image', function($row){
                        if (File::exists(store_banner_path().$row->banner_image)) 
                        { 
                           return '<img src="'.banner_public_path().$row->banner_image.'" width="30px" height="30px">';
                        }
                        return $row->church->church_name;
                    })
                    ->addColumn('action', function($row) use ($u_type, $church_id){
                        $btn = '';

                        $btn .= '<a href="'. route("banners.edit", ['u_type' => $u_type, 'church_id' => $church_id, 'banner_id' => $row->id]).'"  title="Edit"><i class="fa fa-edit"></i></a> &nbsp;';
                        $btn .= '<a class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="fa fa-trash"></i></a>';
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->rawColumns(['banner_image', 'action'])
                    ->make(true);
        }
    }

    /* Church banner edit page*/
    public function bannerEdit($u_type, $church_id, $banner_id)
    {
        $church = Church::find($church_id);
        $banner = ChurchBanner::find($banner_id);
        $data = [
            'u_type' => $u_type,
            'church' => $church,
            'banner' => $banner
        ];
        return view('banners.edit')->with($data);
    }

    /* Church banner update page*/
    public function bannerUpdate(Request $request, $u_type, $church_id, $banner_id)
    {
        $church = Church::find($church_id);
        $banner = ChurchBanner::find($banner_id);
        $data = [
            'u_type' => $u_type,
            'church' => $church,
            'banner' => $banner
        ];
        return $this->createAndUpdateBanner($request, $banner->id, $u_type, $church_id);
    }

    public function bannerDestroy(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $banner = ChurchBanner::find($request->id);
            if(isset($banner))
            {   
                $old_image = banner_public_path().$banner->banner_image;
                if($old_image && $banner->banner_image)
                {
                    removeFile($banner->banner_image, 'banner');
                }
                $banner->forceDelete();
                DB::commit();
                Session::flash('success', 'Banner details delete done!'); 
                return 1;
            }
            Session::flash('error', 'Banner details not deleted!'); 
            return 2; 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Banner details not deleted!'); 
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }
}
