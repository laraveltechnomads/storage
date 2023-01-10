<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\IPD\ClassMaster;
use App\Models\API\V1\Package\Package;
use App\Models\API\V1\Package\PackageService;
use App\Models\API\V1\Package\PackageTariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PackageConfigController extends Controller
{
    public function adjustAgainst(){
        $adjust = [];
        $adjust[] = [
            'id' => 1,
            'description' => 'Clinic',
        ];
        $adjust[] = [
            'id' => 2,
            'description' => 'Pharmacy',
        ];
        return sendDataHelper('All Adjust Against list.', $adjust, $code = 200);	
    }
    public function listPackageConfig(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $search = @$request['description']; 
                }
            }
            $description = Package::join('specializations','specializations.id','=','packages.s_id')
            ->join('sub_specializations','sub_specializations.id','=','packages.ss_id');
            if(isset($search))
            {
                $description->where('packages.package_name', 'like', "%{$search}%");
            }
            $response = $description->select('packages.id','packages.id as code','packages.package_name','specializations.description as specialization','sub_specializations.description as sub_specialization','packages.rate','packages.status','packages.is_enable')
            ->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Package Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addPackageConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            's_id' => 'required',
            'ss_id' => 'required',
            'package_name' => 'required',
            'sac_code' => 'required',
            'rate' => 'required',
            'duration' => 'required',
            'service_component' => 'required',
            'pharmacy_component' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = Package::create($request);
            DB::commit();
            $package_detail = [
                'package_id' => @$package->id,
                's_id' => @$package->s_id,
                'ss_id' => @$package->ss_id,
                'package_name' => @$package->package_name,
                'sac_code' => @$package->sac_code,
                'rate' => @$package->rate,
                'duration' => @$package->duration,
                'service_component' => @$package->service_component,
                'pharmacy_component' => @$package->pharmacy_component,
            ];
            return sendDataHelper('Package add successfully.', $package_detail, 200);
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function listServiceConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = PackageService::join('service_masters','service_masters.id','=','package_services.service_id')
            ->select('package_services.id','package_services.process_name','service_masters.description as services','package_services.applicable as applicable_to','package_services.rate_limit','package_services.qty')
            ->where('package_services.package_id',$request['package_id'])
            ->get();
            if($package){
                return sendDataHelper('All Service Master list.', $package, $code = 200);	
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addServiceConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
            'package_name' => 'required',
            'service_id' => 'required',
            'rate' => 'required',
            'duration' => 'required',
            'distribution_in' => 'required',
            'service_component' => 'required',
            'pharmacy_component' => 'required',
            'qty' => 'required',
            'applicable' => 'required',
            'consumable' => 'required',
            'adjustable_head' => 'required',
            'process_name' => 'required',
            'adjusted_against' => 'required',
            'rate_limit' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = Package::find($request['package_id']);
            if($package){
                $service = ServiceMaster::find($request['service_id']);
                $request['code'] = $package->id;  
                $request['total_amt'] = ($request['rate']  / 100 ) * $request['service_component'];
                $request['use_amt'] = ($package->use_amt + ($service->base_service_rate * $request['qty']));
                $request['remain_amt'] = $request['total_amt'] - $request['use_amt'];  
                if($request['use_amt'] <= $request['total_amt']){
                    $package->update($request);
                    $package_service = PackageService::create($request);
                    DB::commit();
                    $package_detail = [
                        'package_id' => @$package_service->package_id,
                        'package_name' => @$package_service->package_name,
                        'total_amt' => @$package->total_amt,
                        'remain_amt' => @$package->remain_amt,
                        'use_amt' => @$package->use_amt,
                        'rate' => @$package_service->rate,
                        'duration' => @$package_service->duration,
                        'distribution_in' => @$package_service->distribution_in,
                        'service_component' => @$package_service->service_component,
                        'pharmacy_component' => @$package_service->pharmacy_component,
                        'qty' => @$package_service->qty,
                        'applicable' => @$package_service->applicable,
                        'consumable' => @$package_service->consumable,
                        'adjustable_head' => @$package_service->adjustable_head,
                        'process_name' => @$package_service->process_name,
                        'adjusted_against' => @$package_service->adjusted_against,
                        'rate_limit' => @$package_service->rate_limit,
                    ];
                    return sendDataHelper('Package Service add successfully.', $package_detail, 200);
                }else{
                    return sendErrorHelper('Your Rate Is Out Off Limit.', [], 422);
                }
                if($request['use_amt'] >= $request['total_amt']){
                    return sendErrorHelper('Your Rate Is Not Lowest.', [], 422);
                }
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function listItemConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = Package::find($request['package_id']);
            if($package){
                if(($package->item_list != NULL) || ($package->item_category_list != NULL) || ($package->item_group_list != NULL)){
                    return sendDataHelper('Your All Items Link This packages.', [], $code = 200);
                }else{
                    return sendErrorHelper("No Content", [], 204);
                }
            }
            if($package){
                return sendDataHelper('All Service Master list.', $package, $code = 200);	
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addItemConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
            'package_name' => 'required',
            'rate' => 'required',
            'duration' => 'required',
            'distribution_in' => 'required',
            'service_component' => 'required',
            'pharmacy_component' => 'required',
            'item_list' => 'sometimes|required',
            'item_category_list' => 'sometimes|required',
            'item_group_list' => 'sometimes|required',
            'set_all_items' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = Package::find($request['package_id']);
            if($package){
                if($request['item_list']){
                    $request['item_list'] = implode(",",(array)$request['item_list']);
                }
                if($request['item_category_list']){
                    $request['item_category_list'] = implode(",",(array)$request['item_category_list']);
                }
                if($request['item_group_list']){
                    $request['item_group_list'] = implode(",",(array)$request['item_group_list']);
                }
                $package->update($request);
                DB::commit();
                $package_detail = [
                    'package_id' => @$package->package_id,
                    'item_list' => @$package->item_list,
                    'item_category_list' => @$package->item_category_list,
                    'item_group_list' => @$package->item_group_list,
                ];
                return sendDataHelper('Package Tariff add successfully.', $package_detail, 200);
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }    
    }
    public function listTariffConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = PackageService::join('package_tariffs','package_services.id','=','package_tariffs.package_id')
            ->join('tariff_masters','tariff_masters.id','=','package_tariffs.tariff_id')
            ->select('package_tariffs.id','tariff_masters.description as tariff','package_tariffs.list_class')
            ->where('package_services.package_id',$request['package_id'])
            ->get();
            if($package){
                return sendDataHelper('All Add Tariff list.', $package, $code = 200);	
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function addTariffConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'package_id' => 'required',
            'tariff_id' => 'required',
            'list_class' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        try {
            DB::beginTransaction();
            $package = Package::find($request['package_id']);
            if($package){
                if($request['list_class']){
                    $request['list_class'] = implode(",",(array)$request['list_class']);
                }
                $package_service = PackageTariff::create($request);
                DB::commit();
                $package_detail = [
                    'package_id' => @$package_service->package_id,
                    'tariff_id' => @$package_service->tariff_id,
                    'list_class' => @$package_service->list_class,
                ];
                return sendDataHelper('Package Tariff add successfully.', $package_detail, 200);
            }else{
                return sendError('please provide valid id.', [], 400);
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    //when add service & add item (pharmacy) remaining money then used in MISC service | MISC pharmacy in billing & remaining balance refund to patient & display only used money
}
