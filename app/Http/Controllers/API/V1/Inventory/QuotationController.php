<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Inventory\Quotation;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Master\UserAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    public function quotationList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $data = decryptData($request['response']); /* Dectrypt  **/

            $validation = Validator::make($data,[
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d',
                'supplier_id'=>'required',
                'store_id'=>'required',
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [],422);
            }else{
                $response = Quotation::whereBetween('date',[$data['from_date'], $data['to_date']])
                ->orWhere('supplier_id',$data['supplier_id'])
                ->orWhere('store_id',$data['store_id'])->get();
                foreach($response as $key => $result) {
                    $result['image'] = UserAttachment::where('parent_table_id', $result->id)->where('table_type', 'quotations')->with('attachment')->get(['id','attachment_id']);
                    $result['image'][$key]['base_url'] = URL::to('/uploads/quotation/');
                    $items = explode(',', $result['item_ids']);
                    $result['item'] = Item::whereIn('id', $items)->get(['id','item_code','item_name','qty','purchase_uom','remarks']);
                }
                // return $result;
                
                if ($response) {
                    return sendDataHelper('Quotation List', $response, $code = 200);
                } else {
                    return sendError("Quotation list not found", [],204);
                }
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
