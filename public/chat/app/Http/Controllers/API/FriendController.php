<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlackList;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use Carbon\Carbon;
use App\Utils\UserUtil;
use DB;
use App\Notifications\FriendNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class FriendController extends Controller
{
    protected $userUtil;

    public function __construct(UserUtil $userUtil)
    {
        $this->userUtil = $userUtil;
    }

    /** all songs list. */
    public function suggestionList(Request $request)
    {
        $search = Null;
        if($request->search)
        {
            $search = strval($request->search);
        }
        
        $church_member = User::query();
        // $church_member->doesntHave('church');
        $church_member->where('u_type', 'USR');
        $church_member->whereNotIn('id', [auth()->user()->id]);
        $church_member->orderBy('updated_at', 'desc');
        $church_member->where('name', 'like', '%'.$search.'%');
        $church_member->orWhere('first_name', 'like', '%'.$search.'%');
        $church_member->orWhere('last_name', 'like', '%'.$search.'%');
        $church_member =$church_member->get();
     
        $friend = Friend::query();
        $friend->with('friendData')->where('user_id',auth()->user()->id);
        $friend->whereHas('friendData', function($q) use($search){
                $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%');
            });
        $friend = $friend->get();

        $churchMember = [];
        foreach($church_member as $member){
            
            if($member->id != auth()->user()->id){
                $existImage = store_pic_path(). $member->pic;
                if (File::exists($existImage)) {
                    $member->pic = profile_pic_path().$member->pic;
                }


                $is_friend = Friend::where('user_id', auth()->user()->id)->where('friend_id', $member->id)->first();
                $member['is_friend'] = ($is_friend ? 1 : 0);

                $is_request_sent = FriendRequest::where('sender_id', auth()->user()->id)->where('receiver_id', $member->id)->first();
                $member['is_request_sent'] = ($is_request_sent ? 1 : 0);

                $is_request_received = FriendRequest::where('sender_id', $member->id)->where('receiver_id', auth()->user()->id)->first();
                $member['is_request_received'] = ($is_request_received ? 1 : 0);

                $is_blocked =  BlackList::where('member_id', $member->id)->where('user_id', auth()->user()->id)->select('member_id', 'user_id')->first();
                $member['is_blocked'] = ( $is_blocked ? true : false );

                $is_favourite = Favourite::where('user_id', auth()->user()->id)->where('select_id', $member->id)->where('favourite_type', config('constants.favourite.users.key'))->first();
                $member['is_favourite'] = ( $is_favourite ? true : false );
                
                $mem = [
                    'user_id'=>$member->id,
                    'church_id' => $member->church_id, 
                    'name'=>$member->name,
                    'pic' => $member->pic,
                    'uniqid'=>$member->uniqid,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'mobile_number' => $member->mobile_number,
                    'is_friend' => $member->is_friend,
                    'is_request_sent' => $member->is_request_sent,
                    'is_request_received' => $member->is_request_received,
                    'is_blocked' => $member->is_blocked,
                    'is_favourite' => $member->is_favourite,
                ];
                array_push($churchMember, $mem);
            }
        }

        $friends = [];
        foreach($friend as $frnd){

            $existImage = store_pic_path(). $frnd->friendData->pic;
            if (File::exists($existImage)) {
                $frnd->friendData->pic = profile_pic_path().$frnd->friendData->pic;
            }

            $is_blocked =  BlackList::where('member_id', $frnd->friendData->id)->where('user_id', auth()->user()->id)->select('member_id', 'user_id')->first();
            $frnd['is_blocked'] = ( $is_blocked ? true : false );
            
            $frd = [
                'user_id'=>$frnd->user_id,
                'church_id' => $frnd->friendData->church_id,
                'friend_id'=>$frnd->friendData->id,
                'friend_name'=>$frnd->friendData->name,
                'friend_first_name'=>$frnd->friendData->first_name,
                'friend_last_name'=>$frnd->friendData->last_name,
                'pic' => $frnd->friendData->pic,
                'friend_uniqid'=>$frnd->friendData->uniqid,
                'is_blocked' => $frnd->is_blocked
            ];
            array_push($friends, $frd);
        }
        
        return response([
            'success' => true,
            'message' => 'success',
            'data' => ['church_members'=>$churchMember,'friends'=>$friends],
        ], config('constants.validResponse.statusCode'));

    }

    public function sendRequest(Request $request){
        DB::beginTransaction();
        try {
            $friend = $this->userUtil->user($request->friend_id);
            $authUser = auth()->user();
            $user_id = $authUser->id;
            if(!$friend || $friend->id == $user_id) 
            {
                return dataNotFound();
            }

            $church_member = User::query();
            $church_member->where('id', '!=', $authUser->id);
            $church_member =$church_member->first();

            if(!$church_member)
            {
                return response([
                    'success' => false,
                    'message' => 'This member not a your church member.',
                    'data' => Config('constants.emptyData'),
                ], Config('constants.invalidResponse.statusCode'));
            }

            if(!FriendRequest::where([['sender_id','=',$user_id],['receiver_id','=',$request->friend_id]])->first() || Friend::where('user_id', $user_id)->where('friend_id', $request->friend_id)->first())
            {
                FriendRequest::create([
                    'sender_id'    => $user_id,
                    'receiver_id'    => $request->friend_id,
                ]);

                DB::commit();

                $notifyData = array(
                    'user' => $friend,
                    'type' => config('constants.notification_type.request.key'),
                    'message' => config('constants.notification_type.received.message')
                );
                $authUser->notify(new FriendNotification($notifyData) );

                $notifyData = array(
                    'user' => $authUser,
                    'type' => config('constants.notification_type.received.key'),
                    'message' => config('constants.notification_type.received.message')
                );
                $friend->notify(new FriendNotification($notifyData) );

            
                if($friend->device_token)
                {
                    $fcm_token = $friend->device_token;
                    $title='Request';
                    $message = 'Request sent.';
                    app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $friend->id);
                }
                
            }

            return response([
                'success' => true,
                'message' => 'success',
                'data' => Config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => Config('constants.emptyData'),
            ], Config('constants.invalidResponse.statusCode'));
        }

    }

    public function requestList(Request $request){
        $request = FriendRequest::with('senderData')->where('receiver_id' , auth()->user()->id)->get();

        return response([
            'success' => true,
            'message' => 'success',
            'data' => $request,
        ], config('constants.validResponse.statusCode'));
    }

    public function acceptRequest(Request $request){ 
        if(!Friend::where('user_id', auth()->user()->id)->where('friend_id', $request->friend_id)->first() && FriendRequest::where([['sender_id','=',$request->friend_id],['receiver_id','=',auth()->user()->id]])->first())
        {
            Friend::create([
                'user_id'    => auth()->user()->id,
                'friend_id'    => $request->friend_id,
            ]);
    
            Friend::create([
                'user_id'    => $request->friend_id,
                'friend_id'    => auth()->user()->id,
            ]);
    
            FriendRequest::where([['sender_id','=',$request->friend_id],['receiver_id','=',auth()->user()->id]])->forceDelete();
            FriendRequest::where([['sender_id','=',auth()->user()->id],['receiver_id','=',$request->friend_id]])->forceDelete();
    
            $friend = $this->userUtil->user($request->friend_id);
            $authUser = auth()->user();
            $notifyData = array(
                'user' => $authUser,
                'type' => config('constants.notification_type.accept.key'),
                'message' => config('constants.notification_type.accept.message')
            );
            $friend->notify(new FriendNotification($notifyData) );
        
            $notifyData = array(
                'user' => $friend,
                'type' => config('constants.notification_type.accept.key'),
                'message' => config('constants.notification_type.accept.message')
            );
            $authUser->notify(new FriendNotification($notifyData) );

            if($friend->device_token)
            {
                $fcm_token = $authUser->device_token;
                $title='Request';
                $message = config('constants.notification_type.accept.message');
                app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $authUser->id);
            }
            return response([
                'success' => true,
                'message' => 'success',
                'data' => Config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
        }
        return dataNotFound();

    }

    public function rejectRequest(Request $request)
    {
        if(FriendRequest::where([['sender_id','=',$request->friend_id],['receiver_id','=',auth()->user()->id]])->first())
        {
            FriendRequest::where([['sender_id','=',$request->friend_id],['receiver_id','=',auth()->user()->id]])->forceDelete();
            FriendRequest::where([['sender_id','=',auth()->user()->id],['receiver_id','=',$request->friend_id]])->forceDelete();

            $friend = $this->userUtil->user($request->friend_id);
            if($friend)
            {
                $authUser = auth()->user();
                $notifyData = array(
                    'user' => $friend,
                    'type' => config('constants.notification_type.rejected.key'),
                    'message' => config('constants.notification_type.accept.message')
                );
                $authUser->notify(new FriendNotification($notifyData) );

                $notifyData = array(
                    'user' => $authUser,
                    'type' => config('constants.notification_type.rejected.key'),
                    'message' => config('constants.notification_type.accept.message')
                );
                $friend->notify(new FriendNotification($notifyData) );
            }
            
            return response([
                'success' => true,
                'message' => 'success',
                'data' => Config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
        }
        return dataNotFound();
    }    
}