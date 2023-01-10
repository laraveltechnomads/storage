<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AutoNumberFormatController extends Controller
{
    /** Clinical Auto Number Format */
    /**
     * 1. 

     */
    public function anfCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            
            $error = self::validationANF($data, $dbName);
            if($error){  return $error; }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $response = DB::table($dbName)->insert($data);
            if ($response) {
                DB::commit();
                return sendDataHelper("$message added successfully", $response, $code = 200);
            } else {
                return sendError("$message not added", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function anfCommonSearchListConfig(Request $request)
    {
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            
            $response = DB::table($dbName)->get();
            

            if ($response) {
                return sendDataHelper("$message List", $response, $code = 200);
            } else {
                return sendError("$message list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function anfCommonUpdateStatusConfig(Request $request)
    {

        DB::beginTransaction();
        try {

            $id =  $request->route('id');

            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'status' => 'required|in:1,0',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $dbName = request()->segment(6);

            $result = DB::table($dbName)->where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);

            if ($result) {
                DB::commit();
            }
            return sendDataHelper('Status updated successfully', [], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function anfCommonUpdateItemConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            $id =  $request->route('id');
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            
            $error = self::validationANF($data, $dbName);
            if($error){  return $error; }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['updated_at'] = Carbon::now();
            $result = DB::table($dbName)->where('id', $id)->update($data);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper("$message updated successfully", [], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function validationANF($data, $dbName)
    {
        $validation = Validator::make((array)$data, [
            "unit_code" => "sometimes",
            "city_code" => "sometimes",
            "month" => "sometimes",
            "year" => "sometimes",
            "index_no" => "sometimes",
            "trans_type" => "sometimes",
            "reg_type" => "sometimes",
            "dept_code" => "sometimes",
            "supllier_code" => "sometimes",
            "to_store_code" => "sometimes",
            "from_store_code" => "sometimes",
            "store_code" => "sometimes",
            "sequence" => "sometimes|unique:$dbName,sequence"
        ]);

        if ($validation->fails()) {
            return sendError($validation->errors()->first(), [], 422);
        }
    }
}
