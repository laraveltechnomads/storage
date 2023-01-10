<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Inventory\ItemEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemEnquiryController extends Controller
{
    public function addItemEnquiry(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $validation = Validator::make((array)$data,[
                'enquiry_no'=>'required',
                'added_date'=>'required|date_format:Y-m-d',
                'item_ids'=>'required',
                'supplier_id'=>'required',
                'store_id'=>'required',
                'header'=>'required',
            ]);
            if($validation->fails()){
                return sendError($data->errors()->first(), [],422);
            }else{
                $response = ItemEnquiry::create($data);
                if ($response) {
                    DB::commit();
                    return sendDataHelper('Item Enquiry added successfully', $response, $code = 200);
                } else {
                    return sendError("Item Enquiry not add", [],422);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function itemList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $validation = Validator::make($data,[
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d',
                'supplier_id'=>'required',
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [],422);
            }else{
                $response = ItemEnquiry::whereBetween('added_date',[$data['from_date'], $data['to_date']])->orWhere('supplier_id',$data['supplier_id'])->get();
                foreach($response as $key => $result) {
                    $items = explode(',', $result['item_ids']);
                    $result['item'] = Item::whereIn('id', $items)->get(['id','item_code','item_name','qty','purchase_uom','remarks']);
                }
                
                if ($response) {
                    return sendDataHelper('Item Enquiry List', $response, $code = 200);
                } else {
                    return sendError("Item Enquiry list not found", [],204);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
