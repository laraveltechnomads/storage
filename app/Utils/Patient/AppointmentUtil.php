<?php

namespace App\Utils\Patient;

use App\Models\API\V1\Clinic\DoctorSlotAppointment;
use App\Models\API\V1\Master\AppointmentReason;
use App\Models\API\V1\Master\AppointmentStatus;
use App\Models\API\V1\Master\AppointmentType;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\TimeSlot;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

Class AppointmentUtil
{
    /* Step zero */
    public function appointmentZero($request, $datareq)
    {
        $data = Validator::make($request,[
            'first_name' => 'required|min:2|max:50',
            'contact_no' => 'numeric|digits_between:10,16',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'date_of_birth' => 'sometimes|date|date_format:Y-m-d',
            'email_address' => 'email|min:1|max:90'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    /*  Store reg Step Zero */
    public function regStepZero($request, $datareq)
    {
        $mrn = $request['registration_type'].'/'.date('d').'/'.date('m').'/'.date('Y');

        $appt =Appointment::firstOrNew(['email_address' => $request['email_address'], 'contact_no' => $request['contact_no'] ]);
        $register = Registration::firstOrNew(['email_address' => $request['email_address'], 'contact_no' => $request['contact_no'] ]);
        if(!$register && $appt)
        {
            $app = Appointment::find($appt->id);
        }else{
            $app = new Appointment();
        }
        
        $app->registration_type = $request['registration_type'];
        if(@$request['first_name'])
        {
            $app->first_name = $request['first_name'];
        }
        if(@$request['last_name'])
        {
            $app->last_name = $request['last_name'];
        }
        if(@$request['contact_no'])
        {
            $app->contact_no = $request['contact_no'];
        }
        if(@$request['email_address'])
        {
            $app->email_address = $request['email_address'];
        }
        if(@$request['date_of_birth'])
        {
            $app->date_of_birth = date('Y-m-d', strtotime($request['date_of_birth']));
        }
        if(@$request['referred_by'])
        {
            $app->referred_by = $request['referred_by'];
        }            
        if(@$request['doctor_id'])
        {
            $app->doc_id = $request['doctor_id'];
        }
        if(@$request['reason'])
        {   
            $app->reason = @$request['reason'];
        } 
        if(@$request['app_reason_id'])
        {   
            $app->app_reason_id = @$request['app_reason_id'];
        }

        if(@$request['select_date'])
        {
            $app->appointment_date = @$request['select_date'];
        }
        $app->app_unit_id = auth()->user()->unit_id;
        $app->app_type_id = 1;
        $app->save();
        
        if($app)
        {
            $Appointment = Appointment::where('id', $app->id)->first();
            $Appointment['appointment_id'] = $Appointment->id;
            $Appointment['step'] = $request['step'];
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Appointment data successfully submitted.', $Appointment->toArray(), $code = 200);
        }
    }

    /*appointment date filter select  ------------------- */
    public function datefilterCount($request)
    {
        $app = Appointment::query();
        $app->where('app_unit_id', $request['app_unit_id']);
        $date_type = $request['date_type'];
        if($date_type == 'week')
        {                
            $day = date('Y-m-d', strtotime($request['select_date']));
            $app->whereDate('appointment_date', '=', $day);
        }
        if($date_type == 'month')
        {
            $app->whereYear('appointment_date', '=', $request['select_year']);
            $app->whereMonth('appointment_date', '=', $request['select_month']);
        }
        if($date_type == 'year')
        {
            $app->whereYear('appointment_date', '=', $request['select_year']);
        }
        $app->with('appointment_status')->has('appointment_status');
        $app->with('appointment_reason');
        $app->with('appointment_type')->has('appointment_type');
        $app->with('doctor_detail');
        $app->with('dept_detail');
        $app->with('app_doc_slot.time_slot');
        $app->where('app_unit_id', auth_unit_id());
        $app->orderBy('appointment_date', 'desc');
        return $app; 
    }   

    /* Appointment booked details total count*/
    public function bookedDetails($request)
    {
        $app = self::datefilterCount($request);
        return $booked = $app->get()->count();
    }

    /* Appointment follow ups details total count*/
    public function followUpsDetails($request)
    {
        $app = self::datefilterCount($request); 
        $app->where('is_cancel', false);
        $app->where('visit_mark', false);
        return $follow_ups = $app->get()->count();
    }    

    /* Appointment re-scheduled details total count*/
    public function rescheduleDetails($request)
    {
        $app = self::datefilterCount($request); 
        $app->where('is_reschedule', 1);
        return $re_scheduled = $app->get()->count();
    }

    /* Appointment cancel details total count*/
    public function cancelDetails($request)
    {
        $app = self::datefilterCount($request); 
        $app->where('is_cancel', 1);
        return $cancelled = $app->get()->count();
    }     

    /* Appointment date wise pagination details*/
    public function appPatientBookPaginationList($appointment_date, $request)
    {
        // $appointment_date = "2022-05-05";
        $arr = [];
        $query = Appointment::query();
        $query->whereIn('id', $request->pluck('id'));
        $query->whereDate('appointment_date', $appointment_date);
        $query->orderBy('appointment_date', 'desc');
        $query->get();
        $result = $query->get();
        if(count($result) > 0)
        {
            foreach ($result as $k => $app) 
            {
                $return_app_id = $app->id;
                // strtotime($app->appointment_date);
                $single = strtotime($app->appointment_date);
                $times = null;
                $doctor = null;
                $department = null;
                
                $detail = Registration::where('id', $app->reg_type_patient_id)->first();
                if($detail)
                {
                    $fullname = $detail->first_name.' '.$detail->last_name;
                    $profile_image = $detail->profile_image;

                    $contact_no = $detail->contact_no;
                    $mrn = $detail->mrn_number; 
                    $registration_type = $detail->registration_type; 

                }else{
                    $fullname = $app->first_name.' '.$app->last_name;
                    $profile_image = null;
                    $contact_no = $app->contact_no;

                    $mrn = null; 
                    $registration_type = $app->registration_type; 
                }
                $oldSlot = DoctorSlotAppointment::where('appointment_id', $app->id)->whereStatus(1)->first();
                $times = null;
                if($oldSlot)
                {
                    $times = ($times = TimeSlot::where('id', $oldSlot->time_slot_id)->first()) ? $times->description : null;
                    $doctor = Doctor::find($oldSlot->doc_id);
                    $department = Department::find($oldSlot->dept_id);
                }
                $reason = $app->reason;
                if($app->app_reason_id)
                {
                    $reas = AppointmentReason::where('created_unit_id', auth()->user()->unit_id)->where('id', $app->app_reason_id)->first();
                    if($reas)
                    {
                        $reason = $reas->description;
                    }
                }
                $refer_by = Doctor::find($app->referred_by);

                $data_get = [
                    'appointment_id' => $app->id,
                    'patient_name' => $fullname,
                    'time' => $times,
                    'contact_no' => $contact_no,
                    'is_cancel' => $app->is_cancel,
                    'is_reschedule' => $app->is_reschedule,
                    'status' => $app->status,
                    'profile_image' => $profile_image,
                    'app_unit_id' => $app->app_unit_id,
                    'appointment_date' => $app->appointment_date,
                    'detail' => [
                        'reason' => $reason,
                        'doctor_name' => $doctor ? $doctor->first_name.' '.$doctor->last_name : "-",
                        'doc_id' => $app->doc_id,
                        'referred_by_id' => $app->referred_by,
                        'referred_by_name' => $refer_by ? $refer_by->first_name.' '.$refer_by->last_name : "-",
                        'department' => $department ? $department->	description : "-",
                        'mrn_number' => $mrn,
                        'registration_type' => $registration_type,
                        'date_of_birth' => $app->date_of_birth,
                        'visit_wait' => $app->visit_wait,
                        'visit_mark' => $app->visit_mark,
                        'visit_id' => $app->visit_id
                    ]
                ];
                array_push($arr, $data_get);
            }
        }
        return $arr;
    }

    /* Exist patient appointment booking*/
    public function existpatientBookingNew($request)
    {
        DB::beginTransaction();
        try {        

            $data = Validator::make($request,[
                'step' => 'required|numeric',
                'select_date' => 'sometimes|date|date_format:Y-m-d',
                'time_slot_id' => 'required|numeric',
                'doctor_id' => 'required',
                'patient_id' => 'required'
            ],[
                'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $reg = Registration::find($request['patient_id']);
            if(!$reg)
            {
                return sendErrorHelper('Record not found.', [], 404);
            }

            $app = new Appointment();
            $app->app_unit_id = auth()->user()->unit_id;
            $app->reg_unit_id = $reg->patientUnitId;
            $app->reg_type_patient_id = $reg->id;
            $app->registration_type = $reg->registration_type;
            $app->first_name = $reg->first_name;
            $app->last_name = $reg->last_name;
            $app->contact_no = $reg->contact_no;
            $app->email_address = $reg->email_address;
            $app->date_of_birth = date('Y-m-d', strtotime($reg->date_of_birth));
            $app->doc_id = $request['doctor_id'];
            $app->appointment_date = $request['select_date'];
            $app->time_slot_id = $request['time_slot_id'];	
            if(@$request['app_reason_id'])
            {
                $app->app_reason_id = $request['app_reason_id'];
            }
            if(@$request['referred_by'])
            {
                $app->referred_by = $request['referred_by_id'];
            }
            
            $app_type = AppointmentType::whereStatus(1)->first();
            $app->app_type_id = $app_type ? $app_type->id : 1;
            
            $app_status = AppointmentStatus::whereStatus(1)->first();
            $app->app_status_id = $app_status ? $app_status->id : 1;
            
            $app->save();

            $app = Appointment::where('id', $app->id)->first();
            $slot_store = new DoctorSlotAppointment;
            $slot_store->unit_id = $app->app_unit_id;
            $slot_store->doc_id = $app->doc_id;
            $slot_store->time_slot_id = $app->time_slot_id;
            $slot_store->appointment_id = $app->id;
            $slot_store->select_date = $app->appointment_date;
            $slot_store->status = 1;
            $slot_store->created_unit_id = auth_unit_id();
            $slot_store->updated_unit_id = auth_unit_id();
            $slot_store->save();

            Appointment::where('id', $app->id)->update(['app_slot_id' => $slot_store->id]);

            $appointment = Appointment::where('id', $app->id)->first();
            DB::commit();
            // $appointment;
            $response = [
                'appointment_id' => $appointment->id,
                'registration_type' => $appointment->registration_type,
                'doctor_id' => $appointment->doc_id,
                'time_slot_id' => $appointment->time_slot_id,
                'patient_id' => $reg->id
            ];
            return sendDataHelper('Appointment Data successfully submitted.', $response, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}