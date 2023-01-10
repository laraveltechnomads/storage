<?php

namespace App\Http\Controllers\API\V1\Clinic;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\DoctorScheduleDetail;
use App\Models\API\V1\Master\DoctorScheduleMaster;
use App\Models\API\V1\Master\ScheduleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DoctorScheduleController extends Controller
{
    /*doctor schedule list */
    public function index(Request $request)
    {
        try {
            $get_data = DB::table('doctor_schedule_masters')
            ->join('units', 'doctor_schedule_masters.unit_id', '=', 'units.id')
            ->join('doctors', 'doctor_schedule_masters.doc_id', '=', 'doctors.id')
            ->join('departments', 'doctor_schedule_masters.dept_id', '=', 'departments.id')
            ->select('doctor_schedule_masters.id as doc_schedule_id', 'doctor_schedule_masters.unit_id','doctor_schedule_masters.dept_id','doctor_schedule_masters.doc_id','units.description as clinic_name', 'doctors.first_name', 'doctors.last_name','departments.description as department_name')            
            ->get();

            if ($get_data) {
                return sendDataHelper("Doctor Schedule list", $get_data, $code = 200);
            } else {
                return sendError("Doctor Schedule list not found", [],204);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Insert  doctor schedule with unit*/
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make((array)$req,[
                "day_id" => "required|numeric",
                "schedule_id" => "required|exists:schedules,id",
                "unit_id" => "required|exists:units,id",
                "doc_id" => "required|exists:doctors,id",
                "dept_id" => "required|exists:departments,id",
                "slot_schedule_id" => "required|exists:slot_schedules,id",
                "start_time" => "required|date_format:H:i",
                "end_time" => 'required|date_format:H:i|after:start_time',
                'start_date' => 'date|date_format:Y-m-d',
                'end_date' => 'date|date_format:Y-m-d',
            ]);  

            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }
            if($req['schedule_id'] == 2)
            {
                $validation = Validator::make((array)$req,[
                    "day_of_the_week" => "required"
                ]);  
    
                if($validation->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }
            }
            if($req['schedule_id'] == 3)
            {
                $validation = Validator::make((array)$req,[
                    "month" => "required"
                ]);  
    
                if($validation->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }
            }

            $doc_sched_dt = new DoctorScheduleDetail;
            $doc_sched_dt->schedule_id = $req['schedule_id'];
            $doc_sched_dt->unit_id = $req['unit_id'];
            $doc_sched_dt->doc_id = $req['doc_id'];
            $doc_sched_dt->dept_id = $req['dept_id'];
            $doc_sched_dt->start_time = $req['start_time'];
            $doc_sched_dt->end_time = $req['end_time'];
            $doc_sched_dt->start_date = $req['start_date'];
            $doc_sched_dt->end_date = $req['end_date'];
            $doc_sched_dt->start_date_time = date('Y-m-d H:i:s', strtotime("$doc_sched_dt->start_date $doc_sched_dt->start_time"));
            $doc_sched_dt->end_date_time = date('Y-m-d H:i:s', strtotime("$doc_sched_dt->end_date $doc_sched_dt->end_time"));
            
            if(@$req['day_of_the_week'])
            {
                $doc_sched_dt->day_of_the_week = $req['day_of_the_week'];
            }
            if(@$req['month'])
            {
                $doc_sched_dt->month = $req['month'];
            }
            $doc_sched_dt->save();

            $sched_dt = new ScheduleDetail;
            $sched_dt->doc_schedule_detail_id = $doc_sched_dt->id;
            $sched_dt->day_id = $req['day_id'];
            $sched_dt->start_date_time = $doc_sched_dt->start_date.' '.$doc_sched_dt->start_time;
            $sched_dt->end_date_time = $doc_sched_dt->end_date.' '.$doc_sched_dt->end_time;
            $sched_dt->save();

            $doc_sched = new DoctorScheduleMaster;
            $doc_sched->unit_id = $doc_sched_dt->unit_id;
            $doc_sched->doc_id = $doc_sched_dt->doc_id;
            $doc_sched->dept_id = $doc_sched_dt->dept_id;
            $doc_sched->save();

            if($sched_dt) {
                DB::commit();
                return sendDataHelper('List Added', [], $code = 200);                
            }
            return sendError("Record not Added", [], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* update  doctor schedule with unit*/
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $doc_sched_dt = DoctorScheduleDetail::where('id', $id)->first();
            if(!$doc_sched_dt)
            {
                return sendError("Record not found", [], 422);
            }
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req = decryptData($request['response']); /* Dectrypt  **/
            
            $validation = Validator::make((array)$req,[
                "day_id" => "required|numeric",
                "schedule_id" => "required|exists:schedules,id",
                "unit_id" => "required|exists:units,id",
                "doc_id" => "required|exists:doctors,id",
                "dept_id" => "required|exists:departments,id",
                "slot_schedule_id" => "required|exists:slot_schedules,id",
                "start_time" => "required|date_format:H:i",
                "end_time" => 'required|date_format:H:i|after:start_time',
                'start_date' => 'date|date_format:Y-m-d',
                'end_date' => 'date|date_format:Y-m-d',
            ]);  

            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if($req['schedule_id'] == 2)
            {
                $validation = Validator::make((array)$req,[
                    "day_of_the_week" => "required"
                ]);  
    
                if($validation->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }
            }
            if($req['schedule_id'] == 3)
            {
                $validation = Validator::make((array)$req,[
                    "month" => "required"
                ]);  
    
                if($validation->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }
            }
            
            $sched_dt = ScheduleDetail::where('id', $doc_sched_dt->id)->first();
            $doc_sched_dt->schedule_id = $req['schedule_id'];
            $doc_sched_dt->unit_id = $req['unit_id'];
            $doc_sched_dt->doc_id = $req['doc_id'];
            $doc_sched_dt->dept_id = $req['dept_id'];
            $doc_sched_dt->start_time = $req['start_time'];
            $doc_sched_dt->end_time = $req['end_time'];
            $doc_sched_dt->start_date = $req['start_date'];
            $doc_sched_dt->end_date = $req['end_date'];
            $doc_sched_dt->start_date_time = date('Y-m-d H:i:s', strtotime("$doc_sched_dt->start_date $doc_sched_dt->start_time"));
            $doc_sched_dt->end_date_time = date('Y-m-d H:i:s', strtotime("$doc_sched_dt->end_date $doc_sched_dt->end_time"));
            if(@$req['schedule_id'])
            {
                $doc_sched_dt->day_of_the_week = $req['schedule_id'];
            }
            if(@$req['month'])
            {
                $doc_sched_dt->month = $req['month'];
            }
            $doc_sched_dt->save();

            $sched_dt->day_id = $req['day_id'];
            $sched_dt->start_date_time = $doc_sched_dt->start_date.' '.$doc_sched_dt->start_time;
            $sched_dt->end_date_time = $doc_sched_dt->end_date.' '.$doc_sched_dt->end_time;
            $sched_dt->update();

            $doc_sched = new DoctorScheduleMaster;
            $doc_sched->unit_id = $doc_sched_dt->unit_id;
            $doc_sched->doc_id = $doc_sched_dt->doc_id;
            $doc_sched->dept_id = $doc_sched_dt->dept_id;
            $doc_sched->save();

            if($sched_dt) {
                DB::commit();
                return sendDataHelper('List updated', [], $code = 200);                
            }
            return sendError("Record not updated", [], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function scheduleUpdateStatus(Request $request, $id)
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
            $result = DoctorScheduleDetail::where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);
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

    /*doctor schedule list pagination*/
    public function paginationIndex(Request $request, $id)
    {
        try {
            $get_data = DB::table('doctor_schedule_details')
            ->join('units', 'doctor_schedule_details.unit_id', '=', 'units.id')
            ->join('doctors', 'doctor_schedule_details.doc_id', '=', 'doctors.id')
            ->join('departments', 'doctor_schedule_details.dept_id', '=', 'departments.id')
            ->join('schedules', 'doctor_schedule_details.schedule_id', '=', 'schedules.id')
            ->join('schedule_details', 'doctor_schedule_details.id', '=', 'schedule_details.doc_schedule_detail_id')
            // ->where('doctor_schedule_details.id', $id)
            ->select('doctor_schedule_details.id as doc_schedule_detail_id', 'doctor_schedule_details.unit_id','doctor_schedule_details.dept_id','doctor_schedule_details.doc_id','units.description as clinic_name', 'doctors.first_name', 'doctors.last_name','departments.description as department_name')            
            ->paginate(10);

            if ($get_data) {
                return sendDataHelper("Doctor Schedule list", $get_data, $code = 200);
            } else {
                return sendError("Doctor Schedule list not found", [],204);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
