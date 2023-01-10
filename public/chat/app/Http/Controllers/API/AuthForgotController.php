<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\UserMail;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Events\NewUser;
use Pusher\Pusher;
use App\Notifications\UserNewAdd;
use Artisan;
use Illuminate\Support\Facades\File;

class AuthForgotController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $data = Validator::make($request->all(),['email' => 'required|email', 'sent' => 'required']);
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

        $request->email;
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response([
                'success' => false,
                'message' => 'Invalid email. Please try again',
            ], config('constants.invalidResponse.statusCode'));
        }
        $otp = random_int(100000, 999999);
        //rand(6, 999999);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['otp' => $otp,'expire_otp_time' => strtotime("+2 minutes")]
        );
        if($user = User::find($user->id))
        {
            $user['otp'] = (string)$otp;
            $user['bodyMsg'] = 'Thank you for choosing '.config('app.name').'. Use the following OTP to complete your reset password procedures. OTP is valid for 2 minutes.';
            self::mailSend($user); 
        }
        return response([
            'success' => true,
            'sent' => $request->sent,
            'message' => 'OTP sent to email. please check email.',
            'data' => Config('constants.emptyData'),
        ], config('constants.validResponse.statusCode'));
    }
    public function resedOTP(Request $request){
       return $this->forgotPassword($request);
    }

    public function checkOTPVerification(Request $request){
        $data = Validator::make($request->all(),[
            'email' => 'email|required',
            'otp' => 'required',
            'sent' => 'required'
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

        $otp_time_out = DB::table('password_resets')
                        ->where('otp', $request->otp)
                        ->where('email', $request->email)
                        ->value('expire_otp_time');
        if($otp_time_out){
            $now = strtotime("now");
            if($now < $otp_time_out){
                $demoChurchUser = User::where('email', $request->email)->where('church_id', 0)->first();
                if($demoChurchUser)
                {
                    return self::demoChurchCheckOTPVerification($request, $demoChurchUser);
                }
                $user = User::with('churchData')->where('email', $request->email)->first();
                $accessToken = NULL;
                if($request->sent === 'register' || $request->sent === 'login')
                {
                    $uT = User::where('email', $request->email)->first();
                    if($uT)
                    {
                        $uT->device_token = NULL;
                        $uT->ios_device_token = NULL;
                        $uT->email_verified_at = now();
                        $uT->device_token = $request->device_token;
                        $uT->ios_device_token = $request->ios_device_token;
                        $uT->update();
                    }
                    
                    $userAdm = User::where('u_type', 'ADM')->first();
                    $userAdm->notify(new UserNewAdd($user));
                    $data = array(
                        'user' => $user,
                        'user_id' => $user->id,
                        'title' => config('app.name'), 
                        'message' => config('constants.notification_type.new.message').' : '. $user->name, 
                        'icon' => logo_pic_path(), 
                        'image' => '',
                        'linkurl' => route("admin.users.show", [$user->id])
                    );
                    event(new NewUser($data));    
                    $accessToken = $user->createToken('API Token')->accessToken;
                }
                
                if($request->sent === 'login')
                {
                    $notifyShowAdmin = array();
                    event(new NewUser($notifyShowAdmin));
                    if($user && $user->device_token)
                    {
                        $fcm_token = $user->device_token;
                        $title='Login - '.$user->email;
                        $message = 'Logged into bible chat app.';
                        app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $user->id);
                    }
                }
                
                $existImage = store_pic_path(). $user->pic;
                if (File::exists($existImage)) {
                    $user->pic = profile_pic_path().$user->pic;
                }
                
                if($user && $user->church_name)
                {
                    $user['church_name'] = $user->church_name;
                }else{
                    $user['church_name'] = church_name_helper($user->church_id);
                }
                $latitude = null;
                $longitude = null;
                if($user->churchData)
                {
                    $latitude = $user->churchData->latitude;
                    $longitude = $user->churchData->longitude;
                }
                
                $userArr = [
                    'user_id' =>  $user->id,
                    'name' =>  $user->name,
                    'first_name' =>  $user->first_name,
                    'last_name' =>  $user->last_name,
                    'uniqid' =>  $user->uniqid,
                    'mobile_number' =>  $user->mobile_number,
                    'church_id' =>  $user->church_id,
                    'church_name' => $user['church_name'],
                    'church_website' => $user->church_website,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'email' =>  $user->email,
                    'email_verified_at' =>  $user->email_verified_at,
                    'u_type' =>  $user->u_type,
                    'pic' => $user->pic,
                    'qr_code' =>  responseMediaLink($user->qr_code, 'qrcodes'),
                    'device_token' => $user->device_token,
                    'ios_device_token' => $user->ios_device_token,
                    'created_at' =>  $user->created_at
                ];


                return response([
                    'success' => true,
                    'sent' => $request->sent,
                    'message' => 'Verification success',
                    // 'data' =>$user,
                    'data' =>$userArr,
                    'accessToken' => $accessToken
                ], config('constants.validResponse.statusCode'));
            }else{
                return response([
                    'success' => false,
                    'sent' => $request->sent,
                    'message' => 'OTP entered is expired.Please generate a new OTP and try again.',
                ], config('constants.invalidResponse.statusCode'));
            }
        }else{
            return response([
                'success' => false,
                'sent' => $request->sent,
                'message' => 'Invalid OTP entered.',
            ], config('constants.invalidResponse.statusCode'));
        } 
    }

    /* demo church otp verification */
    public function demoChurchCheckOTPVerification($request, $demoChurchUser){
        $uT = $demoChurchUser; 
        $otp_time_out = DB::table('password_resets')
                        ->where('otp', $request->otp)
                        ->where('email', $request->email)
                        ->value('expire_otp_time');
        if($otp_time_out){
            $now = strtotime("now");
            if($now < $otp_time_out){
                $accessToken = NULL;
                if($request->sent === 'register' || $request->sent === 'login')
                {
                    $uT->device_token = NULL;
                    $uT->ios_device_token = NULL;
                    $uT->email_verified_at = now();
                    $uT->device_token = $request->device_token;
                    $uT->ios_device_token = $request->ios_device_token;
                    $uT->update();
                    $accessToken = $uT->createToken('API Token')->accessToken;
                }
                
                if($request->sent === 'login')
                {
                    $uT = User::where('email', $uT->email)->where('church_id', 0)->first();
                    if($uT->device_token)
                    {
                        $fcm_token = $uT->device_token;
                        $title='Login';
                        $message = 'Logged into bible chat app.';
                        app('App\Http\Controllers\API\AppNotificationController')->sendPushNotification($request, $fcm_token, $title, $message, $uT->id);
                    }
                }
                $existImage = store_pic_path(). $uT->pic;
                if (File::exists($existImage)) {
                    $uT->pic = profile_pic_path().$uT->pic;
                }
                
                $existImage = store_pic_path(). $uT->pic;
                if (File::exists($existImage)) {
                    $uT->pic = profile_pic_path().$uT->pic;
                }
                
                $userArr = [
                    'user_id' =>  $uT->id,
                    'name' =>  $uT->name,
                    'first_name' =>  $uT->first_name,
                    'last_name' =>  $uT->last_name,
                    'uniqid' =>  $uT->uniqid,
                    'mobile_number' =>  $uT->mobile_number,
                    'church_id' =>  $uT->church_id,
                    'church_name' => $uT->church_name,
                    'church_website' => $uT->church_website,
                    'email' =>  $uT->email,
                    'email_verified_at' =>  $uT->email_verified_at,
                    'u_type' =>  $uT->u_type,
                    'pic' => $uT->pic,
                    'qr_code' =>  responseMediaLink($uT->qr_code, 'qrcodes'),
                    'device_token' => $uT->device_token,
                    'ios_device_token' => $uT->ios_device_token,
                    'created_at' =>  $uT->created_at
                ];

                return response([
                    'success' => true,
                    'sent' => $request->sent,
                    'message' => 'Verification success',
                    // 'data' =>$uT,
                    'data' =>$userArr,
                    'accessToken' => $accessToken
                ], config('constants.validResponse.statusCode'));
            }else{
                return response([
                    'success' => false,
                    'sent' => $request->sent,
                    'message' => 'OTP entered is expired.Please generate a new OTP and try again.',
                ], config('constants.invalidResponse.statusCode'));
            }
        }else{
            return response([
                'success' => false,
                'sent' => $request->sent,
                'message' => 'Invalid OTP entered.',
            ], config('constants.invalidResponse.statusCode'));
        } 
    }
    public function newPasswordUpdate(Request $request)
    {   

        $data = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required',
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
        
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response([
                'success' => false,
                'message' => 'Invalid email. Please try again',
            ], config('constants.invalidResponse.statusCode'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response([
            'success' => true,
            'message' => 'Password updated successfully.',
        ], config('constants.validResponse.statusCode'));
    }

    public static function mailSend($user)
    {
        if($user)
        {
            \Mail::to($user->email)->send(new \App\Mail\UserMail($user));
        }
    }
}