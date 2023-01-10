<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Church;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use DB,Hash;
use Illuminate\Support\Facades\Validator;
use App\Utils\UserUtil;
use Str;

class AuthUserController extends Controller
{
    protected $userUtil;
    public function __construct(UserUtil $userUtil)
    {
        $this->userUtil = $userUtil;
    }

    public function register(Request $request)
    {
        $request['name'] = Str::lower( Str::replace(' ','', $request['name']) );
        $request['mobile_number'] = Str::replace(' ','', $request['mobile_number']);
        $request['email'] = Str::replace(' ','', $request['email']);
        
        if($request->church_id == 0)
        {
            $data = Validator::make($request->all(),[
                'church_name' => 'required|max:30|unique:users'
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
            $data = Validator::make($request->all(),[
                'church_name' => 'required|max:30|unique:churches'
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
        }
        
        $data = Validator::make($request->all(),[
            'name' => 'required|max:30|unique:users|alpha_dash',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'reference_name' => 'nullable|exists:users,name',
            'mobile_number' => 'required|max:12',
            // 'church_id' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
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


        // $request->password = Hash::make($request->password);
        // $request->uniqid = strtotime("now");

        //generate qr-code
        $uniqid = strtotime("now");
        $fileName = 'QR_'.time() . '.jpg';

        $barcode = new \Com\Tecnick\Barcode\Barcode();
        $targetPath = storage_path("app/public/qrcodes/");
        
        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $bobj = $barcode->getBarcodeObj('QRCODE,H', $uniqid, - 16, - 16, 'black', array(
            - 2,
            - 2,2
            - 2,
            - 2
        ))->setBackgroundColor('transparent');
        
        $imageData = $bobj->getPngData();
        $timestamp = time();

        file_put_contents($targetPath . $fileName, $imageData);

        $user = User::create([
             'name' => $request->name,
             'first_name' => Str::headline($request->first_name),
             'last_name' => Str::headline($request->last_name),
             'ref_user_id' => $this->userUtil->referenceUser($request->reference_name)->uniqid ?? Null,
             'mobile_number' => $request->mobile_number,
             'church_id' => 1,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'uniqid' => $uniqid,
             'sent' => $request->sent,
             'qr_code' => $fileName,
             'church_website' => ($request->church_website ? $request->church_website : null),
             'church_name' => ($request->church_name ? $request->church_name : null),
            ]);

        if($user)
        {
            $otp = random_int(100000, 999999);
            //rand(6, 999999);
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['otp' => $otp,'expire_otp_time' => strtotime("+2 minutes")]
            );
            $user['otp'] = '';
            $user['bodyMsg'] = 'Dear '.$request->name.', your OTP for registration is '.$otp.'.Use this OTP to register.';
            self::mailSend($user); 
            return response([
                'success' => true,
                'sent' => $request->sent,
                'message' => 'We have sent OTP to the email '.$request->email.'. Please click it to complete verification.OTP is valid for 2 minutes.',
                'data' => Config('constants.emptyData'),
            ], config('constants.validResponse.statusCode')); 
        }
        
    }

    public function login(Request $request)
    {
        $data = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required',
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

        // $data['u_type'] = 'USR';
        $attemp = ['email'=>$request->email,'password'=>$request->password];
        if (!auth()->attempt($attemp)) {
            return response([
                'success' => false,
                'message' => 'Incorrect Details. Please try again',
                'data' => []
            ], config('constants.invalidResponse.statusCode'));
        }
        if(auth()->user()->isUser() ){
            $accessToken = auth()->user()->createToken('API Token')->accessToken;
            $otp = random_int(100000, 999999);
            //rand(6, 999999);
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['otp' => $otp,'expire_otp_time' => strtotime("+2 minutes")]
            );

            auth()->user()->otp = '';
            auth()->user()->bodyMsg ='Dear '.auth()->user()->name.', your OTP for login is '.$otp.'.Use this OTP to login.';
            self::mailSend(auth()->user()); 
            return response([
                'success' => true,
                'sent' => $request->sent,
                'message' => 'We have sent OTP to the email '.$request->email.'. Use this OTP to login.OTP is valid for 2 minutes.',
                'data' => Config('constants.emptyData'),
            ], config('constants.validResponse.statusCode'));
        }
        return response([
            'success' => false,
            'message' => 'Incorrect Details. Please try again',
            'data' => []
        ], config('constants.invalidResponse.statusCode'));

    }

    public function userProfile(Request $request){
        $user = User::where('id', $request->user_id)->makeVisible('church_website')->first();
        if(!$user)
        {
            return response([
                'success' => false,
                'message' => 'Something goes wrong.',
            ], config('constants.invalidResponse.statusCode'));
        }
        return response([
            'success' => true,
            'message' => 'success.',
            'data' => $user,
        ], config('constants.invalidResponse.statusCode'));

        return $user;
    }


    public static function mailSend($user)
    {
        if($user)
        {
            \Mail::to($user->email)->send(new \App\Mail\UserMail($user));
        }
    }

   
}
