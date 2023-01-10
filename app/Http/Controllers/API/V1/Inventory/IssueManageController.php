<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Clinic\Store;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Master\IssueManagement;
use App\Models\API\V1\Master\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IssueManageController extends Controller
{
    public function issuePaginationList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'from_date' => 'required|date|date_format:Y-m-d',
                'to_date' => 'required|date|date_format:Y-m-d',
                'unit_id' => 'required'
            ],[
                'from_date.date' => 'The date of from date is not a valid date.',
                'to_date.date' => 'The date of to date is not a valid date.'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime($request['from_date']) );
            $to_date = date('Y-m-d', strtotime($request['to_date']) );
            $unit_id = $request['unit_id'];

            $unit = Unit::where('id', $unit_id)->first();
            if(!$unit)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }
            
            $response = IssueManagement::query();
            $response->where('unit_id', $unit_id);
            $response->whereBetween('issue_date', [$from_date, $to_date]);
            $response->whereStatus(1);
            $response = $response->paginate(2);

            foreach ($response as $key => $issue) {
                $response[$key] =[
                    'issue_id' => $issue->id,
                    'issue_date' => $issue->issue_date,
                    'item_id' => $issue->item_id, 
                    'from_store_id' => $issue->from_store_id,
                    'to_store_id' => $issue->to_store_id,
                    'issue_reason' => $issue->issue_reason,
                    'remark' => $issue->remark,
                    'amount' => $issue->amount,
                    'unit_id' => $issue->unit_id,
                ];
            } 
            
            return sendDataHelper('Issue list view.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Select issue managament list view */
    public function selectedIssueList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'from_date' => 'required|date|date_format:Y-m-d',
                'to_date' => 'required|date|date_format:Y-m-d',
                'item_id' => 'required',
                'unit_id' => 'required'
            ],[
                'from_date.date' => 'The date of from date is not a valid date.',
                'to_date.date' => 'The date of to date is not a valid date.'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime($request['from_date']) );
            $to_date = date('Y-m-d', strtotime($request['to_date']) );
            $unit_id = $request['unit_id'];
            $item_id = $request['item_id'];

            $unit = Unit::where('id', $unit_id)->whereStatus(1)->first();
            if(!$unit)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }

            $item = Item::where('id', $item_id)->where('unit_id', $unit_id)->whereStatus(1)->first();
            if(!$item)
            {
                return sendError('Clinic details not found.', [], $code = 404);
            }
            
            $response = IssueManagement::query();
            $response->where('unit_id', $unit->id);
            $response->whereBetween('issue_date', [$from_date, $to_date]);
            $response->whereStatus(1);
            $response->where('item_id', $item->id);
            $response = $response->paginate(2);

            foreach ($response as $key => $issue) {
                $response[$key] =[
                    'issue_id' => $issue->id,
                    'issue_date' => $issue->issue_date,
                    'item_id' => $issue->item_id, 
                    'from_store_id' => $issue->from_store_id,
                    'to_store_id' => $issue->to_store_id,
                    'issue_reason' => $issue->issue_reason,
                    'remark' => $issue->remark,
                    'amount' => $issue->amount,
                    'unit_id' => $issue->unit_id,
                ];
            } 
            
            return sendDataHelper('Issue list view.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /*Issue list store */
    public function issueListStore(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'issue_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'item_ids' => 'required',
                'unit_id' => 'required'
            ],[
                'issue_date.date' => 'The date of issue date is not a valid date.',
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $issue_date = date('Y-m-d', strtotime($request['issue_date']) );
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
            
            $issue = new IssueManagement;
            $issue->unit_id = $unit->id;
            $issue->item_ids = $item_ids;
            $issue->issue_date = $issue_date;
            $issue->from_store_id = $from_store->id;
            $issue->to_store_id = $to_store->id;
            if(@$request['issue_reason'])
            {    
                $issue->issue_reason = @$request['issue_reason'];
            }
            if(@$request['remark'])
            {    
                $issue->remark = @$request['remark'];
            }
            if(@$request['amount'])
            {    
                $issue->amount = @$request['amount'];
            }
            $issue->save();
            if($issue)
            {
                $issue = IssueManagement::where('id', $issue->id)->where('unit_id', $unit->id)->first();
                DB::commit();
                $response = [
                    'issue_id' => $issue->id,
                    'issue_date' => $issue->issue_date,
                    'item_ids' => $issue->item_ids, 
                    'from_store_id' => $issue->from_store_id,
                    'to_store_id' => $issue->to_store_id,
                    'issue_reason' => $issue->issue_reason,
                    'remark' => $issue->remark,
                    'amount' => $issue->amount,
                    'unit_id' => $issue->unit_id,
                ];
                return sendDataHelper('Issue list submitted.', $response, $code = 200);
            }else{
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /*Issue list update */
    public function issueListUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'issue_number' => 'required',
                'issue_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'item_ids' => 'required',
                'unit_id' => 'required'
            ],[
                'issue_date.date' => 'The date of issue date is not a valid date.',
            ]);

            if($data->fails()){ 
                return sendError($data->errors()->first(), [], 422);
            }

            $issue_date = date('Y-m-d', strtotime($request['issue_date']) );
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
            
            $issue = IssueManagement::where('id', @$request['issue_number'])->first();
            if(!$issue)
            {
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
            $issue->unit_id = $unit->id;
            $issue->item_ids = $item_ids;
            
            $issue->from_store_id = $from_store->id;
            $issue->to_store_id = $to_store->id;
          
            if($issue_date)
            {    
                $issue->issue_date = $issue_date;
            }
            if(@$request['issue_reason'])
            {    
                $issue->issue_reason = @$request['issue_reason'];
            }
            if(@$request['remark'])
            {    
                $issue->remark = @$request['remark'];
            }
            if(@$request['amount'])
            {    
                $issue->amount = @$request['amount'];
            }
            $issue->save();

            if($issue)
            {
                $issue = IssueManagement::where('id', $issue->id)->where('unit_id', $unit->id)->first();
                DB::commit();
                $response = [
                    'issue_id' => $issue->id,
                    'issue_date' => $issue->issue_date,
                    'item_ids' => $issue->item_ids, 
                    'from_store_id' => $issue->from_store_id,
                    'to_store_id' => $issue->to_store_id,
                    'issue_reason' => $issue->issue_reason,
                    'remark' => $issue->remark,
                    'amount' => $issue->amount,
                    'unit_id' => $issue->unit_id,
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


    /*Issue list delete */
    public function issueListDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'issue_number' => 'required',
                'issue_date' => 'required|date|date_format:Y-m-d',
                'from_store_id' => 'required',
                'to_store_id' => 'required',
                'unit_id' => 'required'
            ],[
                'issue_date.date' => 'The date of issue date is not a valid date.',
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

            $issue = IssueManagement::query();
            $issue->where('id', @$request['issue_number']);
            $issue->where('issue_date', $issue_date);
            $issue->where('from_store_id', @$request['from_store_id']);
            $issue->where('to_store_id', @$request['to_store_id']);
            $issue->where('unit_id', @$request['unit_id']);
            
            if($issue->delete())
            {
                DB::commit();
                $response = [];
                return sendDataHelper('Issue list deleted.', $response, $code = 200);
            }else{
                return sendErrorHelper('Error', 'Somthing went wrong. Please try again.', 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function issueFilterList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make($request,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d',
                'issue_no'=>'sometimes',
                'from_store'=>'sometimes',
                'to_store'=>'sometimes'
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
                
                $response = IssueManagement::where('unit_id', $unit_id);
               
                if(@$from_date && @$to_date)
                {
                    $response->whereBetween('issue_date', [$from_date, $to_date]);
                }

                if(@$request['issue_no'])
                {
                    $response->where('issue_no', $request['issue_no']);
                }

                if(@$request['from_store'])
                {
                    $response->where('from_store', $request['from_store']);
                }
                if(@$request['to_store'])
                {
                    $response->where('to_store', $request['to_store']);
                }
                $response = $response->get();
                foreach($response as $key => $result) {
                    $items = explode(',', $result['item_ids']);
                    $result['item'] = Item::whereIn('id', $items)->get(['id','item_code','item_name','qty','purchase_uom','remarks']);
                }
                
                if ($response) {
                    return sendDataHelper('Issue list view.', $response, $code = 200);
                } else {
                    return sendError('Issue list not found.', [], $code = 404);
                }
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}