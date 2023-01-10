<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Clinic\Store;
use App\Models\API\V1\Inventory\Dispensing;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Inventory\ItemCategory;
use App\Models\API\V1\Inventory\ItemGroup;
use App\Models\API\V1\Inventory\Molecule;
use App\Models\API\V1\Inventory\StorageType;
use App\Models\API\V1\Master\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryConfigController extends Controller
{
    /** Item Category */
    public function addItemCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = ItemCategory::where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be save because CODE is already exist", [], 422);
            }

            $data['status'] = 1;
            $response = ItemCategory::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Item Category added successfully', $response, $code = 200);
            } else {
                return sendError("Item Category not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchListItemCategory(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            if(isset($data['search_description'])) {
                $response = ItemCategory::where('description', 'like', '%' . $data['search_description'] . '%')->paginate(10);
            } else {
                $response = ItemCategory::paginate(10);
            }
            
            if ($response) {
                return sendDataHelper('Item Category List', $response, $code = 200);
            } else {
                return sendError("Item Category list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStatusItemCategory(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if (ItemCategory::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully',[], $code = 200);
            } else {
                return sendError("Status not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateItemCategory(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = ItemCategory::where('id',$id)->where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be update because CODE is already exist", [], 422);
            }

            if (ItemCategory::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Item category updated successfully',[], $code = 200);
            } else {
                return sendError("Item Category not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Item Group */
    public function addItemGroup(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                'ledgers_id' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = ItemGroup::where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be save because CODE is already exist", [], 422);
            }

            $data['status'] = 1;
            $response = ItemGroup::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Item Group added successfully', [], $code = 200);
            } else {
                return sendError("Item Group not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchListItemGroup(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            if(isset($data['search_description'])) {
                $response = ItemGroup::where('description', 'like', '%' . $data['search_description'] . '%')->paginate(10);
            } else {
                $response = ItemGroup::paginate(10);
            }
            
            if ($response) {
                return sendDataHelper('Item Group List', $response, $code = 200);
            } else {
                return sendError("Item Group list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStatusItemGroup(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }
            
            if (ItemGroup::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully', [], $code = 200);
            } else {
                return sendError("Status not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateItemGroup(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                'ledgers_id' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = ItemGroup::where('id',$id)->where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be update because CODE is already exist", [], 422);
            }

            if (ItemGroup::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Item group updated successfully',[], $code = 200);
            } else {
                return sendError("Item group not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Storage Type */
    public function addStorageType(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = StorageType::where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be save because CODE is already exist", [], 422);
            }

            $data['status'] = 1;
            $response = StorageType::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Storage Type added successfully', $response, $code = 200);
            } else {
                return sendError("Storage Type not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchListStorageType(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            if(isset($data['search_description'])) {
                $response = StorageType::where('description', 'like', '%' . $data['search_description'] . '%')->paginate(10);
            } else {
                $response = StorageType::paginate(10);
            }

            if ($response) {
                return sendDataHelper('Storage Type List', $response, $code = 200);
            } else {
                return sendError("Storage Type list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStatusStorageType(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if (StorageType::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully',[], $code = 200);
            } else {
                return sendError("Status not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStorageType(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = StorageType::where('id',$id)->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be update because CODE is already exist", [], 422);
            }

            if (StorageType::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Storage Type updated successfully',[], $code = 200);
            } else {
                return sendError("Storage Type not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Molecule */
    public function addMolecule(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = Molecule::where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be save because CODE is already exist", [], 422);
            }

            $data['status'] = 1;
            $response = Molecule::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Molecule added successfully', $response, $code = 200);
            } else {
                return sendError("Molecule not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchListMolecule(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            if(isset($data['search_description'])) {
                $response = Molecule::where('description', 'like', '%' . $data['search_description'] . '%')->paginate(10);
            } else {
                $response = Molecule::paginate(10);
            }
            
            if ($response) {
                return sendDataHelper('Molecule List', $response, $code = 200);
            } else {
                return sendError("Molecule list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStatusMolecule(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if (Molecule::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully',[], $code = 200);
            } else {
                return sendError("Status not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateMolecule(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = Molecule::where('id',$id)->where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be update because CODE is already exist", [], 422);
            }

            if (Molecule::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Molecule updated successfully',[], $code = 200);
            } else {
                return sendError("Molecule not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Molecule */
    public function addDispensingType(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = Dispensing::where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be save because CODE is already exist", [], 422);
            }

            $data['status'] = 1;
            $response = Dispensing::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Dispensing Type added successfully', $response, $code = 200);
            } else {
                return sendError("Dispensing Type not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchListDispensingType(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            if(isset($data['search_description'])) {
                $response = Dispensing::where('description', 'like', '%' . $data['search_description'] . '%')->paginate(10);
            } else {
                $response = Dispensing::paginate(10);
            }
            
            if ($response) {
                return sendDataHelper('Dispensing Type List', $response, $code = 200);
            } else {
                return sendError("Dispensing Type list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateStatusDispensingType(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if (Dispensing::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully',[], $code = 200);
            } else {
                return sendError("Status not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateDispensingType(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'unit_id' => 'required',
                'code' => 'required',
                'description' => 'required',
                //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = Dispensing::where('id',$id)->where('unit_id', $data['unit_id'])->where('code', $data['code'])->first();
            if($checkRecord) {
                return sendError("Record can't be update because CODE is already exist", [], 422);
            }

            if (Dispensing::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Dispensing Type updated successfully',[], $code = 200);
            } else {
                return sendError("Dispensing Type not updated", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /**
     * 1. Item Category =  item_categories
     * 2. Item Group =  item_groups
     * 3. Storage Type =  storage_types
     * 4. Molecules =  molecules
     * 5. Dispensings =  dispensings
     * 6. Pregnancy Classes =  pregnancy_classes
     * 7. Item companies =  item_companies
     * 8. Therapeutic =  therapeutic
     * 9. Unit of measurment =  unit_of_measurements
     * 10. Terms and conditions =  terms_and_conditions
     */
    public function inventoryCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            if($dbName == 'supplier_categories') { 
                $validation = Validator::make((array)$data,[
                    's_category_code' => "required|unique:$dbName,s_category_code",
                    'description' => "required|unique:$dbName,description",
                    //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
                ]);    
            }elseif($dbName == 'tax_masters'){
                $validation = Validator::make((array)$data,[
                    'tax_code' => "required|unique:$dbName,tax_code",
                    'description' => "required|unique:$dbName,description",
                ]); 
            }elseif($dbName == 'item_movement_masters'){
                $validation = Validator::make((array)$data,[
                    'item_movement_code' => "required|unique:$dbName,item_movement_code",
                    'description' => "required|unique:$dbName,description",
                ]); 
            }elseif($dbName == 'currencies'){
                $validation = Validator::make((array)$data,[
                    'currency_code' => "required|unique:$dbName,currency_code",
                    'description' => "required|unique:$dbName,description",
                ]); 
            }elseif($dbName == 'rack_masters'){
                $validation = Validator::make((array)$data,[
                    'rack_code' => "required|unique:$dbName,rack_code",
                    'description' => "required|unique:$dbName,description",
                ]); 
            }elseif($dbName == 'shelf_masters'){
                $validation = Validator::make((array)$data,[
                    'shelf_code' => "required|unique:$dbName,shelf_code",
                    'description' => "required|unique:$dbName,description",
                ]); 
            }else {
                $validation = Validator::make((array)$data,[
                    // 'unit_id' => 'required',
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    
                ]);
            }
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
          
            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $response = DB::table($dbName)->insert($data);
            if ($response) {
                DB::commit();
                return sendDataHelper("$message added successfully", $response, $code = 200);
            } else {
                return sendError("$message not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function inventoryCommonSearchListConfig(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  
            $data = decryptData($request['response']); 

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            if(isset($data['search_description'])) {
                $response = DB::table($dbName)->where('description', 'like', '%' . $data['search_description'] . '%')->get();
            } else {
                $response = DB::table($dbName)->get();
            }
            if ($response) {
                return sendDataHelper("$message List", $response, $code = 200);
            } else {
                return sendError("$message list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function inventoryCommonUpdateStatusConfig(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); } 
            $data = decryptData($request['response']); 
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $dbName = request()->segment(6);
            $result = DB::table($dbName)->where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper('Status updated successfully',[], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function inventoryCommonUpdateItemConfig(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); } 
            $data = decryptData($request['response']); 
            $dbName = request()->segment(6);
            if($dbName == 'supplier_categories') {
                $validation = Validator::make((array)$data,[
                    's_category_code' => "required|unique:$dbName,s_category_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]);    
            }elseif($dbName == 'tax_masters') { 
                $validation = Validator::make((array)$data,[
                    'tax_code' => "required|unique:$dbName,tax_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]);    
            } elseif($dbName == 'item_movement_masters'){
                $validation = Validator::make((array)$data,[
                    'item_movement_code' => "required|unique:$dbName,item_movement_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]); 
            }elseif($dbName == 'currencies'){
                $validation = Validator::make((array)$data,[
                    'currency_code' => "required|unique:$dbName,currency_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]); 
            }elseif($dbName == 'rack_masters'){
                $validation = Validator::make((array)$data,[
                    'rack_code' => "required|unique:$dbName,rack_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]); 
            }elseif($dbName == 'shelf_masters'){
                $validation = Validator::make((array)$data,[
                    'shelf_code' => "required|unique:$dbName,shelf_code," . $id,
                    'description' => "required|unique:$dbName,description,". $id,
                ]); 
            } else {
                $validation = Validator::make((array)$data,[
                    // 'unit_id' => 'required',
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]);
            }
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['updated_at'] = Carbon::now();
            $result = DB::table($dbName)->where('id', $id)->update($data);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper("$message updated successfully",[], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function inventorySearchListItem(Request $request){
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
            $description = Item::query();
            // join('molecules','molecules.id','=','items.molecule_id');
            if(isset($search))
            {
                $description->where('brand_name', 'like', "%{$search}%");
            }
            $response = $description->select('id',
            'item_code',
            'brand_name as item_name',
            'item_group',
            'item_group',
            'molecule_id',
            'molecule_name',
            'item_category',
            'item_category_id',
            'mfg_by',
            'purchase_uom',
            'discount_on_sale')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Item Detail list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventorySearchSuppliersConfig(Request $request){
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
            $description = Supplier::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->whereStatus(1)->get(['id','description']);
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Supplier list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventoryAddUpdateItem(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'item_code' => 'required|unique:items',
                    'item_name' => 'required|unique:items',
                    'molecule_name' => 'required',
                    'item_group' => 'required',
                    'item_category' => 'required',
                    'preg_class' => 'required',
                    'ther_class' => 'required',
                    'expiry_alert' => 'required',
                    'discount_on_sale' => 'required',
                    'route' => 'required',
                    'mfg_by' => 'required',
                    'purchase_uom' => 'required',
                    'selling_um' => 'required',
                    'conversion_factor' => 'required',
                    'MRP' => 'required',
                    'base_unit_cost_price' => 'required',
                    'hsn_codes_id' => 'required',
                    'staff_discount_on_sale' => 'required',
                    'regi_patient_discount_on_sale' => 'required',
                    'walk_in_patient_discount_on_sale' => 'required',
                    'cgst' => 'required',
                    'sgst' => 'required',
                    'igst' => 'required',
                    'storage_type' => 'required',
                    'batches_required' => 'required',
                    'is_ABC' => 'required',
                    'is_FNS' => 'required',
                    'is_VED' => 'required',
                    'clinic_id' => 'required',
                    'rank' => 'required',
                    'shelf' => 'required',
                    'container' => 'required',
                    'list_of_supplier' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'item_code' => 'sometimes|required|unique:items,item_code,'.@$request['id'],
                    'item_name' => 'sometimes|required|unique:items,item_name,'.@$request['id'],
                    'molecule_name' => 'sometimes|required',
                    'item_group' => 'sometimes|required',
                    'item_category' => 'sometimes|required',
                    'preg_class' => 'sometimes|required',
                    'ther_class' => 'sometimes|required',
                    'expiry_alert' => 'sometimes|required',
                    'discount_on_sale' => 'sometimes|required',
                    'route' => 'sometimes|required',
                    'mfg_by' => 'sometimes|required',
                    'purchase_uom' => 'sometimes|required',
                    'selling_um' => 'sometimes|required',
                    'conversion_factor' => 'sometimes|required',
                    'MRP' => 'sometimes|required',
                    'base_unit_cost_price' => 'sometimes|required',
                    'hsn_codes_id' => 'sometimes|required',
                    'staff_discount_on_sale' => 'sometimes|required',
                    'regi_patient_discount_on_sale' => 'sometimes|required',
                    'walk_in_patient_discount_on_sale' => 'sometimes|required',
                    'cgst' => 'sometimes|required',
                    'sgst' => 'sometimes|required',
                    'igst' => 'sometimes|required',
                    'storage_type' => 'sometimes|required',
                    'batches_required' => 'sometimes|required',
                    'is_ABC' => 'sometimes|required',
                    'is_FNS' => 'sometimes|required',
                    'is_VED' => 'sometimes|required',
                    'clinic_id' => 'sometimes|required',
                    'rank' => 'sometimes|required',
                    'shelf' => 'sometimes|required',
                    'container' => 'sometimes|required',
                    'list_of_supplier' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }
            if(@$request['code']){
                $input['item_code'] = $request['code'];
            }
            $input['status'] = 1;
            if(@$request['item_name']){
                $input['item_name'] = $request['item_name'];
            }
            if(@$request['molecule_name']){
                $input['molecule_name'] = $request['molecule_name'];
            }
            if(@$request['item_group']){
                $input['item_group'] = $request['item_group'];
            }
            if(@$request['item_category']){
                $input['item_category'] = $request['item_category'];
            }
            if(@$request['preg_class']){
                $input['preg_class'] = $request['preg_class'];
            }
            if(@$request['ther_class']){
                $input['ther_class'] = $request['ther_class'];
            }
            if(@$request['expiry_alert']){
                $input['expiry_alert'] = $request['expiry_alert'];
            }
            if(@$request['discount_on_sale']){
                $input['discount_on_sale'] = $request['discount_on_sale'];
            }
            if(@$request['route']){
                $input['route'] = $request['route'];
            }
            if(@$request['mfg_by']){
                $input['mfg_by'] = $request['mfg_by'];
            }
            if(@$request['purchase_uom']){
                $input['purchase_uom'] = $request['purchase_uom'];
            }
            if(@$request['selling_um']){
                $input['selling_um'] = $request['selling_um'];
            }
            if(@$request['conversion_factor']){
                $input['conversion_factor'] = $request['conversion_factor'];
            }
            if(@$request['MRP']){
                $input['MRP'] = $request['MRP'];
            }
            if(@$request['base_unit_cost_price']){
                $input['base_unit_cost_price'] = $request['base_unit_cost_price'];
            }
            if(@$request['hsn_codes_id']){
                $input['hsn_codes_id'] = $request['hsn_codes_id'];
            }
            if(@$request['staff_discount_on_sale']){
                $input['staff_discount_on_sale'] = $request['staff_discount_on_sale'];
            }
            if(@$request['regi_patient_discount_on_sale']){
                $input['regi_patient_discount_on_sale'] = $request['regi_patient_discount_on_sale'];
            }
            if(@$request['walk_in_patient_discount_on_sale']){
                $input['walk_in_patient_discount_on_sale'] = $request['walk_in_patient_discount_on_sale'];
            }
            if(@$request['cgst']){
                $input['cgst'] = $request['cgst'];
            }
            if(@$request['sgst']){
                $input['sgst'] = $request['sgst'];
            }
            if(@$request['igst']){
                $input['igst'] = $request['igst'];
            }
            if(@$request['storage_type']){
                $input['storage_type'] = $request['storage_type'];
            }
            if(@$request['batches_required']){
                $input['batches_required'] = $request['batches_required'];
            }
            if(@$request['is_ABC']){
                $input['is_ABC'] = $request['is_ABC'];
            }
            if(@$request['is_FNS']){
                $input['is_FNS'] = $request['is_FNS'];
            }
            if(@$request['is_VED']){
                $input['is_VED'] = $request['is_VED'];
            }
            if(@$request['clinic_id']){
                $input['clinic_id'] = $request['clinic_id'];
            }
            if(@$request['rank']){
                $input['rank'] = $request['rank'];
            }
            if(@$request['shelf']){
                $input['shelf'] = $request['shelf'];
            }
            if(@$request['container']){
                $input['container'] = $request['container'];
            }
            if(@$request['list_of_supplier']){
                $input['list_of_supplier'] = implode(",",(array)$request['list_of_supplier']);
            }
            if(isset($request['status'])){
                $input['status'] = $request['status'];
            }
            if(@$request['type'] == 1){
                $item = Item::create($input);
                DB::commit();
                $data = [
                    'id' => $item->id,
                    'item_code' => $item->item_code,
                    'item_name' => $item->item_name,
                    'status' => 1
                ];
                return sendDataHelper('Item add successfully',$data, $code = 200);
            }else{
                $find_item = Item::find($request['id']);
                if($find_item){
                    $find_item->update($input);
                    DB::commit();
                    $data = [
                        'id' => $find_item->id,
                        'item_code' => $find_item->item_code,
                        'item_name' => $find_item->item_name,
                        'status' => $find_item->status
                    ];
                    return sendDataHelper('Item modify successfully',$data, $code = 200);
                }else{
                    return sendError('please provide valid id.', [], 400);
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventorySupplierSearchListConfig(Request $request){
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
            $description = Supplier::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select(
                'id',
                'supplier_code as code',
                'description',
                'status',
                'country_code',
                'state_code',
                'city_code',
                'area',
                'pin_code',
                'cu_id',
                'address_line_1',
                'address_line_2',
                'address_line_3',
                'depreciation',
                'rating_system',
                'po_auto_close',
                'contact_person1_name',
                'contact_person1_mobile_no',
                'contact_person1_email_id',
                'contact_person2_name',
                'contact_person2_mobile_no',
                'contact_person2_email_id',
                'mast_number',
                'drug_licence_number',
                'cst_number',
                'service_tax_number',
                'vat_number','pan_number','gstin_number')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Supplier list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventorySupplierAddConfig(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:suppliers,supplier_code',
                    'description' => 'required|unique:suppliers',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:suppliers,supplier_code,'.@$request['id'],
                    'description' => 'sometimes|required|unique:suppliers,description,'.@$request['id'],
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    if(@$request['code']){
                        $store['supplier_code'] = $request['code'];
                    }
                    $store['status'] = 1;
                    if(@$request['description']){
                        $store['description'] = $request['description'];
                    }
                    if(@$request['country_code']){
                        $store['country_code'] = $request['country_code'];
                    }
                    if(@$request['state_code']){
                        $store['state_code'] = $request['state_code'];
                    }
                    if(@$request['city_code']){
                        $store['city_code'] = $request['city_code'];
                    }
                    if(@$request['area']){
                        $store['area'] = $request['area'];
                    }
                    if(@$request['pin_code']){
                        $store['pin_code'] = $request['pin_code'];
                    }
                    if(@$request['cu_id']){
                        $store['cu_id'] = $request['cu_id'];
                    }
                    if(@$request['address_line_1']){
                        $store['address_line_1'] = $request['address_line_1'];
                    }
                    if(@$request['address_line_2']){
                        $store['address_line_2'] = $request['address_line_2'];
                    }
                    if(@$request['address_line_3']){
                        $store['address_line_3'] = $request['address_line_3'];
                    }
                    if(@$request['depreciation']){
                        $store['depreciation'] = $request['depreciation'];
                    }
                    if(@$request['rating_system']){
                        $store['rating_system'] = $request['rating_system'];
                    }
                    if(@$request['po_auto_close']){
                        $store['po_auto_close'] = $request['po_auto_close'];
                    }
                    if(@$request['contact_person1_name']){
                        $store['contact_person1_name'] = $request['contact_person1_name'];
                    }
                    if(@$request['contact_person1_mobile_no']){
                        $store['contact_person1_mobile_no'] = $request['contact_person1_mobile_no'];
                    }
                    if(@$request['contact_person1_email_id']){
                        $store['contact_person1_email_id'] = $request['contact_person1_email_id'];
                    }
                    if(@$request['contact_person2_name']){
                        $store['contact_person2_name'] = $request['contact_person2_name'];
                    }
                    if(@$request['contact_person2_mobile_no']){
                        $store['contact_person2_mobile_no'] = $request['contact_person2_mobile_no'];
                    }
                    if(@$request['contact_person2_email_id']){
                        $store['contact_person2_email_id'] = $request['contact_person2_email_id'];
                    }
                    if(@$request['mast_number']){
                        $store['mast_number'] = $request['mast_number'];
                    }
                    if(@$request['drug_licence_number']){
                        $store['drug_licence_number'] = $request['drug_licence_number'];
                    }
                    if(@$request['cst_number']){
                        $store['cst_number'] = $request['cst_number'];
                    }
                    if(@$request['service_tax_number']){
                        $store['service_tax_number'] = $request['service_tax_number'];
                    }
                    if(@$request['vat_number']){
                        $store['vat_number'] = $request['vat_number'];
                    }
                    if(@$request['pan_number']){
                        $store['pan_number'] = $request['pan_number'];
                    }
                    if(@$request['gstin_number']){
                        $store['gstin_number'] = $request['gstin_number'];
                    }
                    $supplier = Supplier::create($store);
                    DB::commit();
                    $data = [
                        'id' => $supplier->id,
                        'code' => $supplier->code,
                        'description' => $supplier->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Supplier add successfully',$data, $code = 200);
                }else{
                    $find_supplier = Supplier::find($request['id']);
                    if($find_supplier){
                        if(isset($request['status'])){
                            $add['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $add['supplier_code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $add['description'] = $request['description'];
                        }
                        if(@$request['country_code']){
                            $add['country_code'] = $request['country_code'];
                        }
                        if(@$request['state_code']){
                            $add['state_code'] = $request['state_code'];
                        }
                        if(@$request['city_code']){
                            $add['city_code'] = $request['city_code'];
                        }
                        if(@$request['area']){
                            $add['area'] = $request['area'];
                        }
                        if(@$request['pin_code']){
                            $add['pin_code'] = $request['pin_code'];
                        }
                        if(@$request['cu_id']){
                            $add['cu_id'] = $request['cu_id'];
                        }
                        if(@$request['address_line_1']){
                            $add['address_line_1'] = $request['address_line_1'];
                        }
                        if(@$request['address_line_2']){
                            $add['address_line_2'] = $request['address_line_2'];
                        }
                        if(@$request['address_line_3']){
                            $add['address_line_3'] = $request['address_line_3'];
                        }
                        if(@$request['depreciation']){
                            $add['depreciation'] = $request['depreciation'];
                        }
                        if(@$request['rating_system']){
                            $add['rating_system'] = $request['rating_system'];
                        }
                        if(@$request['po_auto_close']){
                            $add['po_auto_close'] = $request['po_auto_close'];
                        }
                        if(@$request['contact_person1_name']){
                            $add['contact_person1_name'] = $request['contact_person1_name'];
                        }
                        if(@$request['contact_person1_mobile_no']){
                            $add['contact_person1_mobile_no'] = $request['contact_person1_mobile_no'];
                        }
                        if(@$request['contact_person1_email_id']){
                            $add['contact_person1_email_id'] = $request['contact_person1_email_id'];
                        }
                        if(@$request['contact_person2_name']){
                            $add['contact_person2_name'] = $request['contact_person2_name'];
                        }
                        if(@$request['contact_person2_mobile_no']){
                            $add['contact_person2_mobile_no'] = $request['contact_person2_mobile_no'];
                        }
                        if(@$request['contact_person2_email_id']){
                            $add['contact_person2_email_id'] = $request['contact_person2_email_id'];
                        }
                        if(@$request['mast_number']){
                            $add['mast_number'] = $request['mast_number'];
                        }
                        if(@$request['drug_licence_number']){
                            $add['drug_licence_number'] = $request['drug_licence_number'];
                        }
                        if(@$request['cst_number']){
                            $add['cst_number'] = $request['cst_number'];
                        }
                        if(@$request['service_tax_number']){
                            $add['service_tax_number'] = $request['service_tax_number'];
                        }
                        if(@$request['vat_number']){
                            $add['vat_number'] = $request['vat_number'];
                        }
                        if(@$request['pan_number']){
                            $add['pan_number'] = $request['pan_number'];
                        }
                        if(@$request['gstin_number']){
                            $add['gstin_number'] = $request['gstin_number'];
                        }
                        $find_supplier->update($add);
                        DB::commit();
                        $data = [
                            'id' => $find_supplier->id,
                            'code' => $find_supplier->code,
                            'description' => $find_supplier->description,
                            'status' => $find_supplier->status
                        ];
                        return sendDataHelper('Supplier modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventoryStoreSearchListConfig(Request $request){
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
            $description = Store::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select(
                'id',
                'code',
                'description',
                'is_central_store',
                'is_quarantine_store',
                'status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Store list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function inventoryStoreAddConfig(Request $request){
        try{
            DB::beginTransaction();
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']);
            if(@$request['type'] == 1){
                $validation = Validator::make((array)$request,[
                    'code' => 'required|unique:stores',
                    'description' => 'required|unique:stores',
                    'cost_center_code' => 'required',
                    'is_central_store' => 'required',
                    'is_quarantine_store' => 'required',
                ]);
            }else{
                $validation = Validator::make((array)$request,[
                    'id' => 'required',
                    'code' => 'sometimes|required|unique:stores,code,'.@$request['id'],
                    'description' => 'sometimes|required|unique:stores,description,'.@$request['id'],
                    'cost_center_code' => 'sometimes|required',
                    'is_central_store' => 'sometimes|required',
                    'is_quarantine_store' => 'sometimes|required',
                    'status' => 'sometimes|required',
                ]);
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }else{
                if(@$request['type'] == 1){
                    if(@$request['code']){
                        $input['code'] = $request['code'];
                    }
                    $input['status'] = 1;
                    if(@$request['description']){
                        $input['description'] = $request['description'];
                    }
                    if(@$request['cost_center_code']){
                        $input['cost_center_code'] = $request['cost_center_code'];
                    }
                    if(@$request['is_central_store']){
                        $input['is_central_store'] = $request['is_central_store'];
                    }
                    if(@$request['is_quarantine_store']){
                        $input['is_quarantine_store'] = $request['is_quarantine_store'];
                    }
                    $store = Store::create($input);
                    DB::commit();
                    $data = [
                        'id' => $store->id,
                        'code' => $store->code,
                        'description' => $store->description,
                        'status' => 1
                    ];
                    return sendDataHelper('Store add successfully',$data, $code = 200);
                }else{
                    $find_store = Store::find($request['id']);
                    if($find_store){
                        if(isset($request['status'])){
                            $add['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $add['code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $add['description'] = $request['description'];
                        }
                        if(@$request['is_quarantine_store']){
                            $add['is_quarantine_store'] = $request['is_quarantine_store'];
                        }
                        $find_store->update($add);
                        DB::commit();
                        $data = [
                            'id' => $find_store->id,
                            'code' => $find_store->code,
                            'description' => $find_store->description,
                            'status' => $find_store->status
                        ];
                        return sendDataHelper('Store modify successfully',$data, $code = 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }
        }catch(\Throwable $e){
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
