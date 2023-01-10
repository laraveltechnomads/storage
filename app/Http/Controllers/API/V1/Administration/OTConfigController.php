<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OTConfigController extends Controller
{
    /*
    - ot_masters
    - procedure_type_masters
    - operation_result_masters
    - ot_table_masters
    - pre_operative_instruction_masters
    - post_operative_instruction_masters
    - intra_operative_instruction_masters
    - surgery_notes_masters
    - anesthesia_masters
    - anesthesia_note_masters
    - anesthesia_type_masters
    - operation_status_masters
    - procedure_masters
    - procedure_category_masters
    - procedure_sub_category_masters
    - procedure_check_list_masters
    - doctor_note_masters
    */

    public function oTCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            
            if ($dbName == 'procedure_sub_category_masters') {
                $validateData['code'] =  "required|unique:$dbName,code";
                $validateData['description'] =  "required|unique:$dbName,description";
                $validateData['procedure_cat_id'] =  "required|exists:procedure_category_masters,id";
            }elseif ($dbName == 'procedure_check_list_masters') {
                $validateData['code'] =  "required|unique:$dbName,code";
                $validateData['description'] =  "required|unique:$dbName,description";
                $validateData['procedure_cat_id'] =  "required|exists:procedure_category_masters,id";
                $validateData['procedure_sub_cat_id'] =  "required|exists:procedure_sub_category_masters,id";
            } else {
                $validateData['code'] =  "required|unique:$dbName,code";
                $validateData['description'] =  "required|unique:$dbName,description";
            }

            $validation = Validator::make((array)$data, $validateData);
     
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

    public function oTCommonSearchListConfig(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            
            $response = DB::table($dbName);
            if(isset($data['search_description']) ) {
                $response ->where('description', 'like', '%' . $data['search_description'] . '%');
            } 
            $response = $response->get();
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

    public function oTCommonUpdateStatusConfig(Request $request)
    {
        $id = $request->route('id'); 
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

    public function oTCommonUpdateItemConfig(Request $request)
    {
        $id = $request->route('id');
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            $validateData['description'] =  "required|unique:$dbName,description," . $id;
            
            if ($dbName == 'procedure_sub_category_masters') {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
                $validateData['procedure_cat_id'] =  "required|exists:procedure_category_masters,id";
            }elseif ($dbName == 'procedure_check_list_masters') {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
                $validateData['procedure_cat_id'] =  "required|exists:procedure_category_masters,id," . $id;
                $validateData['procedure_sub_cat_id'] =  "required|exists:procedure_sub_category_masters,id," . $id;
            } else {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
            }

            $validation = Validator::make((array)$data, $validateData);
     
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

}
