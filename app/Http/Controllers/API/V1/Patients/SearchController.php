<?php

namespace App\Http\Controllers\API\V1\Patients;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Clinic\DoctorSlotAppointment;
use App\Models\API\V1\Master\AppointmentReason;
use App\Models\API\V1\Master\AppointmentStatus;
use App\Models\API\V1\Master\Country;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\DoctorScheduleDetail;
use App\Models\API\V1\Master\Gender;
use App\Models\API\V1\Master\SlotSchedule;
use App\Models\API\V1\Master\TimeSlot;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function searchPatientDetails(Request $request)
    {
        try {
            $unit_id = null;
            $patient_category = null;
            $search = null;

            $byRegistration_date = null;
            $byVisit_date = null;
            $from_date = null;
            $to_date = null;
            $source_of_ref_id = null;
            $referal_doc_id = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                    $unit_id = @$request['unit_id'];
                    $patient_category = @$request['patient_category'];

                    $byRegistration_date = @$request['byRegistration_date'] ? true : false;
                    $byVisit_date = @$request['byVisit_date'] ? true : false;
                    
                    $source_of_ref_id = @$request['source_of_ref_id'];
                    $referal_doc_id = @$request['referal_doc_id'];

                    if(@$request['byRegistration_date'])
                    {
                        $data = Validator::make($request,[
                            'registration_type' => 'exists:patient_categories,reg_code'
                        ]);
                
                        if($data->fails()){
                            return sendError($data->errors()->first(), [], 422);
                        }
                    }
                    
                    if(@$request['from_date'])
                    {
                        
                        $data = Validator::make($request,[
                            'from_date' => 'sometimes|date|date_format:Y-m-d'
                        ],[
                            'from_date.date' => 'The date of from_date is not a valid date. Ex: 1990-01-01'
                        ]);
                
                        if($data->fails()){
                            return sendError($data->errors()->first(), [], 422);
                        }
                        $from_date = date('Y-m-d', strtotime(@$request['from_date']) );
                    }

                    if(@$request['to_date'])
                    {
                        $data = Validator::make($request,[
                            'to_date' => 'date|date_format:Y-m-d'
                        ]);
                
                        if($data->fails()){
                            return sendError($data->errors()->first(), [], 422);
                        }
                        $to_date = date('Y-m-d', strtotime(@$request['to_date']) );
                    }
                }
            }

            $response = [];
            $reg = Registration::query();
            $reg->orderBy('registration_type', 'asc');

            if(isset($search))
            {
                $reg->where('first_name', 'like', "{$search}%");
                $reg->orWhere('last_name', 'like', "{$search}%");
                $reg->orWhere('contact_no', 'like', "{$search}%");
                $reg->orWhere('mrn_number', 'like', "{$search}%");
            }

            if($unit_id)
            {
                $reg->where('patientUnitId', $unit_id);
            }

            if($patient_category)
            {
                $reg->where('registration_type', $patient_category);
            }

            if($byRegistration_date)
            {
                if($from_date)
                {
                    $reg->whereDate('registration_date', '>=', $from_date);
                }
                if($to_date)
                {
                    $reg->whereDate('registration_date', '<=', $to_date);
                }
            }
            if($source_of_ref_id)
            {
                $reg->where('source_reference', $source_of_ref_id);
            }
            if($referal_doc_id)
            {
                $reg->where('doctor', $referal_doc_id);
            }

            $register = $reg->latest()->get();
        
            if(count($register) > 0)
            {
                foreach ($register as $key => $value) {
                    // $partner = Registration::query();
                    // $partner->where('registration_number', $value->id);
                    // $partner->latest()->select('first_name', 'last_name', 'mrn_number');
                    // $partner = $partner->first();

                    if($byVisit_date)
                    {   
                        $partner = config('constants.patientType')[1];
                        $app =  Appointment::query();
                        $app->whereNotIn('registration_type', ['partner']);
                        $app->where('registration_type', $value->registration_type);
                        $app->where('reg_type_patient_id', $value->id);
                        
                        if($from_date)
                        {
                            $app->whereDate('appointment_date', '>=', $from_date);
                        }
                        if($to_date)
                        {
                            $app->whereDate('appointment_date', '<=', $to_date);
                        }
                        $app = $app->latest()->first();
                        if($app)
                        {
                            $dataArr = [
                                'table_name' => 'registrations',
                                'patient_id' => $value->id,
                                'patientUnitId' => $value->patientUnitId,
                                'source_reference' => $value->source_reference,
                                'doctor' => $value->doctor,
                                'first_name' => $value->first_name,
                                'middle_name' => $value->middle_name,
                                'last_name' => $value->last_name,
                                'contact_no' => Country::where('id', $value->country)->value('country_code').' '.$value->contact_no,
                                'mrn_number' => $value->mrn_number,
                                'country' => Country::where('id', $value->country)->value('country_name'),
                                'clinic_name' => Unit::where('id', $value->patientUnitId)->value('clinic_name'),
                                'registration_date' => date('d-M-Y', strtotime($value->registration_date) ),
                                // 'partner_details' => $partner
                            ];
                            array_push($response, $dataArr);
                        }
                    }else{
                        $dataArr = [
                            'table_name' => 'registrations',
                            'patient_id' => $value->id,
                            'patientUnitId' => $value->patientUnitId,
                            'source_reference' => $value->source_reference,
                            'doctor' => $value->doctor,
                            'first_name' => $value->first_name,
                            'middle_name' => $value->middle_name,
                            'last_name' => $value->last_name,
                            'contact_no' => Country::where('id', $value->country)->value('country_code').' '.$value->contact_no,
                            'mrn_number' => $value->mrn_number,
                            'country' => Country::where('id', $value->country)->value('country_name'),
                            'clinic_name' => Unit::where('id', $value->patientUnitId)->value('clinic_name'),
                            'registration_date' => date('d-M-Y', strtotime($value->registration_date) ),
                            // 'partner_details' => $partner
                        ];
                        array_push($response, $dataArr);
                    }
                }
            }
            return sendDataHelper('Patient Details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Doctor schedule selection  */
    public function doctorScheduleSearch(Request $request)
    {
        try {
            $search = null;
            $unit_id = auth()->user()->unit_id;
            $select_date = date('Y-m-d');
            $response = [];
            if(respValid($request)) { return respValid($request); }
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                // 'unit_id' => 'required',
                // 'dept_id' => 'required',
                // 'doc_cat_id' => 'required',
                'select_date' => 'required|date|date_format:Y-m-d'
            ],[
                // 'unit_id.required' => 'Select Clinic',
                // 'dept_id.required' => 'Select Department',
                // 'doc_cat_id.required' => 'Select Doctor Category',
                'select_date.required' => 'Select Date'
            ]);
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            if($request)
            {
                $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                $unit_id = @$request['unit_id'];
                $select_date = date('Y-m-d', strtotime(@$request['select_date']) );

                if(@$request['select_date'])
                {
                    $data = Validator::make($request,[
                        'select_date' => 'sometimes|date|date_format:Y-m-d'
                    ],[
                        'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'
                    ]);
                }
            }
  
            $currentDate = date("Y-m-d", strtotime($select_date));
            // $StartDate = date("Y-m-1", strtotime($currentDate));
            // $EndDate = date("Y-m-31 23:59:59", strtotime($currentDate));

            $doc_sched_dtl = DoctorScheduleDetail::query();
            // $doc_sched_dtl->where('unit_id', $unit_id);
            $doc_sched_dtl->where('start_date','<=', $select_date);
            $doc_sched_dtl->whereDate('end_date','>=', $select_date);
            if(@$request['doctor_id'])
            {
                $doc_sched_dtl->where('doc_id', @$request['doctor_id']);
            }
            $doc_sched_dtl = $doc_sched_dtl->get();

            if( count($doc_sched_dtl) > 0)
            {
                foreach ($doc_sched_dtl as $key => $doc_sched) {
                    
                    $doc_sched->start_time;  // 12:20:00
                    $doc_sched->end_time; // 13:10:00
                    $TimeSlots = TimeSlot::where('time', '>=', $doc_sched->start_time)->where('time', '<=', $doc_sched->end_time)->get();
                    $slot_times_response = [];
                    if( count($TimeSlots) > 0) 
                    {   
                        foreach ($TimeSlots as $key => $time_slot) {
                            $doc_slot = DoctorSlotAppointment::where('doc_id', $doc_sched->doc_id)->where('time_slot_id', $time_slot->id)->whereIn('status', [1,2])->first();
                            if(!$doc_slot)
                            {
                                $timeArr = [
                                    'time_slot_id' => $time_slot->id,
                                    'description' => $time_slot->description
                                ];
                                array_push($slot_times_response, $timeArr);    
                            }
                        }
                    }
                    $doctor = Doctor::query();
                    $doctor->where('id', $doc_sched->doc_id);
                    
                    if($search)
                    {
                        $doctor->where('first_name', 'like', "%{$search}%");
                        $doctor->orWhere('middle_name', 'like', "%{$search}%");
                        $doctor->orWhere('last_name', 'like', "%{$search}%");
                    }
                    
                    $doctor = $doctor->first();

                    if( $doctor)
                    {
                        $Department = Department::where('id', $doc_sched->dept_id)->first();
                        $SlotSchedule = SlotSchedule::where('id', $doc_sched->schedule_id)->first();
                        $doctorArr = [
                            'doc_id' => $doctor->id,
                            // 'doctor_name' => 'Dr. '.$doctor->first_name. ' '.$doctor->last_name,
                            // 'department' => $Department ? $Department->description : null,
                            // 'date' => date('d-M-y', strtotime($doc_sched->start_date)).' To '.date('d-M-y', strtotime($doc_sched->end_date)),
                            // 'schedule' => ($SlotSchedule ? $SlotSchedule->description : null).' '.date('H:i A', strtotime($doc_sched->start_time)).' To '.date('H:i A', strtotime($doc_sched->end_time)),
                            // 'schedule_slot' => $SlotSchedule ? $SlotSchedule->description : null,
                            // 'doc_schedule_detail_id' => $doc_sched->id,
                            'slot_times_response' => $slot_times_response
                        ];
                        array_push($response, $doctorArr);
                    }
                }
            }
            if($response == [])
            {
                return sendError('Dcotor not available.', [], 404);
            }
            return sendDataHelper('Doctor schedule setails.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    

    /*Appointment booking list pagination */
    public function appBookingListPagination(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($request,[
                'from_date' => 'required',
                'to_date' => 'required',
                'app_unit_id' => 'required'
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $unit_id = 1;

            if(@$request['app_unit_id'])
            {
                $unit_id = @$request['app_unit_id'];
            }
            $response = [];
            $time_slot = null;
            $doctor = null;
            $department = null;
            $arr_resp = [];

            $from_date = $request['from_date'];
            $to_date = $request['to_date'];

            $appointment = Appointment::query();
            $appointment->with('registration_list')->has('registration_list');
            $appointment->with('appointment_status')->has('appointment_status');
            $appointment->with('appointment_reason');
            $appointment->with('appointment_type')->has('appointment_type');
            $appointment->with('doctor_detail');
            $appointment->with('dept_detail');
            $appointment->with('app_doc_slot.time_slot');
            $appointment->whereBetween('appointment_date', [$from_date, $to_date]);
            $appointment->where('app_unit_id', $unit_id);
            $appointment->select('id', 'reg_type_patient_id', 'appointment_date', 'app_status_id', 'app_reason_id', 'app_type_id', 'doc_id', 'dept_id', 'status');
            $appointment->orderBy('appointment_date', 'asc');
            $appointment->where('is_cancel', false);
            $appointment = $appointment->paginate(2);
           
            if(count($appointment) > 0)
            {
                $single = 0;
                foreach ($appointment as $key => $app) {
                    $responseDate = [];
                    $single = strtotime($app->appointment_date);
                    $arr = [];
                    $patient_detail = $app->registration_list;
                    $doc_slot_details = $app->app_doc_slot;
                    $doctor_details = $app->doctor_detail;
                    $department = $app->dept_detail;

                    if($doc_slot_details)
                    {
                        if($app->app_doc_slot->time_slot)
                        {
                            $time_slot = $app->app_doc_slot->time_slot->description;
                        }
                    }
                    
                    $reason = $app->reason;
                    if($app->app_reason_id)
                    {
                        $reas = AppointmentReason::where('created_unit_id', auth()->user()->unit_id)->where('id', $app->app_reason_id)->whereStatus(1)->first();
                        $reason = $reas ? $reas->description : null;
                    }

                    $status = null;
                    if($app->app_status_id)
                    {
                        $app_status = AppointmentStatus::whereStatus(1)->first();
                        $status = $app_status ? $app_status->description : null;
                    }   
                    
                    $appointment[$key] = [
                        'appointment_id' => $app->id,
                        'appointment_date' => $app->appointment_date,
                        'patient_name' => $patient_detail->first_name.' '.$patient_detail->last_name,
                        'time' => $time_slot,
                        'contact_no' => $patient_detail->contact_no,
                        'app_status' =>  $status,
                        'app_status_id' => $app->app_status_id,
                        'profile_image' => $patient_detail->profile_image,
                        'detail' => [
                            'mrn_number' => $patient_detail->mrn_number,
                            'date_of_birth' => $patient_detail->date_of_birth,
                            'appointment_with' => 'Dr. '.($doctor_details ? $doctor_details->first_name.' '.$doctor_details->last_name : $app->doctor),
                            'billing_status' => 'Issued',
                            'reason' => $reason,
                            'doctor_name' => 'Dr. '.($doctor_details ? $doctor_details->first_name.' '.$doctor_details->last_name : $app->doctor),
                            'department' => $department ? $department->description : "-"
                        ]
                    ];
                    // array_push($responseDate, $arr);
                    // $responseDate[$key][date('d F, Y', strtotime($app->appointment_date))] = $arr_resp;
                    // array_push($response, $arr);
                }
            }
            return sendDataHelper('Appointment list view.', $appointment, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
