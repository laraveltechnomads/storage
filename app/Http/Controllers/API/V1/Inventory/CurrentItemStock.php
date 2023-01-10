<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Inventory\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CurrentItemStock extends Controller
{
    public function list(Request $request)
    {
        try {
            $clinic_id = null;
            $store_id = null;
            $item_group_id = null;
            $item_category_id = null;
            $item = null;
            $batch_code = null;
            $item_stock_with_zero = null;
            $stock_as_on_date = null; 
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $clinic_id = @$request['clinic_id']; 
                    $store_id = @$request['store_id']; 
                    $item_group_id = @$request['item_group_id']; 
                    $item_category_id = @$request['item_category_id']; 
                    $item = @$request['item']; 
                    $batch_code = @$request['batch_code']; 
                    $item_stock_with_zero = @$request['item_stock_with_zero']; 
                    $stock_as_on_date = @$request['stock_as_on_date']; 
                }
            }
        
            $query = Item::select('items.id as item_id','items.item_code','items.item_name',
                'items.min_stock as available_stock',
                'items.purchase_uom as stocking_uom',
                'items.MRP as total_mrp',
                'items.purchase_rate as total_cp',
                'items.base_unit_cost_price as base_cp',
                'batches.expiry_date',
                'batches.is_free',
                'batches.batch_code',
                'batches.expiry_date',
                'units.id as clinic_id',
                'units.clinic_name',
                'item_groups.id as item_group_id',
                'item_groups.description as item_group_description',
                'stores.id as store_id',
                'stores.description as store_description',
                'item_categories.id as item_categories_id',
                'item_categories.description as item_categories_description',
                'items.item_category_id')
            ->join('item_groups','item_groups.id','=','items.item_group_id')
            ->join('item_categories','item_categories.id','=','items.item_category_id')
            ->join('item_clinics','item_clinics.item_id','=','items.id')
            ->join('stores','item_clinics.store_id','=','stores.id')
            ->join('units','units.id','=','items.clinic_id')
            ->join('batches','batches.item_id','=','items.id');

            if (isset($clinic_id)) {
                $query->where('items.clinic_id',$clinic_id);
            }

            if (isset($store_id)) {
                $query->where('item_clinics.store_id',$store_id);
            }

            if (isset($item_group_id)) {
                $query->where('items.item_group_id',$item_group_id);
            }

            if (isset($item_category_id)) {
                $query->where('items.item_category_id',$item_category_id);
            }

            if (isset($item)) {
                $query->where('items.item_name', 'like', '%' . $item . '%');
            }  

            if (isset($batch_code)) {
                $query->where('batches.batch_code', 'like', '%' . $batch_code . '%');
            }  

            if (isset($item_stock_with_zero)) {
                $query->where('items.min_stock',$item_stock_with_zero);
            }  

            if (isset($stock_as_on_date)) {
                $query->whereDate('batches.purchase_rate', '<=' , $stock_as_on_date);
            }  
            $items = $query->get();
            $response = [];
            if((count($items) > 0)){
                foreach($items as $item){
                    $price = ($item->total_cp == 0) ? 1 : $item->total_cp;
                    $mrp = ($item->total_mrp * $item->base_cp) / $price;
                    $round = round($mrp,3);
                    $response["count ".count($items)][] = [
                        "id" => $item->item_id,
                        "clinic_id" => $item->clinic_id,
                        "clinic_name" => $item->clinic_name,
                        "item_code" => $item->item_code,
                        "item_name" => $item->item_name,
                        "item_group_id" => $item->item_group_id,
                        "item_group_description" => $item->item_group_description,
                        "item_categories_id" => $item->item_categories_id,
                        "item_categories_description" => $item->item_categories_description,
                        "is_free" => $item->is_free,
                        "store_id" => $item->store_id,
                        "store_name" => $item->store_description,
                        "batch_code" => $item->batch_code,
                        "available_stock" => $item->available_stock,
                        "stocking_uom" => $item->stocking_uom,
                        "expiry_date" => $item->expiry_date,
                        "total_mrp" => $item->total_mrp,
                        "total_cp" => $item->total_cp,
                        "base_cp" => $item->base_cp,
                        "base_mrp" => $round,
    
                    ];
                }
            }
            if($response == []){
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{
                return sendDataHelper('Current Item Stock list.', $response, $code = 200);
            }	
        } catch(\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
