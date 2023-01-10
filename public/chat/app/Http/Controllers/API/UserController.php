<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;    
use Carbon\Carbon;
use Str;
use DB;
use Hash;
use App\Http\Controllers\UniqueController;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Events\AlertEvent;
use Illuminate\Support\Facades\File;
use App\Utils\UserUtil;
use App\Models\Post;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Church;
use App\Events\NewUser;
use App\Models\BlackList;
use App\Models\Favourite;

class UserController extends Controller
{
    protected $userUtil;

    public function __construct(UserUtil $userUtil)
    {
        $this->userUtil = $userUtil;
    }
    
    //user details show
    public function details(Request $request)
    {
        $user = auth()->user();
        $existImage = store_pic_path(). $user->pic;
        if (File::exists($existImage)) {
            $user->pic = profile_pic_path().$user->pic;
        }

        $user->qr_code = profile_qr_path().$user->qr_code;
        // $user->makeVisible('church_website'); 

        $notify = 'no';
        $notifyShowAdmin = array();
        event(new NewUser($notifyShowAdmin));
        if($user && $user->device_token)
        {
            $notify = 'yes';
            $fcm_token = $user->device_token;
            $title='User Details';
            $message = 'User Details show api called.';
            app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $user->id);
        }
        
        return response([
            'success' => true,
            'message' => 'User Profile Details',
            'notify' => $notify,
            'data' => $user->toarray()
        ], config('constants.validResponse.statusCode')); 
    }

    // user details update
    public function detailsUpdate()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    //user profile update
    public function profileUpdate(Request $request) 
    {
        DB::beginTransaction();
        try
        {   
            $user = auth()->user();
            if($request->name)
            {
                $request['name'] = Str::lower( Str::replace(' ','', $request['name']) );
                if(User::whereIn('name', [$request['name'] ])->first())
                {
                    if($request['name'] != $user->name)
                    {
                        $data = Validator::make($request->all(),[
                            'name' => 'required|max:30|unique:users|alpha_dash',                         
                        ]);
                        if ($data->fails())
                        {
                            foreach ($data->messages()->getMessages() as $field_name => $messages)
                            {
                                return response([
                                    'success' => false,
                                    'message' => $messages[0],
                                    'data' => config('constants.emptyData'),
                                ], config('constants.invalidResponse.statusCode')); 
                            }
                        }
                    }
                }else{
                    $user->name = $request->name;
                }
            }

            $user->first_name = $request->first_name ?? $user->first_name;
            $user->last_name = $request->last_name ?? $user->last_name;
            $user->mobile_number = $request->mobile_number ?? $user->mobile_number;
            
            if ($request->hasFile('image')) {
                $file = uploadFile($request->file('image'), 'pics');
                removeFile($user->pic, 'pics');
                $user->pic = $file;
            }
            $user->update();

            if($user->pic)
            {
                $existImage = store_pic_path(). $user->pic;
                if (File::exists($existImage)) {
                    $user->pic = profile_pic_path().$user->pic;
                }
            }
            if($user && $user->church_name)
            {
                $user['church_name'] = $user->church_name;
            }else{
                $user['church_name'] = church_name_helper($user->church_id);
            }
            
            $user['qr_code'] = profile_qr_path().$user->qr_code;
            
            DB::commit();

            return response([
                'success' => true,
                'message' => 'User Profile Details Updated',
                'data' => $user->toarray()
            ], config('constants.validResponse.statusCode')); 
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return response([
                'success' => false,
                'message' => $bug,
                'data' => $user->toarray()
            ], config('constants.invalidResponse.statusCode')); 
        }
    }

    public function getProfileFromUId(Request $request){

        $user = User::with('churchData')->where('uniqid', $request->uniqid)->first();
        if($user){
            $userArr = [
                'user_id' =>  $user->id,
                'name' =>  $user->name,
                'first_name' =>  $user->first_name,
                'last_name' =>  $user->last_name,
                'uniqid' =>  $user->uniqid,
                'mobile_number' =>  $user->mobile_number,
                'email' =>  $user->email,
                'email_verified_at' =>  $user->email_verified_at,
                'u_type' =>  $user->u_type,
                'qr_code' =>  responseMediaLink($user->qr_code, 'qrcodes'),
                'created_at' =>  $user->created_at
            ];

            return response([
                'success' => true,
                'message' => 'User Fetched',
                'data' =>$userArr,
            ], config('constants.validResponse.statusCode'));
        }else{
            return response([
                'success' => false,
                'message' => 'Invalid UniqId.',
            ], config('constants.invalidResponse.statusCode'));
    
        }
        
    }

    public function generateQrCode()
    {
        if (date_default_timezone_set('UTC')){
            echo "UTC is a valid time zone";
        }else{
            echo "The system doesn't know WTFUTC.  Maybe try updating tzinfo with your package manager?";
        }
    }


    public function saveToken(Request $request)
    {
        $data = Validator::make($request->all(),[
            'token' => 'required',
        ]);

        if ($data->fails())
        {
            foreach ($data->messages()->getMessages() as $field_name => $messages)
            {
                return response([
                    'success' => false,
                    'message' => $messages[0],
                    'data' => Config('constants.emptyData'),
                ], config('constants.invalidResponse.statusCode')); 
            }
        }

        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification($request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = config('constants.FCM_SERVER_KEY');
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }

    public function postLikeNotification(Request $request)
    {
        $data = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required',
            'list_id' => 'required',
            'type' => 'required'
        ]);

        if ($data->fails())
        {
            return response([
                'success' => false,
                'message' => $data->messages()->getMessages(),
                'data' => Config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));  
        }

       return self::sendNotification($request);
    }

    public function create_event(){
    //   return  auth()->user();
        // $title = 'New User';
        // $icon = '';
        // $image = '';
        // $text1 = 'there is a new User';
        // $linkurl= route('/');
        $data = array(
            'title' => 'New User',
            'icon' => '',
            'image' => '',
            'text1' => 'there is a new User',
            'linkurl'=> route('/')
        );
        event(new AlertEvent($data));
        echo "event sent";
    }

    //other User details
    public function otherUserdetails($uniqueId)
    {
        $otherUser = User::where('uniqid', $uniqueId)->where('u_type', 'USR')->first();
        if($otherUser)
        {
            $existImage = store_pic_path(). $otherUser->pic;
            if (File::exists($existImage)) {
                $otherUser->pic = profile_pic_path().$otherUser->pic;
            }
            $otherUser->qr_code = profile_qr_path().$otherUser->qr_code;

            $is_friend = Friend::where('user_id', auth()->user()->id)->where('friend_id', $otherUser->id)->first();
            $otherUser['is_friend'] = ($is_friend ? 1 : 0);

            $is_request_sent = FriendRequest::where('sender_id', auth()->user()->id)->where('receiver_id', $otherUser->id)->first();
            $otherUser['is_request_sent'] = ($is_request_sent ? 1 : 0);

            $is_request_received = FriendRequest::where('sender_id', $otherUser->id)->where('receiver_id', auth()->user()->id)->first();
            $otherUser['is_request_received'] = ($is_request_received ? 1 : 0);

            $is_blocked =  BlackList::where('member_id', $otherUser->id)->where('user_id', auth()->user()->id)->select('member_id', 'user_id')->first();
            $otherUser['is_blocked'] = ( $is_blocked ? true : false );
            
            $is_favourite = Favourite::where('user_id', auth()->user()->id)->where('select_id', $otherUser->id)->where('favourite_type', config('constants.favourite.users.key'))->first();
            $otherUser['is_favourite'] = ( $is_favourite ? true : false );

            $postDetail = Post::where('user_id', $otherUser->id)->whereHas('user')->with('postMedia', 'like', 'postComment')->orderBy('updated_at', 'desc')->get();
             // return $postDetail;
            $response = [];
            foreach($postDetail as $post){
    
                $postMedia =[];
                foreach($post->postMedia as $media){
                    $mediatArr = [
                        'media_id' => $media->id,
                        'media_name' => responseMediaLink($media->media_name,'post'),
                        'media_type' => $media->media_type
                    ];
                    array_push($postMedia, $mediatArr);
                }
                $is_like = 0;
                foreach($post->like as $media){
                    $is_like = 1;
                }
                $existImage = store_pic_path(). $post->user->pic;
                if (File::exists($existImage)) {
                    $post->user->pic = profile_pic_path().$post->user->pic;
                }
                $church_name = $post->user->church_name;
                if($post->user->churchData)
                {
                    $church_name = church_name_helper();
                }
                $postArr = [
                    'post_id'    => $post->id,
                    'title'    => $post->title,
                    'description'    => $post->description,
                    'likes'    => $post->likes,
                    'created_at' => $post->created_at,
                    'post_media' => $postMedia,
                    'is_liked' => $is_like,
                    'user_name' => $post->user->name,
                    'user_email' => $post->user->email,
                    'uniqid' => $post->user->uniqid,
                    'pic' => $post->user->pic, 
                    'church_name' => $church_name
                ];
                array_push($response, $postArr);
            }
            
            $otherUser['post_data'] = $response;
            return response([
                'success' => true,
                'message' => 'User Profile & post Details',
                'data' => $otherUser->toarray(),
            ], config('constants.validResponse.statusCode'));
        }
        return dataNotFound();
    }

    /* user select Language */
    public function selectLanguage(Request $request)
    {
        $data = Validator::make($request->all(),[
            'language' => 'required',
        ]);
        if ($data->fails())
        {
            return response([
                'success' => false,
                'message' => $data->messages()->getMessages(),
                'data' => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode'));  
        }
        if($request->language == 'en' || $request->language == 'zh-CN')
        {
            User::where('id', auth()->user()->id)->update(['language' => $request->language]);
            return response([
                'success' => true,
                'message' => 'User primary language selected.',
                'data' => $request->language,
                'language' => $request->language
            ], config('constants.validResponse.statusCode'));
        }
        return dataNotFound('language');
    }

    /* churchWebsiteUpdate **/
    public function churchWebsiteUpdate(Request $request) 
    {
        DB::beginTransaction();
        try
        {   
            $user = auth()->user();
            $user->church_website = $request->church_website ?? null;
            $user->update();

            $user = auth()->user();
            if($user->pic)
            {
                $existImage = store_pic_path(). $user->pic;
                if (File::exists($existImage)) {
                    $user->pic = profile_pic_path().$user->pic;
                }
            }
            $user['church_name'] = church_name_helper();
            $user['qr_code'] = profile_qr_path().$user->qr_code;
            
            DB::commit();

            return response([
                'success' => true,
                'message' => 'User Church Website Details Updated',
                'data' => config('constants.emptyData')
            ], config('constants.validResponse.statusCode')); 
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return response([
                'success' => false,
                'message' => $bug,
                'data' => config('constants.emptyData')
            ], config('constants.invalidResponse.statusCode')); 
        }
    }
}