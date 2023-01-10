<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\UserUtil;
use Auth;
use Illuminate\Support\Facades\File;
use DB;
use App\Models\Friend;

class AppNotificationController extends Controller
{
    protected $userUtil;

    public function __construct(UserUtil $userUtil)
    {
        $this->userUtil = $userUtil;
    }

    //Push Notifications
    public static function sendPushNotification($request, $fcm_token, $title, $message, $id = null, $chat_token = null, $channelName = null, $type = NULL) {
        // $key = 'AAAANx8g4****RskF7p3Wc4';
       
        $key = config('constants.FCM_SERVER_KEY');
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = [
        'authorization: key=' . $key,
            'content-type: application/json'
        ];
        
        if(isset($type) )
        {
            $sender = auth()->user();
            if(isset($sender) )
            {
                if(isset($sender->pic))
                {
                    $existImage = store_pic_path(). $sender->pic;
                    if (File::exists($existImage)) {
                        $sender->pic = profile_pic_path().$sender->pic;
                    }
                }
                
                $postdata = '{
                    "to" : "' . $fcm_token . '",
                    "data" : {
                        "id" : "'.$id.'",
                        "title":"' . $title . '",
                        "description" : "' . $message . '",
                        "text" : "' . $message . '",
                        "is_read": 0,
                        "channel_name" : "' . $channelName . '",
                        "chat_token" : "' . $chat_token . '",
                        "profile_pic" : "' . $sender->pic . '",
                        "first_name" : "' . $sender->first_name . '",
                        "last_name" : "' . $sender->last_name . '",
                        "ios_device_token" : "' . $sender->ios_device_token . '",
                        "device_token" : "' . $sender->device_token . '",
                        "type" : "' . $type . '",
                        "channel_id" : "bibleChat"
                    },
                    "priority":  "high"
                }';
            }
        } else{
            $postdata = '{
                "to" : "' . $fcm_token . '",
                "notification" : {
                    "title":"' . $title . '",
                    "text" : "' . $message . '"
                },
                "data" : {
                    "id" : "'.$id.'",
                    "title":"' . $title . '",
                    "description" : "' . $message . '",
                    "text" : "' . $message . '",
                    "is_read": 0,
                    "channel_id" : "bibleChat"
                  },
                  "priority":  "normal"
            }';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    //allNotifications
    public function allNotifications(Request $request)
    {
        try {
            $userNotifications = auth()->user()->unreadNotifications
            ->whereIn('type', ['App\Notifications\LikeNotification', 'App\Notifications\CommentNotification', 'App\Notifications\FriendNotification', 'App\Notifications\ChatAgoraNotificaions']);
            $count = $userNotifications->count();
            $response = [];
            foreach($userNotifications as $notification)
            { 
                $sender = $this->userUtil->user($notification->data['user_id']);
                if($sender)
                {
                    // return $sender;
                    $friend = Friend::withTrashed()->where('user_id',auth()->user()->id)->where('friend_id', $sender->id)->first();
                    if($notification->data['type'] == 'received' && $friend) 
                    {

                    }else{
                        if($sender->pic)
                        {
                            $existImage = store_pic_path(). $sender->pic;
                            if (File::exists($existImage)) {
                                $sender->pic = profile_pic_path().$sender->pic;
                            }
                        }
                        $message = '';
                        if($notification->data['type'] == config('constants.notification_type.like.key') ) {
                            $message = config('constants.notification_type.like.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.comment.key') ) {
                            $message = config('constants.notification_type.comment.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.request.key') ) {
                            $message = config('constants.notification_type.request.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.accept.key') ) {
                            $message = config('constants.notification_type.accept.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.received.key') ) {
                            $message = config('constants.notification_type.received.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.rejected.key') ) {
                            $message = config('constants.notification_type.rejected.message');
                        }
                        if($notification->data['type'] == config('constants.notification_type.chat.key') ) {
                            $message = config('constants.notification_type.chat.message');
                        }
                        
                        $postArr = [
                            'notification_id' => $notification->id, 
                            'user_id' =>  $sender->id,
                            'user_name' => $sender->name,
                            'user_uniqid' => $sender->uniqid,
                            'pic' => $sender->pic,
                            'type' => $notification->data['type'],
                            'message' => $message,
                            'created_at' => $notification->created_at 
                        ];
                        array_push($response, $postArr);
                    }
                }
            }
            
            return response([
                'success' => true,
                'message' => 'All Notifications',
                'count' => $count,
                'data' =>$response,
            ], config('constants.validResponse.statusCode'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }       
        
    }

    //deleteNotification
    public function deleteAppNotification(Request $request)
    {
        $request->notification_id;
        DB::beginTransaction();
        try
        {
            $user = auth()->user();
            $notify = $user->notifications->find($request->notification_id);
            if(isset($notify))
            {   
                $notify->delete();
                DB::commit();
                return response([
                    'success' => true,
                    'message' => 'Notification removed success',
                    'data' => config('constants.emptyData'),
                ], config('constants.validResponse.statusCode'));
            }
            return dataNotFound();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }   
    }

    /*chat Notification IOS */	
    public function chatNotificationIOS(Request $request)	
    {	
        $this->sendPushNotification($request, $fcm_token, $title, $message, $id = null, $chat_token = null, $channelName = null, $type = NULL);	
    }	

    
    public function IOSNotification($request, $fcm_token, $title, $message, $id = null, $chat_token = null, $channelName = null, $type = NULL)
    {
        // $url = "https://api.development.push.apple.com/3/device/16140a9a90a2812932c74b28eb1d842200972a19a4b14f8cac097e5efbceb3f0";
        
        // $key = $request->bearerToken();
        // $header = [
        // 'authorization: key=' . $key,
        //     'content-type: application/json'
        // ];

        // $messageBody['aps'] = array('alert' => $message,
        //     'sound' => 'default',
        //     'badge' => 2,
        //     'caller' => 'Caller Name Laravel'
        // );

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $messageBody);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // return $ch;


        /*-----------------------------*/
        
        // $deviceToken = '16140a9a90a2812932c74b28eb1d842200972a19a4b14f8cac097e5efbceb3f0ye';
        $deviceToken = $fcm_token;      
        //$key = file_get_contents(storage_path() . '/voip_bible.p12');
        // $pem_file = 'filename.pem';       
        $pushCertFile = asset('/').'assets/voip_services.cer';
        /* We are using the sandbox version of the APNS for development. For production
        environments, change this to ssl://gateway.push.apple.com:2195 */
        // $apnsServer = 'tcp://gateway.sandbox.push.apple.com:2195';
        $apnsServer = 'tcp://gateway.sandbox.push.apple.com:5223';
        // $apnsServer = 'https://api.sandbox.push.apple.com';
        // $apnsServer = 'https://api.push.apple.com/';
        /* Make sure this is set to the password that you set for your private key
        when you exported it to the .pem file using openssl on your OS X */
        $privateKeyPassword = '';
    

        /* Replace this with the name of the file that you have placed by your PHP
        script file, containing your private key and certificate that you generated
        earlier */

        $stream = stream_context_create([
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
        stream_context_set_option($stream,
        'ssl',
        'passphrase',
        $privateKeyPassword);

        stream_context_set_option($stream,
        'ssl',
        'cafile',
        $pushCertFile);
        

        $connectionTimeout = 20;
        $connectionType = STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT;
        $connection = stream_socket_client($apnsServer,
        $errorNumber,
        $errorString,
        $connectionTimeout,
        $connectionType,
        $stream);
        if (!$connection){
                echo "Failed to connect to the APNS server. Error no = $errorNumber<br/>";
        } 
        else 
        {
                echo "Successfully connected to the APNS. Processing...</br>";
        }

        $messageBody['aps'] = array('alert' => $message,
            'sound' => 'default',
            'badge' => 2,
        );

        $payload = json_encode($messageBody);
        $notification = chr(0) .
        pack('n', 32) .
        pack('H*', bin2hex($deviceToken)) .
        pack('n', strlen($payload)) .
        $payload;

        $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));
        var_dump($wroteSuccessfully); 

        if (!$wroteSuccessfully){
                echo "Could not send the message<br/>";
        }
        else {
                echo "Successfully sent the message<br/>";
        }        

        fclose($connection);
    }

    

    /* voip Token */
    public function notification($request, $fcm_token, $title, $message, $id = null, $chat_token = null, $channelName = null, $type = NULL)
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

            $channelName = strRandom(40);
            /* VoIP Token*/
            $token = '16140a9a90a2812932c74b28eb1d842200972a19a4b14f8cac097e5efbceb3f0ye';


            $existImage = store_pic_path(). $member->pic;
            if (File::exists($existImage)) {
                $member->pic = profile_pic_path().$member->pic;
            }


            $notifyData = array(
                'user' => $user,
                'member' => $member,
                'type' => $request->type,
                'message' => config('constants.notification_type.chat.message'),
                'chat_token' => $token,
                'channel_name' => $channelName
            );

            // $member->notify(new ChatAgoraNotificaions($notifyData) );
            if($member->device_token)
            {
                $fcm_token = $member->device_token;
                $title= config('constants.notification_type.chat.name');
                $message = config('constants.notification_type.chat.message');
                app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $member->id, $token, $channelName, $request->type);
            }
            
