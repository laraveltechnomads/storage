<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AlertConfigController extends Controller
{
    public function alertCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); } 
            $data = decryptData($request['response']);
            $dbName = request()->segment(6);
           
            if($dbName == 'sms_templates') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'template_name' => "required|unique:$dbName,template_name",
                    'field_id' => "sometimes|exists:events,id"
                ]);
            }elseif($dbName == 'email_templates') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'template_name' => "required|unique:$dbName,template_name",
                    'field_id' => "sometimes|exists:events,id"
                ]);
            }else {
                $validation = Validator::make((array)$data,[
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

    public function alertCommonSearchListConfig(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); } 
            $data = decryptData($request['response']); 

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            if(isset($data['description'])) {
                $response = DB::table($dbName)->where('description', 'like', '%' . $data['description'] . '%')->get();
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

    public function alertCommonUpdateStatusConfig(Request $request)
    {
        $id = $request->route('id');
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

    public function alertCommonUpdateItemConfig(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  
            $data = decryptData($request['response']); 
            $dbName = request()->segment(6);
            
            if($dbName == 'sms_templates') {
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'template_name' => "required|unique:$dbName,template_name," . $id,
                    'field_id' => "sometimes|exists:events,id"
                ]);
            }elseif($dbName == 'email_templates') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'template_name' => "required|unique:$dbName,template_name," . $id,
                    'field_id' => "sometimes|exists:events,id"
                ]);
            }else {
                $validation = Validator::make((array)$data,[
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
}
