<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Plan;
use Illuminate\Http\Request;
use App\Models\Client\Client;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\API\V1\Client\ClientPlan;
use App\Models\API\V1\Clinic\Store;
use App\Models\API\V1\Master\Department;
use Illuminate\Support\Facades\Auth;
use Throwable;
// use Config;

class RazorpayPaymentController extends Controller
{
    public function allPlan(){
        $total_plans = Plan::where('active_status',1)->get();
        $add = [];
        $store_plan[] = [];
        foreach($total_plans as $total_plan){
            $add[] = [
                'id' => $total_plan->id,
                'plan_id' => $total_plan->plan_id,
                'plan_name' => $total_plan->name,
                'description' => $total_plan->description,
                'plan_period' => $total_plan->plan_period,
                'item_id' => $total_plan->item_id,
                'amount' => $total_plan->amount,
                'features' => json_decode($total_plan->features,true)
            ];
        }
        return sendDataHelper('All plan details.', $add, 200);
    }
    //department details
    public function alldepartment(){
        $department = Department::where('status',1)->get(['id','description as name']);
        return sendDataHelper('All Department details.', $department, 200);
    }
    //store details
    public function allstore(){
        $store = Store::where('status',1)->get(['id','description as name']);
        return sendDataHelper('All store details.', $store, 200);
    }
    //store & department details add
    public function addstoredep(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'flag' => 'required',
            'name' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                $store = [
                    'description' => $data['name'],
                    'status' => 1
                ];
                DB::commit();
                if($data['flag'] == 1){
                    if(Department::where(['description' => $data['name'] , 'status' => 1])->first()){
                        return sendErrorHelper('This Entry alredy exist!.', null, 400);
                    }else{
                        Department::create($store);
                        return sendDataHelper('Department add successfully!.', $store, 200);
                    }
                }else{
                    if(Store::where(['description' => $data['name'] , 'status' => 1])->first()){
                        return sendErrorHelper('This Entry alredy exist!.', null, 400);
                    }else{
                        Store::create($store);
                        return sendDataHelper('Store add successfully!.', $store, 200);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function listdomain(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'domain_name' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                $domain_arr = [];
                $domains = $data['domain_name'];
                foreach($domains as $domain){
                    $sub_domain = Client::where('sub_domain',$domain)->first();
                    if($sub_domain){
                        $domain_arr[] = array('domain' => $domain, 'value' => 0);
                    }else{
                        $domain_arr[] = array('domain' => $domain, 'value' => 1);
                    }
                }
                return sendDataHelper('All domain list!.', $domain_arr, $code = 200);
            }catch(\Throwable $e){
                $bug = $e->getMessage();
                return sendErrorHelper("Error", $bug, 422);
            }
        }
    }
    public function createorder(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'client_id' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try{
            $findclient = Client::find($data['client_id']);
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $client_plan = ClientPlan::where([ 'client_id' => $data['client_id'] , 'status' => 2 ])->first();
            if($client_plan){
                $fetch_plan = Plan::find($client_plan->plan_id);
                $cust = $api->customer->create(
                    array('name' =>  $findclient->fname,
                            'email' =>  $findclient->email_address,
                            'contact'=> $findclient->contact_no,
                        )
                    );
                $subscription = $api->subscription->create(
                        array(
                        'plan_id' => $fetch_plan->plan_id,
                        'customer_notify' => 1,
                        'quantity'=>1, 
                        'total_count' => 1, 
                        'start_at' => now(),
                        'notes'=> array(
                            'key1'=> $request->email,
                            'key2'=> $request->fname
                        )
                    )
                );
                $order = $api->order->create(
                    array('amount' =>  $fetch_plan->amount, 
                        'currency' =>  $fetch_plan->currency,  
                        'receipt' => $client_plan->id, 
                        'customer_id'=> $cust->id,
                    )
                );
                $client_plan->update([
                    'order_id' => $order->id,
                    'cust_id'=> $cust->id,
                    'subscription_id' => $subscription->id,
                    'short_url' => $subscription->short_url,
                    'expire_on' => $subscription->expire_by
                ]);
                $order_detail = [
                    'order_id' => $order->id,
                    'cust_id' => $cust->id,
                    'subscription_id' => $subscription->id,
                ];
                return sendDataHelper('Add order details !.', $order_detail, $code = 200);
            }else{
                return sendErrorHelper("Error", "Your payment is done!.", 422);
            }
        } catch (Throwable $e) {
            $bug = $e->getMessage();
            return sendErrorHelper("Error", $bug, 422);
        }
    }
    public function razorpaystore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'client_id' => 'required',
            'razorpay_payment_id' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        
        $client = Client::find($data['client_id']);
        $findclient = ClientPlan::where([ 'client_id' => $data['client_id'],'status'=>2 ])->first();
        $plan = Plan::find($findclient->plan_id);
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            if($findclient){

               $payment = $api->payment->fetch($data['razorpay_payment_id']);
                $transaction_json = [
                    'fname' => $client->fname,
                    'email' => $client->email,
                    'contact_no' => $findclient->contact_no,
                    'razorpay_payment_id' => $payment->id,
                    'international_tran' => $payment->international,
                    'invoice_id' => $payment->invoice_id,
                    'card_id' => $payment->card_id,
                    'order_id' => $findclient->order_id,
                    'bank_id' => $payment->bank,
                    'token_id' => @$payment->token_id,
                    'cust_id'=> $findclient->cust_id,
                    'wallet' => $payment->wallet,
                    'subscription_id' => $findclient->subscription_id,
                    'short_url' => $findclient->short_url,
                    'expire_on' => $findclient->expire_on,
                    'vpa_id' => $payment->vpa,   
                    'payment_method' => $payment->method,
                ];

                $findclient->update([
                    'razorpay_payment_id' => $payment->id,
                    'international_tran' => $payment->international,
                    'invoice_id' => $payment->invoice_id,
                    'card_id' => $payment->card_id,
                    'order_id' => $findclient->order_id,
                    'bank_id' => $payment->bank,
                    'token_id' => @$payment->token_id,
                    'cust_id'=> $findclient->cust_id,
                    'wallet' => $payment->wallet,
                    'subscription_id' => $findclient->subscription_id,
                    'short_url' => $findclient->short_url,
                    'expire_on' => $findclient->expire_on,
                    'vpa_id' => $payment->vpa,   
                    'payment_method' => $payment->method,
                    'transaction_json'=> json_encode($transaction_json), 
                    'status' => 1,
                ]);
                $client->update(['plan_status'=>1]);
                $api->payment->createRecurring(
                    array('email'=> $client->email,
                            'contact'=> $findclient->contact_no,
                            'amount'=> $plan->amount,
                            'currency'=> $plan->currency,
                            'order_id'=> $findclient->order_id,
                            'customer_id'=> $findclient->cust_id,
                            'token'=> @$payment->token_id,
                            'recurring'=>'1',
                            'description'=>'multiply recurring registration'
                        )
                );

                return sendDataHelper('Payment done!.', [], $code = 200);
            }else{
                return sendErrorHelper("Error", "Pending payment user not found!.", 422);
            }
        } catch (Throwable $e) {
            $findclient->update([
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'status' => 2,
            ]);
            $client->update(['plan_status'=>2]);
            $bug = $e->getMessage();
            return sendErrorHelper("Error", $bug, 422);
        }
    } 
    public function pausePlan(Request $request){
        try{
            $validation = Validator::make($request->all(),[
                'response' => 'required'
            ]);
            if($validation->fails()){
                return sendErrorHelper('Validation Error', $validation->errors()->first());
            }
            $data = json_decode(decryptData($request['response']));
            $validator = Validator::make((array)$data,[
                'email_address' => 'required',
                'otp' => 'required',
                'change_status' => 'required',
            ]);
            if($validator->fails()){
                return sendErrorHelper($validator->errors()->first(), [], 422);
            }else{
                $verify = DB::table('password_resets')->where('email',$data->email_address)->first();
                if($verify->otp == $data->otp){
                    $now = strtotime("now");
                    if($now < $verify->expire_otp_time){
                        $client = Client::where(['email_address'=>$data->email_address,'status'=>1])->first();
                        $client_plan = ClientPlan::where('client_id',$client->id)->first();
                        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                        if($data->change_status == 1){
                            $api->subscription->fetch($client_plan->transaction_id)->pause(array('pause_at'=>'now'));
                            $client->update(['status'=>0]);
                            // "subscription can't be paused as subscription is in created state"
                        }else{
                            $api->subscription->fetch($client_plan->transaction_id)->resume(array('resume_at'=>'now'));
                            $client->update(['status'=>1]);
                            // "subscription can't be resumed as subscription is in created state"
                        } 
                        DB::table('password_resets')->where(['otp'=>$data->otp])->delete();
                        DB::commit();
                        return sendDataHelper('Subscription change successfully!.', [], $code = 200);
                    }else{
                        return response([
                            'success' => false,
                            'message' => 'OTP entered is expired.Please generate a new OTP and try again.',
                        ], 401);
                    }

                }else{
                    return sendErrorHelper('Error', 'Invalid otp please try again later!.',422);
                }
            }
        }catch(\Throwable $e){
            DB::commit();
            $error = $e->getMessage();
            return sendErrorHelper('Error', $error,400);
        }
    }
    public function updatePlan(Request $request){
        $id = Auth::guard('client')->user()->id;
        $client_plan = ClientPlan::find($id);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $option = [
            "plan_id"=>$client_plan->razorpay_payment_id,
            "quantity" => 1,
            "remaining_count" => 1,
            "schedule_change_at"=> strtotime(now()),
            "customer_notify"=> 1
          ];
        $api->subscription->fetch($client_plan->transaction_id)->update($option);
    }
}