            $groupArr = [
                'church_name' => church_name_helper(),
                'member_id' => $member->id,
                'member_name' => $member->name,
                'member_pic' => $member->pic,
                'user_id' => $user->id,
                'type' => $request->type,
                'channel_name' => $channelName,
                'chat_token' => $token
            ];
            array_push($response, $groupArr);

            return response([
                'success' => true,
                'message' => 'VoIP chat video & call token created.',
                'data' =>$response,
            ], config('constants.validResponse.statusCode'));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data'    => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));
        }
    }

    public function sendPushIOSNotification($request, $fcm_token, $title, $message, $id = null, $chat_token = null, $channelName = null, $type = NULL)
    {   
        /* ios notification format */
        // "aps" : {
        //     "alert" : "Notification with custom payload!",
        //     "badge" : 1,
        //     "content-available" : 1
        // },
        //  "data" :{
        //     "title" : "Game Request",
        //     "body" : "Bob wants to play poker",
        //     "action-loc-key" : "PLAY"
        //  }

        $device_token = $fcm_token;       
        $pushCertFile = VOIP_certificate_path();

        if ( defined("CURL_VERSION_HTTP2") && (curl_version()["features"] & CURL_VERSION_HTTP2) !== 0) {
            $ch = curl_init();
            /* live get format */
            // $body ['aps'] = array (
            //     "alert" => array (
            //         "title"  => "hii",
            //     ),
            //     "sound"  => "default"
            // );
            $body = [];
            $sender = auth()->user();
            
            if(isset($sender) )
            {
                if(isset($sender->pic))
                {
                    $existImage = store_pic_path(). $sender->pic;
                    if (File::exists($existImage)) {
                        $sender->pic = profile_pic_path().$sender->pic;
                    }
                }
                $body['aps'] = array (
                    "alert" => "Notification with ".$type." call!",
                    "badge" => 1,
                    "content-available" => 1
                );

                $body['data'] = array (
                    "id" =>  $id,
                    "title" => $title,
                    "description" => $message,
                    "text" =>  $message,
                    "is_read" =>  0,
                    "channel_name" =>  $channelName,
                    "chat_token" =>  $chat_token,
                    "profile_pic" => $sender->pic,
                    "first_name" =>  $sender->first_name,
                    "last_name" =>  $sender->last_name,
                    "ios_device_token" =>  $sender->ios_device_token,
                    "device_token" => $sender->device_token,
                    "type" =>  $type,
                    "channel_id" =>  "bibleChat"
                );
                $body['priority'] = 'high';
            
            }
            
            $curlconfig = array(
                CURLOPT_URL => "https://api.development.push.apple.com/3/device/".$device_token,
                CURLOPT_RETURNTRANSFER =>true,
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_SSLCERT =>$pushCertFile,
                CURLOPT_SSLCERTPASSWD => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                CURLOPT_VERBOSE => true
            );
            curl_setopt_array($ch, $curlconfig);
            $res = curl_exec($ch);
            if ($res === FALSE) {
                    return response()->json([
                        'message' => "Curl failed" . curl_error($ch)
                    ], config('constants.invalidResponse.statusCode'));
            }
            curl_close($ch);
        }else{
            return response()->json([
                'message' => "No HTTP/2 support on client."
            ], config('constants.invalidResponse.statusCode'));
        }
    }

    public function IOSNotificationNew()
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://app.onesignal.com/api/v1/notifications/b4925e60-618c-11ec-8e43-42de68b4cb3a/history');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"events\": \"clicked\",\n    \"app_id\": \7d85a34d-e431-40d9-817f-4772da6be774\",\n    \"email\": \"laraveltestMan@mailinator.com\"\n}");

            $headers = array();
            $headers[] = 'Authorization: Basic YOUR_REST_API_KEY';
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return $result;
         
    }
}