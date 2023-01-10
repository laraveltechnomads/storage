<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Plan;
use App\Models\Admin\PlanFeature;
use App\Models\API\V1\Client\ClientPlan;
use App\Models\API\V1\Master\MenuMaster;
use App\Models\API\V1\Master\RoleMaster;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Master\UserRole;
use App\Models\API\V1\User\UserLoginHistory;
use App\Models\Client\Client;
use App\Models\Admin\PasswordReset;
use App\Models\API\V1\Client\ClientDetail;
use App\Models\Client\ClientLoginHistory;
use App\Models\API\V1\Client\RoleMenuDetails;
use App\Models\Client\ClientDatabase;
use App\Models\Client\ClientCredentialCron;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function clientRegistration(Request $request){
        DB::beginTransaction();
        try
        {
            $validation = Validator::make($request->all(),[
                'response' => 'required'
            ]);
            if($validation->fails()){
                $return = sendErrorHelper('Validation Error', $validation->errors()->first());
                return response()->json($return);
            } 
            $data = decryptData($request['response']);
            if($data['current_step'] == 1){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'email_address' => 'required|email|unique:admin_db.clients,email_address',
                    'country_code' => 'required',
                    'contact_no' => 'required|unique:admin_db.clients,contact_no',
                ]);
                if(@$data['client_id']){
                    $validator = Validator::make((array)$data,[
                        'current_step' => 'required',
                        'email_address' => [
                            'required',
                            'email',
                            Rule::unique('admin_db.clients')->ignore($data['client_id'], 'id')
                        ],
                        'country_code' => 'required',
                        'contact_no' => [
                            'required',
                            Rule::unique('admin_db.clients')->ignore($data['client_id'], 'id')
                        ],
                    ]);
                }
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{ 
                    $input = [ 'email_address' => $data['email_address'] , 'country_code' => $data['country_code'], 'contact_no' => $data['contact_no'] ,'clinic'=>1];
                    $otp = rand(1000,9999);
                    $mobotp = rand(1000,9999);
                    if(@$data['client_id']){
                        $clinic = ClientDetail::find($data['client_id']);
                        $clinic->update($input);
                        $id = $data['client_id'];
                        $pass = PasswordReset::where('email',$id)->first();
                        PasswordReset::where('email',$id)->update(['token'=>$mobotp,'otp'=>$otp,'expire_otp_time'=>strtotime('+3 minute')]);
                    }else{
                        $client_id = ClientDetail::create($input);
                        $id = $client_id->id;
                        PasswordReset::insert(['email'=>$id,'token'=>$mobotp,'otp'=>$otp,'expire_otp_time'=>strtotime('+3 minute'),'created_at'=>now()]);
                    }
                
                    $client = [
                        'email' => $data['email_address'],
                        'client_id' => $id,
                        'email_otp' => $otp,
                        'mob_otp' => $mobotp,
                        'current_step' => 1,
                        'next_step' => 2,
                    ];
                    $email = $data['email_address'];
                    Mail::send('otpMail', ['email' => $email,'otp'=>$otp], function($message) use($email,$otp){
                        $message->to($email);
                        $message->subject('verification email');
                    });
                    DB::commit();
                    return sendDataHelper('Clinic data store.', $client, $code = 200);
                }
            }
            if($data['current_step'] == 2){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'email_otp' => 'required|numeric',
                    'mob_otp' => 'required|numeric',
                ]);
                if($validator->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }else{
                    $clinic = PasswordReset::where('email',$data['client_id'])->first();
                    if(($data['mob_otp'] == $clinic->token) && ($data['email_otp'] == $clinic->otp)){
                        $now = strtotime('now');
                        if($now < $clinic->expire_otp_time){
                            $clinic = ClientDetail::find($data['client_id']);
                            $clinic->update([ 'clinic' => 2 ]);
                            PasswordReset::where(['token'=>$data['mob_otp']])->delete();
                            $client = [
                                'client_id' =>  $data['client_id'],
                                'current_step' => 2,
                                'next_step' => 3
                            ];
                            DB::commit();
                            return sendDataHelper('Otp verify successfully!.', $client, $code = 200);
                        }else{
                            return sendErrorHelper('Enter invalid otp please try again later!', [], 422);
                        }
                    }else{
                        return sendErrorHelper('Enter invalid otp please try again later!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 3){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'name' => 'required',
                    'identity' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $clinic->update([
                            'fname' => $data['name'],
                            'identity' => $data['identity'],
                            'clinic' => 3,
                        ]);
                        $add_clinit = [
                            'name' => $data['name'],
                            'identity' => $data['identity'],
                            'client_id' =>  $data['client_id'],
                            'current_step' => 3,
                            'next_step' => 4
                        ];
                        DB::commit();
                        return sendDataHelper('name add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 4){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'bussiness' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $clinic->update([
                            'bussiness' => $data['bussiness'],
                            'clinic' => 4
                        ]);
                        $add_clinit = [
                            'bussiness' => $data['bussiness'],
                            'client_id' =>  $data['client_id'],
                            'current_step' => 4,
                            'next_step' => 5
                        ];
                        DB::commit();
                        return sendDataHelper('bussiness name add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 5){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'password' => [
                    'required',
                    'min:8',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                    'same:password_confirmation',
                ],
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $clinic->update([
                            'password' => Hash::make($data['password']),
                            'clinic' => 5
                        ]);
                        $add_clinit = [
                            'client_id' =>  $data['client_id'],
                            'current_step' => 5,
                            'next_step' => 6
                        ];
                        DB::commit();
                        return sendDataHelper('password add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 6){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'terms' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $clinic->update([
                            'terms' => $data['terms'],
                            'clinic' => 6
                        ]);
                        $add_clinit = [
                            'terms' => $data['terms'],
                            'client_id' =>  $data['client_id'],
                            'current_step' => 6,
                            'next_step' => 7
                        ];
                        DB::commit();
                        return sendDataHelper('terms & condition add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 7){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'id' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $plan = Plan::find($data['id']);
                        if($client_plan_id = ClientPlan::where(['client_id'=>$data['client_id'],'status'=>2])->first()){
                            $client_plan_id->update(['amount' => $plan->amount,'plan_id'=>$data['id']]);
                        }else{
                            ClientPlan::create(['client_id'=>$data['client_id'],'amount' => $plan->amount,'plan_id'=>$data['id'],'status'=>2]);
                        }
                        $clinic->update(['clinic' => 7]);
                        $id = encrypt($data['client_id']);
                        $add_clinit = [
                            'fname' => $clinic->fname,
                            'email_address' => $clinic->email_address,
                            'identity' => $clinic->identity,
                            'contact_no' => $clinic->contact_no,
                            'plan_id' => $data['id'],
                            'plan_currency' => $plan->currency,
                            'plan_amount' => $plan->amount,
                            // 'page_url' => env('APP_API_URL').'/razorpay-payment/'.$id,
                            'current_step' => 7,
                            'next_step' => 8
                        ];
                        DB::commit();
                        return sendDataHelper('plan add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 8){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'status' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = ClientDetail::find($data['client_id']);
                    if(!empty($clinic)){
                        $clinic->update(['clinic' => 8]);
                        if($client_plan_id = ClientPlan::where(['client_id'=>$data['client_id'],'status'=>'pending'])->first()){
                            $client_plan_id->update(['status'=>$data['status']]);
                            if($client_plan_id->status != 1){
                                return sendErrorHelper('Please first payment of selected plan!', [], 422);
                            }
                        }
                        $add_clinit = [
                            'status' => $data['status'],
                            'client_id' =>  $data['client_id'],
                            'current_step' => 8,
                            'next_step' => 9
                        ];
                        DB::commit();
                        return sendDataHelper('payment status update successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                    
                }
            }
            if($data['current_step'] == 9){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'domain' => 'required|min:5|unique:admin_db.clients,sub_domain,'.$data['client_id'].',id',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $client = ClientDetail::find($data['client_id']); // admin client
                    if(!empty($client)){
                        $add_clinit = [
                            'sub_domain' => $data['domain'],
                            'client_id' =>  $data['client_id'],
                            'current_step' => 9,
                            'next_step' => 10,
                        ];
                       
                        $client->update([ 'sub_domain' => $data['domain'],'clinic' => 9 ,'db_name' => 'db_multiple_client_'.$data['client_id'] ]);
                        $clientCred = [
                            'f_name' => $client->fname,
                            'l_name' => $client->lname,
                            'title' => "Client Process",
                            'body' => "We have touch you shortly with your own domain and Database",
                        ];
                        $email = $client->email_address;
                        Mail::send('emails.credential_asap', $clientCred, function($message) use($email){
                            $message->to($email);
                            $message->subject('Client Alert');
                        });
                        ClientDatabase::create([
                            'client_id' => $data['client_id'], 
                            'database_name' => 'db_multiple_client_'.$data['client_id']
                        ]);
                        DB::commit();
                        return sendDataHelper('Domain add successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 10){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'client_id' => 'required',
                    'address' => 'required',
                    'name' => 'required|unique:units,clinic_name,'.@$data['clinic_id'].',id',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $c_id = Auth::guard('client')->user();
                    if(@$data['clinic_id']){
                        $clinic = Unit::find($data['clinic_id']);
                        ClientDetail::where('id',$clinic->c_id)->update(['clinic' => 10]);
                        $clinic->update(['address_line1' => $data['address'],'clinic_name' => $data['name'],'c_id' => $data['client_id'] ]);
                        $clinic_id = $data['clinic_id'];
                    }else{
                        $clinic = Unit::create(['address_line1' => $data['address'],'clinic_name' => $data['name'],'c_id' => $data['client_id'] ]);
                        $clinic_id = $clinic->id;
                    }
                    $add_clinit = [
                        'address' => $data['address'],
                        'clinic_id' =>  $clinic_id,
                        'current_step' => 10,
                        'next_step' => 11
                    ];
                    DB::commit();
                    return sendDataHelper('Clinic address add successfully!.', $add_clinit, $code = 200);
                }
            }
            if($data['current_step'] == 11){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'clinic_id' => 'required',
                    'gst_no' => 'required',
                    'reg_no' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = Unit::find($data['clinic_id']);
                    ClientDetail::where('id',$clinic->c_id)->update(['clinic' => 11]);
                    if(!empty($clinic)){
                        $clinic->update(['gstn_no'=>$data['gst_no'],'clinic_reg_no'=>$data['reg_no']]);
                        $add_clinit = [
                            'reg_no'=>$data['reg_no'],
                            'gst_no'=>$data['gst_no'],
                            'clinic_id' =>  $data['clinic_id'],
                            'current_step' => 11,
                            'next_step' => 12
                        ];
                        DB::commit();
                        return sendDataHelper('Detail update successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 12){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'clinic_id' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = Unit::find($data['clinic_id']);
                    ClientDetail::where('id',$clinic->c_id)->update(['clinic' => 12]);
                    if(!empty($clinic)){
                        if(@$request->logo){
                            deleteFile($clinic->logo,'client_registration');
                            $name = uploadFile($request->logo,'client_registration',$clinic->id,1);
                            $clinic->update(['logo' => $name]);
                        }
                        
                        $add_clinit = [
                            'clinic_id' =>  $data['clinic_id'],
                            'current_step' => 12,
                            'next_step' => 13
                        ];
                        DB::commit();
                        return sendDataHelper('Clinic profile update successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 13){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'clinic_id' => 'required',
                    'department' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = Unit::find($data['clinic_id']);
                    ClientDetail::where('id',$clinic->c_id)->update(['clinic' => 13]);
                    if(!empty($clinic)){
                        $clinic->update(['department'=> $data['department']]);
                        $add_clinit = [
                            'department' =>  $clinic->department,
                            'clinic_id' =>  $clinic->id,
                            'current_step' => 13,
                            'next_step' => 14
                        ];
                        DB::commit();
                        return sendDataHelper('Clinic department update successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
            if($data['current_step'] == 14){
                $validator = Validator::make((array)$data,[
                    'current_step' => 'required',
                    'clinic_id' => 'required',
                    'store' => 'required',
                ]);
                if($validator->fails()){
                    return sendErrorHelper($validator->errors()->first(), [], 422);
                }else{
                    $clinic = Unit::find($data['clinic_id']);
                    ClientDetail::where('id',$clinic->c_id)->update(['clinic' => 14]);
                    if(!empty($clinic)){
                        $clinic->update(['store' => $data['store']]);
                        $add_clinit = [
                            'store' =>  $data['store'],
                            'clinic_id' =>  $data['clinic_id'],
                            'current_step' => 14,
                        ];
                        $client = ClientDetail::find($clinic->c_id); // admin client
                        /** client db */
                        ClientCredentialCron::updateOrCreate( ['client_id' => $client->id],[
                            'client_id' => $client->id,
                            'client_fname' => $client->fname,
                            'client_lname' => $client->lname,
                            'email_address' => $client->email_address,
                            'sub_domain' => $client->sub_domain,
                            'db_name' => 'multiply_client_'.$clinic->c_id,
                            'status' => 0,
                            'client_json' => json_encode([
                                'password' => $client->password,
                                'clinic' => $client->clinic,
                                'contact_no' => $client->contact_no,
                                'type' => $client->type,
                                'identity' => $client->identity,
                                'bussiness' => $client->bussiness,
                                'terms' => $client->terms,
                                'plan_status' => $client->plan_status,
                                'status' => $client->status,
                                'remember_token' => $client->remember_token,
                            ])
                        ]);
                        DB::commit();
                        return sendDataHelper('Clinic store update successfully!.', $add_clinit, $code = 200);
                    }else{
                        return sendErrorHelper('Please enter valid clinic id!', [], 422);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function getTypeReg(Request $request){
        $validation = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validation->fails()){
            return sendErrorHelper('Validation Error', $validation->errors()->first());
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'email_address'  => 'required',
            'contact_no' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            if($client = ClientDetail::where('email_address' , $data['email_address'])->orWhere('contact_no' , $data['contact_no'])->first()){
                if($client && ClientDetail::where(['email_address' => $data['email_address'],'contact_no' => $data['contact_no']])->first()){
                    if($client->clinic > 10){
                        $unit = Unit::where('c_id',@$client->id)->first();
                    }
                    if($client->clinic <= 14 || $client->clinic == ""){
                        $detail = [
                            'type' => @$client->clinic,
                            'client_id' => @$client->id,
                            'email_address' => @$client->email_address,
                            'contact_no' => @$client->contact_no,
                            'name' => @$client->fname,
                            'identity' => @$client->identity,
                            'bussiness' => @$client->bussiness,
                            'domain' => @$client->sub_domain,
                            'clinic_id' => ($client->clinic > 10) ? @$unit->id : NULL,
                            'clinic_name' => ($client->clinic > 10) ? @$unit->clinic_name : NULL,
                            'address' => ($client->clinic > 10) ? @$unit->address_line1 : NULL,
                            'reg_no' => ($client->clinic > 10) ? @$unit->clinic_reg_no : NULL,
                            'gst_no' => ($client->clinic > 10) ? @$unit->gstn_no : NULL,
                            'store' => ($client->clinic > 10) ? @json_decode($unit->store) : NULL,
                            'department' => ($client->clinic > 10) ? @json_decode($unit->department) : NULL,
                        ];
                        return sendDataHelper('User Found!.', $detail, $code = 200);
                    }
                }else{
                    $key = [
                        'name' => "your email or contact no is not match."
                    ];
                    return sendErrorHelper('User not found!.', $key);
                }
            }else{
                return sendError('User not found!.', [], $code = 404);
            }
        }
    }
    public function resendOtp(Request $request){
        $validation = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validation->fails()){
            return sendErrorHelper('Validation Error', $validation->errors()->first());
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'client_id' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            DB::beginTransaction();
            try
            {
                $clinic = PasswordReset::where('email',$data['client_id'])->first();
                if(!empty($clinic)){
                    $otp = rand(1000,9999);
                    $mobotp = rand(1000,9999);
                    $clinic = ClientDetail::find($data['client_id']);
                    $email = $clinic->email_address;
                    PasswordReset::where('email',$data['client_id'])->update(['token'=>$mobotp,'otp'=>$otp,'expire_otp_time'=>strtotime('+3 minute')]);
                    Mail::send('otpMail', ['email' => $email,'otp'=>$otp], function($message) use($email,$otp){
                        $message->to($email);
                        $message->subject('verification email');
                    });
                    $client = [
                        'client_id' =>  $data['client_id'],
                        'email_otp' => $otp,
                        'mob_otp' => $mobotp
                    ];
                    DB::commit();
                    return sendDataHelper('Otp sent successfully!.', $client, $code = 200);
                }else{
                    return sendErrorHelper('Please enter invalid client id!', [], 422);
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }

    public function changePass(Request $request){
        return $request;
    }

    /* clientRegister */
    public function clientRegister(Request $request)
    {
        // dd(config('database.connections.mysql.database'));
        // return Client::get();
        // dd( config('database.connections.admin_db') ); 
        DB::beginTransaction();
        try
        {
            $data = Validator::make($request->all(),[
                'email_address' => 'required|email|unique:'.config('database.connection_admin').'.clients',
                'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/|string',
                // 'clinic_name' => 'required|unique:units',
                'sub_domain' => 'required|unique:'.config('database.connection_admin').'.clients',
            ],[
                'password.regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }else{
                $request['email_address'] = Str::replace(' ','', $request['email_address']);
                
                // $unit = Unit::create(['sub_domain'=>$request->sub_domain,'clinic_name'=>$request->clinic_name]);
                
                
                $client = new Client;
                $client->fname = Str::random('10');
                $client->lname = Str::random('10');
                $client->email_address = $request->email_address;
                $client->password = Hash::make($request->password);
                $client->sub_domain = $request->sub_domain;
                // $client->clinic = $unit->id;
                $client->type = 1;
                $client->contact_no = rand(100000000, 999999999);
                $client->save();
                
                if($client)
                {
                    // $unit = Unit::where(['id'=> $unit->id])->update(['c_id'=> $client->id]);
                    // $db = DB::statement('CREATE DATABASE IF NOT EXISTS ' .'db_multiple_client_'.$client->id);
                    $db = DB::statement('CREATE DATABASE ' .'db_multiple_client_'.$client->id);
                    if($db == 1)
                    {
                        $client->db_name = 'db_multiple_client_'.$client->id;
                        $client->save();
                        
                        // Config::set('database.connections.mysql2.database', 'db_multiple_client_121');
                        // Session::put('DB_DATABASE', 'db_multiple_client_121');
                        // config('database.connections.mysql2.database');
                        // Artisan::call("migrate --database=mysql2");
                    }
                    $client['db_name'] = 'db_multiple_client_'.$client->id;

                    DB::commit();
                    return sendDataHelper('Registration Successfully Done.', $client->toArray(), $code = 200);
                }
            }
          
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    } 
    public function clientLogin(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */            
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'email_address' => 'email|required',
                'password' => 'required',
                'clinic_id' =>'required'
            ]);
            
            if ($data->fails())
            {
                return sendError($data->errors()->first(), [], 422);
            }
            $client_details = ClientDetail::where('email_address', $request['email_address'])->first();
            // if($client_details)
            // {
            //     $client = Client::firstOrNew(['id' => $client_details->id]);
            //     $client->email_address = $client_details->email_address;
            //     $client->password = Hash::make($request['password']);
            //     $client->sub_domain = $client_details->sub_domain;
            //     // $client->db_name = $client_details->db_name;
            //     $client->contact_no = $client_details->contact_no;
            //     $client->type = $client_details->type;
            //     // $client->identity = $client_details->identity;
            //     // $client->bussiness = $client_details->bussiness;
            //     // $client->terms = $client_details->terms;
            //     // $client->plan_status = $client_details->plan_status;
            //     $client->fname = $client_details->fname;
            //     $client->lname = $client_details->lname;
            //     $client->status = $client_details->status;
            //     $client->save();
            // }
            // $client = Client::where('email_address', $request['email_address'])->first();            
            $credential = [
                'email_address' => $request['email_address'],
                'password' => $request['password']
            ];
            if(!Auth::guard('client')->attempt($credential)){
                return sendError('Incorrect Details. Please try again', [], 400);
            }
            // return auth()->check();
            $client = Auth::guard('client')->user();
            if($client){
                // $accessToken = auth()->user()->createToken('API Token')->accessToken;
                // $token = $client->createToken($client->fname);
                
                ClientLoginhistory::Create([
                    'client_id' => $client->id,
                    'ip_address' => rand(10000, 99999) ?? NULL,
                    'browser_name' => Str::random(10)
                ]);
                DB::commit();
                $type = $client->type;
                $accessToken = $client->createToken('auth_token_client', ['client', 'type:'.$type, 'role:'.'add_user'])->plainTextToken;
                $response = [
                    'accessToken' =>  $accessToken,
                    'token_type' => 'Bearer'
                ];
                return sendDataHelper('Login success.', $response, $code = 200, $accessToken);
            }
            return sendError('Incorrect Details. Please try again', [], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function planFeatures(){
        $totle_plan = PlanFeature::where('status',1)->get(['id','plan_detail']);
        return sendDataHelper('All Patient features details.', $totle_plan, 200);
    }

    /* userRegister */
    public function userRegister(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $data = Validator::make($request->all(),[
                'name' => 'required',
                'email_address' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/|string',
                'clinic_id' => 'required|exists:units,id',
            ],[
                'password.regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
            ]);

            if($data->fails()){
                return response([
                    'success' => false,
                    'message' => $data->errors()->first(),
                ], config('constants.invalidResponse.statusCode')); 
                // return $this->encryptData($return);
            }else{
                $client = auth()->guard('client')->user();
                $unit_id = Unit::where('c_id', $client->id)->where('id', 'clinic_id')->value('id');
                
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email_address;
                $user->password = Hash::make('Admin@123');
                $user->unit_id = $unit_id;
                $user->client_id = $client;
                $user->save();
                if($user){
                    DB::commit();
                    return response([
                        'success' => true,
                        'message' => 'User Registration Successfully Done.',
                        'data' => $user->toArray()  
                        // 'data' => Config('constants.emptyData')
                    ], config('constants.validResponse.statusCode')); 
                }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* user login **/
    public function userLogin(Request $request)
    {
        DB::beginTransaction();
        try {
        
            if(respValid($request)) { return respValid($request); }  /* response required validation */
                
            $request = decryptData($request['response']); /* Dectrypt  **/
            $data = Validator::make($request,[
                'email_address' => 'required|email|exists:users,email',
                'password' => 'required',
                'clinic_id' => 'required|exists:units,id',
            ],[
                'email_address.exists' => "Invalid Details. Please try again"
            ]);

            if ($data->fails())
            {
                return sendError($data->errors()->first(), [], 422);
            }

            $credential = [
                'email' => $request['email_address'],
                'password' => $request['password']
            ];

            if(!Auth::guard('user')->attempt($credential)){
                return sendError('Incorrect Details. Please try again', [], 422);
            }

            $user = Auth::guard('user')->user();
            // $user_role = UserRole::whereStatus(1)->where('user_id',$user->id)->first();
            // $role_master = RoleMaster::whereStatus(1)->find($user_role->role_id);
            // $role_details = RoleMenuDetails::whereStatus(1)->where('role_id',$role_master->id)->get();
            // $roles = [];
            // foreach($role_details as $role_detail){
            //     $menu_role = MenuMaster::select('id','title')->find($role_detail->menu_id);
            //     $title = str_replace(" ","_",strtolower($menu_role->title));
            //     // return ;
            //     $roles[$title] = [
            //         'create' => ($role_detail->is_create == 1) ? 1 : 0,
            //         'update' => ($role_detail->is_update == 1) ? 1 : 0,
            //         'print' => ($role_detail->is_print == 1) ? 1 : 0,
            //         'all' => ($role_detail->is_all == 1) ? 1 : 0,
            //         'view' => ($role_detail->is_create == 1) ? 1 : 0,
            //     ];
            // }
            // $user_data = [
            //     'name' => $user->name,
            //     'email' => $user->email,
            //     'unit_id' => $user->unit_id,
            //     'permission' => $roles
            // ];
            // if($user_data){
            //     $accessToken = auth()->user()->createToken('API Token')->accessToken;
            //     $token = $user->createToken('auth_token_user', ['user', 'type:'.$type])->plainTextToken;
            // }
            UserLoginHistory::Create([
                'user_id' => $user->id,
                'ip_address' => rand(10000, 99999) ?? NULL,
                'browser_name' => Str::random(10)
            ]);

            $type = $user->type;
            $accessToken = $user->createToken('auth_token_user', ['user', 'type:'.$type])->plainTextToken;
            $response = [
                // 'data' =>$user_data,
                // 'accessToken' =>  Crypt::encryptString($client->createToken('auth_token_user', ['user', 'type:'.$type])->plainTextToken),
                'accessToken' =>  $accessToken,
                'token_type' => 'Bearer'
            ];
            DB::commit();
            return sendDataHelper('Login success.', $response, $code = 200, $accessToken);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* User details show */
    public function details(Request $request)
    {
        // $datareq['profile_image'] = $request->profile_image;
        // if (@$datareq['profile_image']) {
        //     return $proof_file = uploadFile($datareq['profile_image'], patients_profile_dir(), 'pf');
        // }
            UserRole::get();
            RoleMaster::get();

        try {
            $response = [];
            $query = User::query();
            $query->with('user_roles.roles')->has('user_roles');
            $user = $query->where('id', auth()->guard('user')->user()->id)->first();
            if($user)
            {
                $roleArr = [];
                foreach ($user->user_roles as $key => $role) {
                    $arr = [
                        'role_id' => $role->roles->id,
                        'role_name' => $role->roles->description
                    ];
                    array_push($roleArr, $arr);
                }
                $response = [
                    'user_id' => $user->id,
                    'unit_id' => $user->unit_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => [
                        $roleArr
                    ]
                ];
            }
            return sendDataHelper('Login profile details..', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
        
    }
}