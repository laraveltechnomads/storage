<?php

namespace App\Http\Controllers\API\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Inventory\Batch;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Inventory\ItemClinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OpeningBalanceController extends Controller
{
    public function list(Request $request){
        try {
            $from_date = null;
            $to_date = null;
            $clinic_id = null;
            $store_id = null;
            $item_group_id = null;
            $item_name = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $from_date = @$request['from_date']; 
                    $to_date = @$request['to_date']; 
                    $clinic_id = @$request['clinic_id'];  
                    $store_id = @$request['store_id']; 
                    $item_group_id = @$request['item_group_id']; 
                    $item_name = @$request['item_name']; 
                }
            }
        
            $response = [];
            $query = Item::select('items.id as item_id','items.item_code','items.item_name',
                'items.purchase_uom as stocking_uom',
                'items.MRP as total_mrp',
                'items.barcode',
                'items.item_category_id',
                'items.discount_on_sale',
                'items.vat_per',
                'items.purchase_rate as total_cp',
                'items.base_unit_cost_price as base_cp',
                'batches.qty',
                'batches.batch_code',
                'batches.expiry_date',
                'batches.vat_amount',
                'units.id as clinic_id',
                'units.clinic_name',
                'item_groups.id as item_group_id',
                'item_groups.description as item_group_description',
                'stores.id as store_id',
                'stores.description as store_description')
            ->join('item_groups','item_groups.id','=','items.item_group_id')
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

            if (isset($item_name)) {
                $query->where('items.item_name', 'like', '%' . $item_name . '%');
            }  

            if(isset($from_date) && ($to_date))
            {
                $query->whereBetween('batches.expiry_date',[$from_date, $to_date]);
                $items = $query->get();
                if((count($items) > 0)){
                    foreach($items as $item){
                        $price = ($item->total_cp == 0) ? 1 : $item->total_cp;
                        $mrp = ($item->total_mrp * $item->base_cp) / $price;
                        $round = round($mrp,3);
                        $response[] = [
                            "id" => $item->item_id,
                            "clinic_id" => $item->clinic_id,
                            "clinic_name" => $item->clinic_name,
                            "store_id" => $item->store_id,
                            "store_name" => $item->store_description,
                            "item_code" => $item->item_code,
                            "item_name" => $item->item_name,
                            "batch_code" => $item->batch_code,
                            "expiry_date" => $item->expiry_date,
                            "qty" => $item->qty,
                            "uom" => $item->stocking_uom,
                            "base_cp" => $item->base_cp,
                            "base_mrp" => $round,
                            "total_cp" => $item->total_cp,
                            "total_mrp" => $item->total_mrp,
                            "barcode" => $item->barcode,
                            "discount_on_sale" => $item->discount_on_sale,
                            "vat" => $item->vat_per,
                            "vat_amount" => $item->vat_amount,
                            "total_net_cp" => $item->total_cp,
                        ];
                    }
                }
            }
            
            if($response == []){
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{
                return sendDataHelper('Opening Balance list.', $response, $code = 200);
            }	
        } catch(\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }  
    }
    public function add(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'clinic_id' => 'required',
            'store_id' => 'required',
            // 'item_list' => 'required',
        ]); 
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $list = [];
        $list[] = [
            "item_name" => '1 ML SYRINGS',
            "batch_code" => 14,
            "expiry_date" => '2022-08-29',
            "qty" => 1,
            "purchase_uom" => 'NUMBER',
            "conversion_factor" => 1.000,
            "qty" => 10,
            "base_unit_cost_price" => 3.75,
            "MRP" => 14.50,
            "purchase_rate" => 37.50,
            "discount_on_sale" => 1,
            "vat_per" => 1,
        ];
        $list[] = [
            "item_name" => 'ADOVA CAPS',
            "batch_code" => 15,
            "expiry_date" => '2022-08-29',
            "qty" => 1,
            "purchase_uom" => 'NUMBER',
            "conversion_factor" => 1.000,
            "qty" => 1,
            "base_unit_cost_price" => 1,
            "MRP" => 10,
            "purchase_rate" => 1,
            "discount_on_sale" => 1,
            "vat_per" => 1,
        ];
        $list[] = [
            "item_name" => 'ALCOHOL SWAB BD',
            "batch_code" => 16,
            "expiry_date" => '2022-08-29',
            "qty" => 2,
            "purchase_uom" => 'NUMBER',
            "conversion_factor" => 1.000,
            "qty" => 2,
            "base_unit_cost_price" => 1.85,
            "MRP" => 2.50,
            "purchase_rate" => 3.70,
            "discount_on_sale" => 1,
            "vat_per" => 1,
        ];
        $list[] = [
            "item_name" => 'ALBUTAS 20%',
            "batch_code" => 17,
            "expiry_date" => '2022-08-29',
            "qty" => 3,
            "purchase_uom" => 'NUMBER',
            "conversion_factor" => 1.000,
            "qty" => 3,
            "base_unit_cost_price" => 3850.00,
            "MRP" => 4650.00,
            "purchase_rate" => 11550.00,
            "discount_on_sale" => 1,
            "vat_per" => 1,
        ];
        $list[] = [
            "item_name" => 'ALERID 10 MG TAB',
            "batch_code" => 18,
            "expiry_date" => '2022-08-29',
            "qty" => 4,
            "purchase_uom" => 'NUMBER',
            "conversion_factor" => 1.000,
            "base_unit_cost_price" => 1.24,
            "MRP" => 1.73,
            "purchase_rate" => 4.96,
            "discount_on_sale" => 1,
            "vat_per" => 1,
        ];
        $add_items = ($request['item_list'] = $list);
        foreach($add_items as $add_item){
            $item = Item::create([
                'item_name' => $add_item['item_name'],
                'clinic_id' => $request['clinic_id'],
                'qty' => $add_item['qty'],
                'purchase_uom' => $add_item['purchase_uom'],
                'conversion_factor' => $add_item['conversion_factor'],
                'base_unit_cost_price' => $add_item['base_unit_cost_price'],
                'MRP' =>$add_item['MRP'],
                'purchase_rate' => $add_item['purchase_rate'],
                'discount_on_sale' => $add_item['discount_on_sale'],
                'vat_per' => $add_item['vat_per'],
            ]);
            $batch = Batch::create([
                'item_id' => $item->id,
                'unit_id' => $request['clinic_id'],
                'batch_code' => $add_item['batch_code'],
                'expiry_date' => $add_item['expiry_date'],
                'qty' => $add_item['qty'],
                'conversion_factor' => $add_item['conversion_factor'],
                'mrp' =>$add_item['MRP'],
                'purchase_rate' => $add_item['purchase_rate'],
                'discount_on_sale' => $add_item['discount_on_sale'],
                'vat_percentage' => $add_item['vat_per'],
                'remarks' => @$request['remarks'],
            ]);
            ItemClinic::create([
                'store_id' => $request['store_id'],
                'unit_id' => $request['clinic_id'],
                'item_id' => $item->id,
            ]);
        }
        return sendDataHelper('Opening Balance Add Successfully!.', [], $code = 200);
    }
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
