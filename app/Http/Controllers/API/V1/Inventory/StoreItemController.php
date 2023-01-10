<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Clinic\Store;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Inventory\StoreItem;
use App\Models\API\V1\Master\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StoreItemController extends Controller
{

    /*store items list insert */
    public function itemStoreListInsert(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'store_date' => 'required|date|date_format:Y-m-d',
                'exp_delivery_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'item_ids' => 'required',
                'unit_id' => 'required',
                'store_item_type_id' => 'required',
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $store_date = date('Y-m-d', strtotime($request['store_date']) );
            $exp_delivery_date = date('Y-m-d', strtotime($request['exp_delivery_date']) );
            $unit_id = $request['unit_id'];
            $item_ids = $request['item_ids'];

            $unit = Unit::where('id', $unit_id)->whereStatus(1)->first();
            if(!$unit)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }
            $from_store = Store::where('id', $request['from_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$from_store)
            {
                return sendError('From store details not found.', [], $code = 404);
            }

            $to_store = Store::where('id', $request['to_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$to_store)
            {
                return sendError('To store details not found.', [], $code = 404);
            }
            
            $s_item = new StoreItem;
            $s_item->store_no = 'MVF-2022'.strtotime(now());
            $s_item->unit_id = $unit->id;
            $s_item->item_ids = $item_ids;
            $s_item->store_date = $store_date;
            $s_item->exp_delivery_date = $exp_delivery_date;
            if(@$request['store_item_type_id'])
            {
                $s_item->store_item_type_id = @$request['store_item_type_id'];
            }
            
            $s_item->from_store_id = $from_store->id;
            $s_item->to_store_id = $to_store->id;
            if(@$request['reason'])
            {    
                $s_item->reason = @$request['reason'];
            }
            if(@$request['remark'])
            {    
                $s_item->remark = @$request['remark'];
            }
            if(@$request['against_patient'] && @$request['patient_id'])
            {    
                $s_item->patient_id = @$request['patient_id'];
            }
            
            $s_item->save();
            if($s_item)
            {
                $s_item = StoreItem::where('id', $s_item->id)->where('unit_id', $unit->id)->first();
                DB::commit();
                $response = [
                    'store_id' => $s_item->id,
                    'store_date' => $s_item->store_date,
                    'exp_delivery_date' => $s_item->exp_delivery_date,
                    'store_item_type_id' => $s_item->store_item_type_id,
                    'item_ids' => $s_item->item_ids, 
                    'from_store_id' => $s_item->from_store_id,
                    'to_store_id' => $s_item->to_store_id,
                    'patient_id' => $s_item->patient_id,
                    'reason' => $s_item->reason,
                    'remark' => $s_item->remark,
                    'unit_id' => $s_item->unit_id,
                ];
                return sendDataHelper('Issue list view.', $response, $code = 200);
            }else{
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /*store items list update */
    public function itemStoreListUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $data = Validator::make($request,[
                'store_item_id' => 'required',
                'store_date' => 'required|date|date_format:Y-m-d',
                'exp_delivery_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'item_ids' => 'required',
                'unit_id' => 'required',
                'store_item_type_id' => 'required',
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            $store_item_id = @$request['store_item_id'];
            $store_date = date('Y-m-d', strtotime($request['store_date']) );
            $exp_delivery_date = date('Y-m-d', strtotime($request['exp_delivery_date']) );
            $unit_id = $request['unit_id'];
            $item_ids = $request['item_ids'];

            $unit = Unit::where('id', $unit_id)->whereStatus(1)->first();
            if(!$unit)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }
            $from_store = Store::where('id', $request['from_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$from_store)
            {
                return sendError('From store details not found.', [], $code = 404);
            }

            $to_store = Store::where('id', $request['to_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$to_store)
            {
                return sendError('To store details not found.', [], $code = 404);
            }
            
            $s_item = StoreItem::find($store_item_id);
            $s_item->store_no = 'MVF-2022'.strtotime(now());
            $s_item->unit_id = $unit->id;
            $s_item->item_ids = $item_ids;
            $s_item->store_date = $store_date;
            $s_item->exp_delivery_date = $exp_delivery_date;
            if(@$request['store_item_type_id'])
            {
                $s_item->store_item_type_id = @$request['store_item_type_id'];
            }
            
            $s_item->from_store_id = $from_store->id;
            $s_item->to_store_id = $to_store->id;
            if(@$request['reason'])
            {    
                $s_item->reason = @$request['reason'];
            }
            if(@$request['remark'])
            {    
                $s_item->remark = @$request['remark'];
            }
            if(@$request['against_patient'] && @$request['patient_id'])
            {    
                $s_item->patient_id = @$request['patient_id'];
            }
            
            $s_item->save();
            if($s_item)
            {
                $s_item = StoreItem::where('id', $s_item->id)->where('unit_id', $unit->id)->first();
                DB::commit();
                $response = [
                    'store_id' => $s_item->id,
                    'store_date' => $s_item->store_date,
                    'exp_delivery_date' => $s_item->exp_delivery_date,
                    'store_item_type_id' => $s_item->store_item_type_id,
                    'item_ids' => $s_item->item_ids, 
                    'from_store_id' => $s_item->from_store_id,
                    'to_store_id' => $s_item->to_store_id,
                    'patient_id' => $s_item->patient_id,
                    'reason' => $s_item->reason,
                    'remark' => $s_item->remark,
                    'unit_id' => $s_item->unit_id,
                ];
                return sendDataHelper('Issue list view.', $response, $code = 200);
            }else{
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /*store items list delete */
    public function storeItemListDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'issue_number' => 'required',
                'store_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'unit_id' => 'required'
            ],[
                'issue_date.date' => 'The date of store date is not a valid date.',
            ]);

            if($data->fails()){ 
                return sendError($data->errors()->first(), [], 422);
            }

            $issue_date = date('Y-m-d', strtotime($request['issue_date']) );
            $unit_id = $request['unit_id'];

            $unit = Unit::where('id', $unit_id)->whereStatus(1)->first();
            if(!$unit)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }

            $from_store = Store::where('id', $request['from_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$from_store)
            {
                return sendError('From store details not found.', [], $code = 404);
            }

            $to_store = Store::where('id', $request['from_store_id'])->where('created_unit_id', $unit_id)->whereStatus(1)->first();
            if(!$to_store)
            {
                return sendError('To store details not found.', [], $code = 404);
            }

            $issue = StoreItem::query();
            $issue->where('id', @$request['store_no']);
            $issue->where('store_date', $issue_date);
            $issue->where('from_store_id', @$request['from_store_id']);
            $issue->where('to_store_id', @$request['to_store_id']);
            $issue->where('unit_id', @$request['unit_id']);
            
            if($issue->delete())
            {
                DB::commit();
                $response = [];
                return sendDataHelper('Store item list deleted.', $response, $code = 200);
            }else{
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function storeItemFilterList(Request $request)
    {   
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make($request,[
                'unit_id'=>'required',
                'from_store_id'=>'required',
                'to_store_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d',
                'store_no'=>'sometimes'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                $from_date = date('Y-m-d', strtotime($request['from_date']) );
                $to_date = date('Y-m-d', strtotime($request['to_date']) );
                $unit_id = $request['unit_id'];

                $unit = Unit::where('id', $unit_id)->first();
                if(!$unit)
                {
                    return sendError('Clinic details not found.', [], $code = 404);
                }
                
                $response = StoreItem::where('unit_id', $unit_id);
               
                if(@$from_date && @$to_date)
                {
                    $response->whereBetween('store_date', [$from_date, $to_date]);
                }

                if(@$request['store_no'])
                {
                    $response->where('store_no', $request['store_no']);
                }

                if(@$request['from_store_id'])
                {
                    $response->where('from_store_id', $request['from_store_id']);
                }
                if(@$request['to_store_id'])
                {
                    $response->where('to_store_id', $request['to_store_id']);
                }
                $response = $response->get();
                foreach($response as $key => $result) {
                    $items = explode(',', $result['item_ids']);
                    $result['items'] = Item::whereIn('id', $items)->get(['id','item_code','item_name','qty','purchase_uom','remarks']);
                }
                
                if ($response) {
                    return sendDataHelper('Store Items list view.', $response, $code = 200);
                } else {
                    return sendError('Store list not found.', [], $code = 404);
                }
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
