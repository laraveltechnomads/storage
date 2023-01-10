<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Inventory\StoreItem;
use App\Models\API\V1\StoreItemsList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoreIndentController extends Controller
{
    public function list(Request $request){
        
    }
    // public function add(Request $request){
    //     if(respValid($request)) { return respValid($request); } 

    //     $request = decryptData($request['response']);
    //     $validator = Validator::make((array)$request,[
    //         'store_date' => 'required|date|date_format:Y-m-d',
    //         'exp_delivery_date' => 'required|date|date_format:Y-m-d',
    //         'from_store_id' => 'required',
    //         'to_store_id' => 'required',
    //         'items' => 'required',
    //     ]); 
    //     if($validator->fails()){
    //         return sendErrorHelper($validator->errors()->first(), [], 422);
    //     }
    //     $store = StoreItem::create([
    //        'store_no' => 'MVF-'.date("Y").strtotime(now()),
    //        'store_date' => $request['store_date'],
    //        'exp_delivery_date' => $request['exp_delivery_date'],
    //        'from_store_id' => $request['from_store_id'],
    //        'to_store_id' => $request['to_store_id'],
    //        'patient_id' => $request['patient_id'],
    //        'unit_id' => $request['unit_id'],
    //        'freezed' => @$request['freezed'],
    //        'remark' => @$request['remark'],
    //     ]);
    //     $items = $request['items'] = [
    //         'item_name' => 'ADOVA CAPS',
    //         'indent_qty' => 1,
    //         'purchase_uom' => 1,
    //         'indent_qty' => 1,
    //         'indent_qty' => 1,
    //     ];
    //     foreach($items as $item){
    //         $storeitems = StoreItemsList::create([
    //         'unit_id' => $store->id,
    //         'item_id' => $item->item_id,
    //         'unit_id' => $item->id,
    //         'unit_id' => $item->id,
    //         ]);
    //     }
        
    // }
    public function searchItem(Request $request){
        try {
            $item_name = null;
            $brand_name = null;
            $item_code = null;
            $item_category_id = null;
            $store_id = null;
            $item_group_id = null;
            $molecule_id = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $item_name = @$request['item_name'];  
                   $brand_name = @$request['brand_name']; 
                   $item_code = @$request['item_code'];  
                   $item_category_id = @$request['item_category_id'];  
                   $store_id = @$request['store_id'];  
                   $item_group_id = @$request['item_group_id'];  
                   $molecule_id = @$request['molecule_id'];  
                }
            }
            $description = Item::join('item_categories','item_categories.id','=','items.item_category_id')
            ->join('item_groups','item_groups.id','=','items.item_group_id')
            ->join('item_clinics','item_clinics.item_id','=','items.id')
            ->join('stores','stores.id','=','item_clinics.store_id')
            ->join('molecules','molecules.id','=','items.molecule_id');
            if(isset($item_name))
            {
                $description->where('items.item_name', 'like', "%{$item_name}%");
            }
            if(isset($brand_name))
            {
                $description->where('items.brand_name', 'like', "%{$brand_name}%");
            }
            if(isset($item_code))
            {
                $description->where('items.item_code', 'like', "%{$item_code}%");
            }
            if(isset($item_category_id))
            {
                $description->where('items.item_category_id', $item_category_id);
            }
            if(isset($store_id))
            {
                $description->where('item_clinics.store_id', $store_id);
            }
            if(isset($item_group_id))
            {
                $description->where('items.item_group_id' , $item_group_id);
            }
            if(isset($molecule_id))
            {
                $description->where('items.molecule_id' , $molecule_id);
            }
            $response = $description->select(
                'items.id',
                'items.item_code',
                'items.item_name',
                'items.brand_name',
                'items.min_stock as available_stock',
                'items.purchase_uom as stock_uom',
                'items.qty',
                DB::raw('purchase_tax as 0.00'),
                DB::raw('sale_tax as 0.00'),
                DB::raw('suspend'),
                'items.qty',
                // 'item_categories.id as item_category_id',
                // 'item_categories.description as item_category_description',
                // 'stores.id as store_id',
                // 'stores.description as store_description',
                // 'item_groups.id as item_groups_id',
                // 'item_groups.description as item_groups_description',
                // 'molecules.id as molecules_id',
                // 'molecules.description as molecules_description'
            )->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Search Item list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
