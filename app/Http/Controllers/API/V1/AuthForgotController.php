<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Client\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail; 

class AuthForgotController extends Controller
{
    public function forgotPassword(Request $request){
        $validation = Validator::make($request->all(),[ 
            'email_address' => 'required|email|exists:clients,email_address'
        ]);
        if($validation->fails()){
            return response([
                'success' => false,
                'message' => $validation->errors()->first(),
            ], 400);
        }else{
            $otp = rand(1000, 9999);
            $token = Str::random(64);
            if($email = DB::table('password_resets')->where('email' , $request->email_address)->first()){
                DB::table('password_resets')->where('email' , $request->email_address)->update(['otp' => encrypt($otp),'token' => $token,'expire_otp_time' => strtotime("+2 minutes")]);
            }else{
                DB::table('password_resets')->Insert([
                    'email' => $request->email_address,
                    'token' => $token,
                    'otp' => encrypt($otp),
                    'expire_otp_time' => strtotime("+2 minutes")
                ]);
            }
            Mail::send('patient.otp_send', ['token' => $token,'otp' => $otp], function($message) use($request){
                $message->to($request->email_address);
                $message->subject('User Reset Password');
            }); 
            return response([
                'success' => true,
                'message' => 'OTP sent to email. please check email.',
                // 'data' => $user,
            ], config('constants.validResponse.statusCode'));
        }
    }
    public function encryptForgotPassword(Request $request){
        $validation = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validation->fails()){
            $return = $this->sendError('Validation Error', $validation->errors()->first());
            return response()->json($this->encryptData($return));
        }
        $data = json_decode($this->decryptData($request['response']));
        $validator = Validator::make((array)$data, [
            'email_address' => 'required|email|exists:clients,email_address'
        ]);
        if ($validator->fails()) {
            $return = $this->sendError('Validation Error', $validator->errors()->first());
            return response()->json($this->encryptData($return));
        }
        // return ;
        $otp = rand(1000, 9999);
        $token = Str::random(64);
        if($email = DB::table('password_resets')->where('email' , $data->email_address)->first()){
            DB::table('password_resets')->where('email' , $data->email_address)->update(['otp' => encrypt($otp),'token' => $token,'expire_otp_time' => strtotime("+2 minutes")]);
        }else{
            DB::table('password_resets')->Insert([
                'email' => $data->email_address,
                'token' => $token,
                'otp' => encrypt($otp),
                'expire_otp_time' => strtotime("+2 minutes")
            ]);
        }
        $email = $data->email_address;
        Mail::send('patient.otp_send', ['token' => $token,'otp' => $otp], function($message) use($email){
            $message->to($email);
            $message->subject('User Reset Password');
        }); 
        $return = $this->sendData('OTP sent to email. please check email.',$email);
        return response()->json($this->encryptData($return));
    }
    public function resedOTP(Request $request){
        return $this->forgotPassword($request);
    }
    public function encryptResedOTP(Request $request){
        return $this->encryptForgotPassword($request);
    }
    public function checkOTPVerification(Request $request){
        $validation = Validator::make($request->all(),[ 
            'email_address' => 'required|email',
            'otp' => 'required'
        ]);
        if($validation->fails()){
            return response([
                'success' => false,
                'message' => $validation->errors()->first(),
            ], 400);
        }else{
            $input = $request->all();
            $otp_time_out = DB::table('password_resets')
                        ->where(['email' => $request->email_address])->first();
            if($otp_time_out && decrypt($otp_time_out->otp) == $request->otp){
                $now = strtotime("now");
                if($now < $otp_time_out->expire_otp_time){
                    return response([
                        'success' => true,
                        'message' => 'success',
                    ],200);
                }else{
                    return response([
                        'success' => false,
                        'message' => 'OTP entered is expired.Please generate a new OTP and try again.',
                    ], 401);
                }
            }else{
                return response([
                    'success' => false,
                    'message' => 'Invalid OTP entered.',
                ],400);
            }
        }
    }
    public function encryptCheckOTPVerification(Request $request){
        $validation = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validation->fails()){
            $return = $this->sendError('Validation Error', $validation->errors()->first());
            return response()->json($this->encryptData($return));
        }
        $data = json_decode($this->decryptData($request['response']));
        $validator = Validator::make((array)$data, [
            'email_address' => 'required|email',
            'otp' => 'required'
        ]);
        if ($validator->fails()) {
            $return = $this->sendError('Validation Error', $validator->errors()->first());
            return response()->json($this->encryptData($return));
        }
        $otp_time_out = DB::table('password_resets')
                    ->where(['email' => $data->email_address])->first();
        if($otp_time_out && decrypt($otp_time_out->otp) == $data->otp){
            $now = strtotime("now");
            if($now < $otp_time_out->expire_otp_time){
                $return = $this->sendData('success.',$data->email_address);
                return response()->json($this->encryptData($return));
            }else{
                $return = $this->sendError(false, 'OTP entered is expired.Please generate a new OTP and try again');
                return response()->json($this->encryptData($return));
            }
        }else{
            $return = $this->sendError(false, 'Invalid OTP entered.');
            return response()->json($this->encryptData($return));
        }
       
    }
    public function newPasswordUpdate(Request $request){
        $validation = Validator::make($request->all(),[ 
            'email_address' => 'email|required',
            'password' => ['required', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/','string','confirmed'],
        ],[
            'password.regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
        ]);
        if($validation->fails()){
            return response([
                'success' => false,
                'message' => $validation->errors()->first(),
            ], 400);
        }else{
            $user = Client::where('email_address', $request->email_address)->first();
            if(!$user)
            {
                return response([
                    'success' => false,
                    'message' => 'Invalid email. Please try again',
                ], config('constants.invalidResponse.statusCode'));
            }
            $user->password = Hash::make($request->password);
            $user->save();
            DB::table('password_resets')->where(['email' => $request->email_address])->delete();
            return response([
                'success' => true,
                'message' => 'Password updated successfully.',
            ], config('constants.invalidResponse.statusCode'));
        }
    }
    public function encryptNewPasswordUpdate(Request $request){
        $validation = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validation->fails()){
            $return = $this->sendError('Validation Error', $validation->errors()->first());
            return response()->json($this->encryptData($return));
        }
        $data = json_decode($this->decryptData($request['response']));
        $validator = Validator::make((array)$data, [
            'email_address' => 'email|required',
            'password' => ['required', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/','string','confirmed'],
        ],[
            'password.regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
        ]);
        if ($validator->fails()) {
            $return = $this->sendError('Validation Error', $validator->errors()->first());
            return response()->json($this->encryptData($return));
        }
        $user = Client::where('email_address', $data->email_address)->first();
            if(!$user)
            {
                $return = $this->sendError(false, 'Invalid email. Please try again');
                return response()->json($this->encryptData($return));
            }
            $user->password = Hash::make($data->password);
            $user->save();
            DB::table('password_resets')->where(['email' => $data->email_address])->delete();
    
            $return = $this->sendData('Password updated successfully..',$data->email_address);
            return response()->json($this->encryptData($return));
    }
}
