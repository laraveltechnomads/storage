<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlackList;
use App\Models\User;
use DB;
use File;

class BlackListController extends Controller
{
    /* send Member Black List Add */
    public function addAndRemoveBlackList(Request $request)
    {
        DB::beginTransaction();
        try {
            $member_id = $request->member_id;

            $church_member = User::query();
            $church_member->where('id', '!=', auth()->user()->id);
            $church_member->where('id', $member_id);
            $church_member =$church_member->first();
            if($church_member)
            {
                $blackList = BlackList::where('member_id', $church_member->id)->where('user_id', auth()->user()->id)->first();
                if($blackList)
                {
                    $blackList->forceDelete();
                }else{
                    BlackList::create([
                        'member_id' => $church_member->id,
                        'user_id' => auth()->user()->id
                    ]);
                }
                
                DB::commit();

                $blackList = BlackList::where('member_id', $church_member->id)->where('user_id', auth()->user()->id)->first();
                if($blackList)
                {   
                    $message = 'added';
                }else{
                    $message = 'remove';
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Black list '. $message.' successfully',
                    'data' => Config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return response()->json([
                'success' => false,
                'message' => 'Not a Member',
                'data' => Config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }
    }

    /*  get Black List*/
    public function getBlackList(Request $request)
    {
        // $blackList = BlackList::query();
        // $blackList->where('user_id', auth()->user()->id)->select('member_id');
        // $blackList->with('member_black')->whereHas('member_black');
        // $blackList = $blackList->get();
        
        $blackListusers = User::query();
        $blackListusers->select('id', 'name', 'first_name', 'last_name', 'church_id', 'pic', 'uniqid');
        $blackListusers->whereHas('black_list');
        $blackListusers = $blackListusers->get();

        $blackListusersShow = [];
        if($blackListusers)
        {
            foreach ($blackListusers as $key => $member) {

                $existImage = store_pic_path(). $member->pic;
                if (File::exists($existImage)) {
                    $member->pic = profile_pic_path().$member->pic;
                }

                $mList = [
                    'member_id'=> $member->id,
                    'church_id' => $member->church_id,
                    'member_name'=>$member->name,
                    'member_first_name'=>$member->first_name,
                    'member_last_name'=>$member->last_name,
                    'member_pic' => $member->pic,
                    'member_uniqid' => $member->uniqid
                ];
                array_push($blackListusersShow, $mList);
            }
        }
        
        return response([
            'success' => true,
            'message' => 'success',
            'data' => $blackListusersShow,
        ], config('constants.validResponse.statusCode'));
    }
}
