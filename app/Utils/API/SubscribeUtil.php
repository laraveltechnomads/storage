<?php

namespace App\Utils\API;

use App\Models\Admin\Plan;
use App\Models\API\V1\Client\ClientPlan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Client\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


Class SubscribeUtil
{
    public function subscribe($request)
    {
        $request->validate([
            'plan_id' => 'required', 
            'payment_method' => 'required'
        ]);
        $plan = Plan::find($request->plan_id);
        if(!$plan)
        {
            return response([
                'success' =>  config('constants.invalidResponse.success'),
                'message' => 'Plan Details Not match!',
                'data' => config('constants.emptyData'),
            ], config('constants.invalidResponse.statusCode')); 
        }
        DB::beginTransaction();
        try {
            
            $client_plan = new ClientPlan;
            $client_plan->amount = $plan->amount;
            $client_plan->plan_id = $plan->id;
            $client_plan->payment_method = $request->payment_method;
            $client_plan->client_id = auth()->user()->id;
            $client_plan->transaction_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $client_plan->transaction_json = null;
            $client_plan->save();
            DB::commit();
            if ($plan) {
                $url = route('admin.plans.index');
                return response([
                    'success' => config('constants.validResponse.success'),
                    'message' => 'Subscription details submitted.',
                    'data' => Config('constants.emptyData'),
                    'client' => $client_plan
                ], config('constants.validResponse.statusCode')); 
            } else {
                return response([
                    'success' =>  config('constants.invalidResponse.success'),
                    'message' => 'Subscription details not submitted!',
                    'data' => config('constants.emptyData'),
                ], config('constants.invalidResponse.statusCode')); 
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return response()->json(['status'=> 0, 'message' => $bug]);
        }
    }
}