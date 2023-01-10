<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Classes\AgoraDynamicKey\RtcTokenBuilder;

use Monyxie\Agora\TokenBuilder\TokenFactory;
use Monyxie\Agora\TokenBuilder\AccessControl\Role;
use Monyxie\Agora\TokenBuilder\AccessControl\Privilege;
use Illuminate\Support\Facades\Validator;
use App\Utils\RequiredUtil;
use File;
use  App\Notifications\ChatAgoraNotificaions;

class AgoraVideoController extends Controller
{
    protected $requiredUtil;
    public function __construct(RequiredUtil $requiredUtil)
    {
        $this->requiredUtil = $requiredUtil;
    }

    /*  Agora Chat Video & call token get */
    public function token(Request $request)
    {   
        try {
            $response = [];
            if(!$request->member_id)
            {
                return $this->requiredUtil->requiredField($request->all(), 'member_id');
            }
            if(!$request->type)
            {
                return $this->requiredUtil->requiredField($request->all(), 'type');
            }
            $user = auth()->user();
            $member = member($request->member_id);
            if(!$member)
            {   
                return dataNotFound('Member');
            }
            $existImage = store_pic_path(). $member->pic;
            if (File::exists($existImage)) {
                $member->pic = profile_pic_path().$member->pic;
            }

            $appId = config('constants.chat.agoraAppId');
            $appCertificate = config('constants.chat.agoraAppCertificate');
            $channelName = strRandom(40);
            $uid = 0;
            $privileges = Role::PRIVILEGES_PUBLISHER;

            $token = (new TokenFactory($appId, $appCertificate))->create($channelName, $uid, $privileges)->toString();

            $notifyData = array(
                'user' => $user,
                'member' => $member,
                'type' => $request->type,
                'message' => config('constants.notification_type.chat.message'),
                'chat_token' => $token,
                'channel_name' => $channelName
            );

            // // $member->notify(new ChatAgoraNotificaions($notifyData) );
            if($member->ios_device_token != NULL && isset($request->type) )
            {
                $fcm_token = $member->ios_device_token; 
                $title= config('constants.notification_type.chat.name');
                $message = config('constants.notification_type.chat.message');
                app('App\Http\Controllers\API\AppNotificationController')->sendPushIOSNotification($request, $fcm_token, $title, $message, $member->id, $token, $channelName, $request->type);
            }else{
                $fcm_token = $member->device_token;
                $title= config('constants.notification_type.chat.name');
                $message = config('constants.notification_type.chat.message');
                app('App\Http\Controllers\API\AppNotificationController')->sendPcushNotification($request, $fcm_token, $title, $message, $member->id, $token, $channelName, $request->type);
            }
            
            $groupArr = [
                'church_name' => church_name_helper(),
                'member_id' => $member->id,
                'member_name' => $member->name,
                'member_pic' => $member->pic,
                'user_id' => $user->id,
                'type' => $request->type,
                'channel_name' => $channelName,
                'ios_device_token' => $member->ios_device_token,
                'chat_token' => $token,
            ];
            array_push($response, $groupArr);

            return response([
                'success' => true,
                'message' => 'Agora chat video & call token created.',
                'data' =>$response,
            ], config('constants.validResponse.statusCode'));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }
        
    } 
}
