<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\OtSchedulingMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OTScheduleController extends Controller
{
    
    /* ot schedule add */
    public function otScheduleAdd(Request $request)
    {
        
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make((array)$data, [
                'ot_id' => "required|exists:ot_masters,id",
                'ot_table_id' => "required|exists:ot_table_masters,id",
                'day_id' => "required|exists:ot_table_masters,id",
                'schedule_id' => "required|exists:ot_table_masters,id",
                "from_time" => "required|date_format:H:i:s",
                "to_time" => 'required|date_format:H:i:s|after:from_time'
            ]);

            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }
            
            $data['code'] = OtSchedulingMaster::latest()->value('code')+1;
            
            $response = OtSchedulingMaster::insert($data);
            if ($response) {
                DB::commit();
                return sendDataHelper("OT scheduling added successfully", $response, $code = 200);
            } else {
                return sendError("OT scheduling not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function otScheduleSearchList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            
            $query = OtSchedulingMaster::query();
            $query->join('ot_masters', 'ot_scheduling_masters.ot_id', '=', 'ot_masters.id');
            $query->join('ot_table_masters', 'ot_scheduling_masters.ot_table_id', '=', 'ot_table_masters.id');
            $query->join('day_masters', 'ot_scheduling_masters.day_id', '=', 'day_masters.id');
            $query->join('schedules', 'ot_scheduling_masters.schedule_id', '=', 'schedules.id');
            if(isset($data['search']) ) {

                $query->where('code', 'like', '%' . $data['search'] . '%');
            }
            $query->select('ot_scheduling_masters.id as ot_schedule_id', 'ot_scheduling_masters.*', 'ot_masters.description as ot_name', 'ot_table_masters.description as ot_table_name', 'day_masters.description as day_name', 'schedules.description as schedule_name');
            $response = $query->get();
            if ($response) {
                return sendDataHelper("OT scheduling List", $response, $code = 200);
            } else {
                return sendError("OT scheduling list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function otScheduleUpdateStatus(Request $request, $id)
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

    public function otScheduleUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make((array)$data, [
                'ot_id' => "required|exists:ot_masters,id",
                'ot_table_id' => "required|exists:ot_table_masters,id",
                'day_id' => "required|exists:ot_table_masters,id",
                'schedule_id' => "required|exists:ot_table_masters,id",
                "from_time" => "required|date_format:H:i:s",
                "to_time" => 'required|date_format:H:i:s|after:from_time'
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $result = OtSchedulingMaster::where('id', $id)->update($data);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper("OT scheduling updated successfully",[], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function otScheduleSearchPaginationList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            
            $query = OtSchedulingMaster::query();
            $query->join('ot_masters', 'ot_scheduling_masters.ot_id', '=', 'ot_masters.id');
            $query->join('ot_table_masters', 'ot_scheduling_masters.ot_table_id', '=', 'ot_table_masters.id');
            $query->join('day_masters', 'ot_scheduling_masters.day_id', '=', 'day_masters.id');
            $query->join('schedules', 'ot_scheduling_masters.schedule_id', '=', 'schedules.id');
            if(isset($data['ot_id']) ) {

                $query->where('ot_masters.id', 'like', $data['ot_id']);
            }
            if(isset($data['ot_table_id']) ) {

                $query->where('ot_table_masters.id', 'like', $data['ot_table_id']);
            }
            $query->select('ot_scheduling_masters.id as ot_schedule_id', 'ot_scheduling_masters.*', 'ot_masters.description as ot_name', 'ot_table_masters.description as ot_table_name', 'day_masters.description as day_name', 'schedules.description as schedule_name');
            $response = $query->paginate(4);
            if ($response) {
                return sendDataHelper("OT scheduling List", $response, $code = 200);
            } else {
                return sendError("OT scheduling list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
