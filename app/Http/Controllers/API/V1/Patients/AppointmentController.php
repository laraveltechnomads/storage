<?php

namespace App\Http\Controllers\API\V1\Patients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Clinic\DoctorSlotAppointment;
use App\Models\API\V1\Clinic\Visit;
use App\Models\API\V1\Master\AppointmentReason;
use App\Models\API\V1\Master\AppointmentStatus;
use App\Models\API\V1\Master\AppointmentType;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\TimeSlot;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\BabyRegistration;
use App\Models\API\V1\Register\Registration;
use App\Utils\Patient\AppointmentUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    protected $appointment_util;
    public function __construct(AppointmentUtil $appointment_util)
    {
        $this->appointment_util = $appointment_util;
    }

    /* 
        Patients Register 
    */
    public function appointmentGet($request, $datareq)
    {   
        /* Step zero */
        $data = Validator::make($request,[
            'first_name' => 'required|min:2|max:50',
            'contact_no' => 'numeric|digits_between:10,16',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'date_of_birth' => 'date|date_format:Y-m-d',
            'email_address' => 'sometimes|email|min:1|max:90'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
        	
        if(@$request['select_date'])	
        { 	
            $data = Validator::make($request,[	
                'select_date' => 'sometimes|date|date_format:Y-m-d'	
            ],[	
                'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'	
            ]);	
        }	
        if($data->fails()){	
            return sendError($data->errors()->first(), [], 422);	
        }
        
        $mrn = $request['registration_type'].'/'.date('d').'/'.date('m').'/'.date('Y');
        
        $app = new Appointment();
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
        if(@$request['doctor'])
        {   
            $app->doctor = @$request['doctor'];
        }            

        if(@$request['select_date'])
        { 	
            $app->appointment_date = @$request['select_date'];	
        }
        
        $app_type = AppointmentType::whereStatus(1)->first();
        $app->app_type_id = $app_type ? $app_type->id : 1;

        $app_status = AppointmentStatus::whereStatus(1)->first();
        $app->app_status_id = $app_status ? $app_status->id : 1;


        $app->app_unit_id = auth()->user()->unit_id;
        $app->save();
        $Appointment = Appointment::where('id', $app->id)->first();
        $Appointment['appointment_id'] = $Appointment->id; 
        $Appointment['step'] = $request['step'];
        // $Appointment['reg_id'] = $Appointment->reg_id;
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Appointment data successfully submitted.', $Appointment->toArray(), $code = 200);
            
    }

    /* 
        Patients Register 
    */
    public function appointmentId($request, $datareq)
    {   
        /* Step zero */
        $data = Validator::make($request,[
            'first_name' => 'required|min:2|max:50',
            'contact_no' => 'numeric|digits_between:10,16',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'date_of_birth' => 'date|date_format:Y-m-d',
            'email_address' => 'sometimes|email|min:1|max:90'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
        	
        if(@$request['select_date'])	
        { 	
            $data = Validator::make($request,[	
                'select_date' => 'sometimes|date|date_format:Y-m-d'	
            ],[	
                'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'	
            ]);	
        }	
        if($data->fails()){	
            return sendError($data->errors()->first(), [], 422);	
        }
        
        $mrn = $request['registration_type'].'/'.date('d').'/'.date('m').'/'.date('Y');
        
        $app = new Appointment();
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
        if(@$request['doctor'])
        {   
            $app->doctor = @$request['doctor'];
        }            

        if(@$request['select_date'])
        { 	
            $app->appointment_date = @$request['select_date'];	
        }
        
        $app_type = AppointmentType::whereStatus(1)->first();
        $app->app_type_id = $app_type ? $app_type->id : 1;

        $app_status = AppointmentStatus::whereStatus(1)->first();
        $app->app_status_id = $app_status ? $app_status->id : 1;


        $app->app_unit_id = auth()->user()->unit_id;
        $app->save();
        $Appointment = Appointment::where('id', $app->id)->first();
        $Appointment['appointment_id'] = $Appointment->id; 
        $Appointment['step'] = $request['step'];
        // $Appointment['reg_id'] = $Appointment->reg_id;
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Appointment data successfully submitted.', $Appointment->toArray(), $code = 200);
            
    }

    public function appointmentList(Request $request)
    {        
        try {
            $app = Appointment::query();
            $app->where('app_unit_id', auth()->user()->unit_id); 
            $app_list = $app->get();
            
            return sendDataHelper('Patients appointment details.', $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

     /* appointment List Day Wise  show*/
    public function appointmentListSearch(Request $request)
    {        
        try {
            $search = null;
            $current_date = null;
            $doc_id = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search']; /* not search developer search data is null passed.(ex: search: null ) */ 
                   $select_date = @$request['select_date']; /* search date wise */
                   $doc_id = @$request['doc_id']; 
                   $app_slot_id = @$request['app_slot_id'];
                   $registration_number = @$request['registration_number'];
                }
            }
            $app = Appointment::query();
            $app->where('app_unit_id', auth()->user()->unit_id); 

            $response = [];
            
            if(isset($doc_id))
            {
                $app->where('doc_id', $doc_id);
            }

            if(isset($app_slot_id))
            {
                $app->where('app_slot_id', $app_slot_id);
            }

            if(isset($registration_number))
            {
                $app->where('registration_number', $registration_number);
            }
            
            if(isset($request['select_date']))
            {
                $data = Validator::make($request,[
                    'select_date' => 'sometimes|date|date_format:Y-m-d'
                ],[
                    'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'
                ]);
        
                if($data->fails()){
                    return sendError($data->errors()->first(), [], 422);
                }

                $select_date = date("Y-m-d 00:00:00", strtotime($request['select_date']));
                if(strtotime($select_date) ==  wrongDateHelper() )
                {   
                    return sendError('The select date is not a valid date. Ex: 1990-01-01', [], 422);
                }
                $StartDate = date("Y-m-d", strtotime($request['select_date']));
               
                $app->whereDate('appointment_date',$StartDate);
                // $app->Where('appointment_date', '<', $EndDate);
            }

            if(isset($search))
            {
                $app->where('first_name', 'like', "%{$search}%");
                // $app->orWhere('middle_name', 'like', "%{$search}%");
                $app->orWhere('last_name', 'like', "%{$search}%");
                $app->orWhere('contact_no', 'like', "%{$search}%");
            }

            $app_list = $app->get();
            if(count($app_list) > 0)
            {
                foreach ($app_list as $key => $app) {
                    $appArr = [
                        'appointment_id' => $app->id,
                        'registration_number' => $app->registration_number,
                        'registration_type' => $app->registration_type,
                        'doc_id' => $app->doc_id,
                        'first_name' => $app->first_name,
                        'last_name' => $app->last_name,
                        'contact_no' => $app->contact_no,
                        'appointment_date' => $app->appointment_date,
                        'status' => $app->status,
                        'is_reschedule' => $app->is_reschedule,
                        'app_slot_id' => $app->app_slot_id,
                        'app_slot_name' => slot_nameHelper($app->app_slot_id),
                        'ref_reg_id' => $app->ref_reg_id,
                        'ref_reg_type' => $app->ref_reg_type
                    ];
                    array_push($response, $appArr);
                }
            }
            return sendDataHelper('Patient details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Appointment booking */
    public function appointmentBooking(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            /* Step zero */
            $data = Validator::make($request,[
                'registration_type' => 'required|exists:patient_categories,reg_code',
                'select_date' => 'date|date_format:Y-m-d',
                'time_slot_id' => 'required',
                'doc_id' => 'required',
                'patient_id' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            
            $appList = Appointment::latest()->first();
            if($appList)
            {
                $number = $appList->id + 10;
            }else{
                $number = rand(10,999) + 1;
            }

            $mrn = @$request['registration_type'].'/'.$number.@$request['patient_id'].'/'.date('Y');
           
            if(@$request['re_shedule_against_app_id'])
            {
                $app_old = Appointment::where('id', $request['re_shedule_against_app_id'])->where('app_unit_id', auth()->user()->unit_id)->first();
                if($app_old)
                {
                    $app_old->re_shedule_against_app_id = @$request['re_shedule_against_app_id'];
                    $app_old->re_schedulling_reason = @$request['re_schedulling_reason'];
                    $app_old->is_cancel = true;
                    $app_old->update();
                }
            }

            $app = new Appointment();
            $app->time_slot_id = @$request['time_slot_id'];

            if($request['registration_type'] == 'baby'){
               $table = BabyRegistration::where('id', $request['patient_id'])->first();
                $app->registration_number = $table['registration_number'];
                $app->ref_reg_id = @$request['registration_number'] ? @$request['registration_number'] : null;
                $app->ref_reg_type = @$request['ref_reg_type'] ? @$request['ref_reg_type'] : null;
            }else{
                $table = Registration::where('id', $request['patient_id'])->first();
            }
            $app->reg_unit_id = $table['patientUnitId'];
            $app->registration_type = @$request['registration_type'];
            $app->reg_type_patient_id = @$request['patient_id'];
            if(@$table['first_name'])
            {
                $app->first_name = $table['first_name'];
            }
            if(@$table['last_name'])
            {
                $app->last_name = $table['last_name'];
            }
            if(@$table['contact_no'])
            {
                $app->contact_no = $table['contact_no'];
            }
            if(@$table['email_address'])
            {
                $app->email_address = $table['email_address'];
            }
            if(@$table['date_of_birth'])
            {
                $app->date_of_birth = date('Y-m-d', strtotime($table['date_of_birth']));
            }
            if(@$table['referred_by'])
            {
                $app->referred_by = $table['referred_by'];
            }            
            
            $app->doc_id = @$request['doc_id'];
            
            if(@$table['reason'])
            {
                $app->app_reason_id = 1;
            }            
            
            $app->appointment_date = date('Y-m-d H:s:i');
            $app->app_unit_id = auth()->user()->unit_id;
            $app->save();

            $slot_store = new DoctorSlotAppointment;
            $slot_store->unit_id = $app->app_unit_id;
            $slot_store->doc_id = $app->doc_id;
            $slot_store->doc_schedule_detail_id = @$request['doc_schedule_detail_id'];
            $slot_store->time_slot_id = $app->time_slot_id;
            $slot_store->appointment_id = $app->id;
            $slot_store->select_date = $app->appointment_date;
            $slot_store->status = 1;
            $slot_store->created_unit_id = auth()->user()->unit_id;
            $slot_store->updated_unit_id = auth()->user()->unit_id;
            $slot_store->save();
            $slot_store;
            Appointment::where('id', $app->id)->update(['app_slot_id' => $slot_store->id]);

            $Appointment = Appointment::where('id', $app->id)->first();
            $Appointment['appointment_id'] = $Appointment->id;

            DB::commit();
            return sendDataHelper(Str::ucfirst(@$request['registration_type']).' Appointment data successfully submitted.', $Appointment->toArray(), $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Cancel appointment booking */ 
    public function cancelAppBooking(Request $request)
    {
        // DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            /* Step zero */
            $data = Validator::make($request,[
                'appointment_id' => 'required|exists:appointments,id',
                'app_cancel_reason' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $appointment = Appointment::where('id', @$request['appointment_id'])->first();
            DoctorSlotAppointment::where('appointment_id', $appointment->id)->delete();
            $appointment->is_cancel = true;

            $app_status = AppointmentStatus::where('id', 2)->where('status', 1)->first();
            $appointment->app_status_id = @$app_status ? @$app_status->id : 1;

            $appointment->app_cancel_reason = $request['app_cancel_reason'];
            $appointment->app_slot_id = null;
            $appointment->status = 2;
            $appointment->save();
            
            // DB::commit();
            // return            $appointment = Appointment::where('id', @$request['appointment_id'])->first();
            return sendDataHelper(Str::ucfirst(@$request['registration_type']).' Appointment Data Successfully Cancelled.', [], $code = 200);
        } catch (\Throwable $th) {
            // DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* RescheduleAppBooking */
    public function rescheduleAppBooking(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            /* Step zero */
            $data = Validator::make($request,[
                're_shedule_against_app_id' => 'required|exists:appointments,id',
                're_schedulling_reason' => 'required',
                'registration_type' => 'required|exists:patient_categories,reg_code',
                'select_date' => 'date|date_format:Y-m-d',
                'time_slot_id' => 'required|exists:time_slots,id',
                'doctor_id' => 'required',
                'unit_id' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            
            $app_old = Appointment::where('id', $request['re_shedule_against_app_id'])->where('app_unit_id', $request['unit_id'])->first();
            if($app_old)
            {
                $app_old->is_cancel = true;
                $app_old->app_cancel_reason = @$request['re_schedulling_reason'];
                $app_old->update();

                $oldSlot = DoctorSlotAppointment::where('appointment_id', $app_old->id)->first();
                if($oldSlot){
                    $oldSlot->delete();
                }
            }

            $app = new Appointment();
            $app->registration_type = $request['registration_type'];

            $app->first_name = $app_old->first_name;
            $app->last_name = $app_old->last_name;
            $app->contact_no = $app_old->contact_no;
            $app->email_address = $app_old->email_address;
            $app->date_of_birth = $app_old->date_of_birth;
            $app->referred_by = $app_old->referred_by;
            $app->doc_id = $app_old->doc_id;
            $app->doctor = $app_old->doctor;
            $app->app_reason_id = $app_old->app_reason_id;
            $app->reason = $app_old->reason;
            $app->appointment_date = $app_old->appointment_date;
            $app->app_unit_id = $app_old->unit_id;
            $app->is_reschedule = true;
            $app->re_shedule_against_app_id = @$request['re_shedule_against_app_id'];
            $app->re_schedulling_reason = @$request['re_schedulling_reason'];

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
            if(@$request['doctor'])
            {   
                $app->doctor = @$request['doctor'];
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
            
            $app_type = AppointmentType::whereStatus(1)->first();
            $app->app_type_id = $app_type ? $app_type->id : 1;

            $app_status = AppointmentStatus::whereStatus(1)->first();
            $app->app_status_id = $app_status ? $app_status->id : 1;

            $app->app_unit_id = $request['unit_id'];
            $app->save();

            $app = Appointment::where('id', $app->id)->first();

            $slot_store = new DoctorSlotAppointment;
            $slot_store->unit_id = $app->app_unit_id;
            $slot_store->doc_id = $app->doc_id;
            $slot_store->doc_schedule_detail_id = $app->doc_id;
            $slot_store->time_slot_id =  @$request['time_slot_id'];
            $slot_store->appointment_id = $app->id;
            $slot_store->select_date = $app->appointment_date;
            $slot_store->status = 1;
            $slot_store->created_unit_id = auth()->user()->unit_id;
            $slot_store->updated_unit_id = auth()->user()->unit_id;
            $slot_store->save();
            
            Appointment::where('id', $app->id)->update(['app_slot_id' => $slot_store->id, 'time_slot_id' => $slot_store->time_slot_id ]);
            $appointment = Appointment::where('id', $app->id)->first();

            $appointment['appointment_id'] = $app->id;
            DB::commit();

            $response = [
                'appointment_id' => $appointment->id,
                'registration_type' => $appointment->registration_type,
                'doctor_id' => $appointment->doc_id,
                'time_slot_id' => $appointment->time_slot_id
            ];
            return sendDataHelper(Str::ucfirst(@$request['registration_type']).' Appointment data successfully submitted.', $response, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Appointment patient booking list**/
    public function appointmentPatientBookingList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
           $request = decryptData($request['response']); /* Dectrypt  **/


            $data = Validator::make($request,[
                'from_date' => 'required',
                'to_date' => 'required'
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $response = [];
            $from_date = date('Y-m-d', strtotime($request['from_date']) );
            $to_date = date('Y-m-d', strtotime($request['to_date']) );
            
        //    return  $oo =  strtotime($from_date)-strtotime($request['to_date']);


            // $appointment = Appointment::whereIn('id', [142,143,144])->where('app_unit_id', auth_unit_id())->get();
            $appointment = Appointment::query();
            if(strtotime($from_date)  === strtotime($request['to_date']))
            {
                $appointment->whereDate('appointment_date', $from_date);
            }else{
                $appointment->whereBetween('appointment_date', [$from_date, $to_date]);
            }  
            $appointment->with('appointment_status')->has('appointment_status');
            $appointment->with('appointment_reason');
            $appointment->with('appointment_type')->has('appointment_type');
            $appointment->with('doctor_detail');
            $appointment->with('dept_detail');
            $appointment->with('app_doc_slot.time_slot');

            $appointment->where('is_cancel', false);
            $appointment->where('visit_mark', false);
            $appointment->where('app_unit_id', auth_unit_id());
            $appointment->orderBy('appointment_date', 'desc');
            $appointment = $appointment->latest()->get();
            if(count($appointment) > 0)
            {
                $appData = [];
                $single = 0;
                foreach ($appointment as $key => $appData) {
                    if( $key && strtotime($appData->appointment_date) != $single || $key == 0)
                    {
                        $single = strtotime($appData->appointment_date);

                        $appointmentData = Appointment::query();
                        $appointmentData->where('appointment_date', $appData->appointment_date);
                        $appointmentData->where('app_unit_id', auth_unit_id());
                        $appointmentData->orderBy('appointment_date', 'asc');
                        $appointmentData->where('is_cancel', false);
                        $appointment->where('visit_mark', 0);
                        $appointmentData = $appointmentData->get();

                        if( count($appointmentData) > 0)
                        {
                            $arr = [];
                            foreach ($appointmentData as $k => $app) {
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
                                        'date_of_birth' => $app->date_of_birth
                                    ]
                                ];
                                array_push($arr, $data_get);
                            }
                        }
                        $response[date('d F, Y', strtotime($appData->appointment_date))] = $arr;
                    }
                }
            }
            return sendDataHelper('Appointment list view.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Patient check-in*/
    public  function patientCheckIn(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            /* Step zero */
            $data = Validator::make($request,[
                'appointment_id' => 'required',
                'app_unit_id' => 'required'
                // 'patient_id' => 'required',
                // 'date_time' => 'required',
                // 'visit_type_id' => 'required',
                // 'department_id' => 'required',
                // 'doctor_id' => 'required',
                // 'cabin_id' => 'sometimes',
                // 'referred_doctor_id' => 'sometimes',
                // 'remark' => 'sometimes'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            
            $app = Appointment::where('id', $request['appointment_id'])->where('app_unit_id', $request['app_unit_id'])->first();
            if($app)
            {
                $visit =  new Visit;
                $visit->patient_unit_id = $app->patientUnitId;
                $visit->patient_id = $app->reg_type_patient_id;
                $visit->unit_id = $app->app_unit_id;
                $visit->date_time = @$request['date_time'];
                // $visit->visit_type_id = @$request['visit_type_id'];
                $visit->department_id = $app->department_id;
                $visit->doctor_id = $app->doc_id;
                // $visit->cabin_id = @$request['cabin_id'];
                // $visit->referred_doctor_id = @$request['referred_doctor_id'];
                $visit->visit_notes = $app->reason;
                $visit->save();

                $app->visit_id = $visit->id;
                $app->visit_wait = false;
                $app->visit_mark = true;
                $app->update();
                
                $slot_store = DoctorSlotAppointment::where('appointment_id', @$request['appointment_id'])->update(['status' => 1]);
                $appointment = Appointment::where('id', $request['appointment_id'])->where('app_unit_id', $request['app_unit_id'])->first();
                $appointment['visit_details'] =  Visit::find($visit->id);

                $response = [
                    'appointment_id' => $appointment->id,
                    'app_unit_id' => $appointment->app_unit_id,
                    'patient_id' => $appointment->reg_type_patient_id,
                    'doctor_id' => $appointment->doc_id,
                    'appointment_date' => $appointment->appointment_date,
                    'time_slot_id' => $appointment->time_slot_id
                ];

                DB::commit();
                return sendDataHelper(Str::ucfirst(@$request['registration_type']).' Appointment visit completed.', $response, $code = 200);
            }    
            return sendErrorHelper('Record not found.', [], 404);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Visit list */
    public function patientVisitList(Request $request)
    {
        try {
            $response = [];
            $unit = Unit::where('id', auth()->user()->unit_id)->first();
            $patient_visit = Visit::where('unit_id', $unit->id)->get();
            if( count($patient_visit) > 0)
            {                
                foreach ($patient_visit as $key => $visit) {
                    $data_get = [
                        'visit_id' => $visit->id,
                        'date_time' => $visit->date_time,
                        'clinic_name' => $unit->clinic_name,
                        'visit_type' => 'visit_type',
                        'department' => 'department',
                        'doctor_name' => 'doctor_name'
                    ];
                    array_push($response, $data_get);
                }
            }
            return sendDataHelper('Patient Visit List', $response, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Appointment search list */
    public function appointmentSearchList(Request $request)
    {
        try {
            $search = null;
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/


            $data = Validator::make($request,[
                'from_date' => 'required',
                'to_date' => 'required'
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $response = [];
            
            $from_date = $request['from_date'];
            $to_date = $request['to_date'];
           
            // $appointment = Appointment::whereIn('id', [142,143,144])->where('app_unit_id', auth_unit_id())->get();
            $appointment = Appointment::query();
            $appointment->whereBetween('appointment_date', [$from_date, $to_date]);
            $appointment->where('app_unit_id', auth_unit_id());
            $appointment->select('id', 'appointment_date');
            $appointment->orderBy('appointment_date', 'asc');

            if(@$request['registration_type'])
            {
                $appointment->where('registration_type', $request['registration_type']);
            }

            if(@$request['doc_id'])
            {
                $appointment->where('doc_id', @$request['doc_id']);
            }

            if(@$request['dept_id'])
            {
                $appointment->where('dept_id', @$request['dept_id']);
            }

            if(@$request['search'])
            {
                $search = @$request['search'];
                $appointment->where('first_name', 'like', "%{$search}%");
                $appointment->orWhere('middle_name', 'like', "%{$search}%");
                $appointment->orWhere('last_name', 'like', "%{$search}%");
                $appointment->orWhere('contact_no', 'like', "%{$search}%");
                $appointment->orWhere('mrn_number', 'like', "%{$search}%");
            }
            
            $appointment = $appointment->get();
            if(count($appointment) > 0)
            {
                $appData = [];
                $single = 0;
                foreach ($appointment as $key => $appData) {
                    if( $key && strtotime($appData->appointment_date) != $single || $key == 0)
                    {
                        $single = strtotime($appData->appointment_date);

                        $appointmentData = Appointment::query();
                        $appointmentData->where('appointment_date', $appData->appointment_date);
                        $appointmentData->where('app_unit_id', auth_unit_id());
                        $appointmentData->orderBy('appointment_date', 'asc');

                        
                        
                        $appointmentData = $appointmentData->get();

                        if( count($appointmentData) > 0)
                        {
                            $arr = [];
                            foreach ($appointmentData as $k => $app) {
                                if($app->registration_type === 'baby'){
                                    $detail = BabyRegistration::where('id', $app->reg_type_patient_id)->first();
                                }else{
                                    $detail = Registration::where('id', $app->reg_type_patient_id)->first();
                                }
                                if($detail)
                                {
                                    $oldSlot = DoctorSlotAppointment::where('appointment_id', $appData->id)->first();
                                    $times = null;
                                    $doctor = null;
                                    $department = null;
                                    if($oldSlot)
                                    {
                                        $times = ($times = TimeSlot::where('id', $oldSlot->time_slot_id)->first()) ? $times->description : null;
                                        $doctor = Doctor::find($oldSlot->doc_id);
                                        $department = Department::find($oldSlot->dept_id);
                                    }
                                    
                                    $data_get = [
                                        'appointment_id' => $app->id,
                                        'patient_name' => $detail->first_name.' '.$detail->last_name,
                                        'time' => $times,
                                        'contact_no' => $detail->contact_no,
                                        'status' => $app->status,
                                        'profile_image' => $detail->profile_image,
                                        'detail' => [
                                            'reason' => $app->app_reason_id,
                                            'doctor_name' => $doctor ? $doctor->first_name.' '.$doctor->last_name : "-",
                                            'department' => $department ? $department->	description : "-"
                                        ]
                                    ];
                                    array_push($arr, $data_get);
                                }
                            }
                        }
                        $response[date('d F, Y', strtotime($appData->appointment_date))] = $arr;
                    }
                }
            }
            return sendDataHelper('Appointment Search list view.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Appointment booking new */
    public function appointmentBookingNew(Request $request)
    {
        DB::beginTransaction();
        try {        

            $datareq = [];
            $request['identity_file'];
            if ($request->hasFile('identity_file')) 
            {
                $datareq['identity_file'] = $request['identity_file'];
            }

            if(respValid($request)) { return respValid($request); }  /* Response required validation */
            $request = decryptData($request['response']);
            
            if(@$request['patient_id'])
            {
                $appointment = $this->appointment_util->existpatientBookingNew($request);
                DB::commit();
                return $appointment;
            }
            
            $data = Validator::make($request,[
                'registration_type' => 'required|exists:patient_categories,reg_code',
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            
            $patientTypes = config('constants.patientType');
            
            $couple = config('constants.patientType')[0];
            $partner = config('constants.patientType')[1];
            $baby = config('constants.patientType')[2];
            $donor = config('constants.patientType')[3];
            $individual = config('constants.patientType')[4];
            $anc = config('constants.patientType')[5];
            
            if($patientCategory = PatientCategory::whereIn('reg_code', $patientTypes)->where('reg_code', $request['registration_type'])->first())
            {  
                $error = $this->regTypeValid($request);
                if($error)
                {
                    return $error;
                }
                if($patientCategory && $patientCategory->reg_code != $request['registration_type'] )
                {
                    return sendError('Patient Registration Type Invalid', [], 422);
                }

                if(@$request['step'] == 0)
                {
                    $appointment = AppointmentController::appointmentGet($request, $datareq);
                    DB::commit();
                    return $appointment;
                }elseif(@$request['step'] == 1)
                {
                    $data = Validator::make($request,[
                        'step' => 'required|numeric',
                        'select_date' => 'sometimes|date|date_format:Y-m-d',
                        'time_slot_id' => 'required|numeric',
                        'registration_type' => 'required|exists:patient_categories,reg_code',
                        'appointment_id' => 'required|numeric'
                    ],[
                        'select_date.date' => 'The select date is not a valid date. Ex: 1990-01-01'
                    ]);
            
                    if($data->fails()){
                        return sendError($data->errors()->first(), [], 422);
                    }

                    $app = Appointment::where('id', $request['appointment_id'])->first();
                    $app->appointment_date = $request['select_date'];
                    $app->time_slot_id = $request['time_slot_id'];
                    $app->save();
                    $app['step'] = $request['step'];

                    $app = Appointment::where('id', $app->id)->first();
                    $slot_store = new DoctorSlotAppointment;
                    $slot_store->unit_id = $app->app_unit_id;
                    $slot_store->doc_id = $app->doc_id;
                    // $slot_store->doc_schedule_detail_id = @$request['doc_schdule_detail_id'];
                    $slot_store->time_slot_id = $app->time_slot_id;
                    $slot_store->appointment_id = $app->id;
                    $slot_store->select_date = $app->appointment_date;
                    $slot_store->status = 1;
                    $slot_store->created_unit_id = auth_unit_id();
                    $slot_store->updated_unit_id = auth_unit_id();
                    $slot_store->save();

                    Appointment::where('id', $app->id)->update(['app_slot_id' => $slot_store->id]);

                    $appointment = Appointment::where('id', $app->id)->first();
                    $appointment['appointment_id'] = $appointment->id;
                    DB::commit();
                    // $appointment;
                    $response = [
                        'appointment_id' => $appointment->id,
                        'registration_type' => $appointment->registration_type,
                        'doctor_id' => $appointment->doc_id,
                        'time_slot_id' => $appointment->time_slot_id
                    ];
                    return sendDataHelper('Appointment Data successfully submitted.', $response, $code = 200);
                }
                return sendErrorHelper('Record not found.', [], 404);
            }
            else
            {
                return sendErrorHelper('Record not found.', [], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Apoointment list total*/
    public function appListTotal(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* Response required validation */
            $request = decryptData($request['response']);

            $data = Validator::make($request,[
                'date_type' => 'required',
                'app_unit_id' => 'required',
                'select_date' => 'sometimes|date|date_format:Y-m-d',
                'select_month' => 'sometimes|date_format:m',
                'select_year' => 'sometimes|date_format:Y',
            ],[
                'select_date.date_format' => 'The select date is not a valid date. Ex: 2000-01-01',
                'select_month.date_format' => 'The select date is not a valid date. Ex: 01',
                'select_year.date_format' => 'The select date is not a valid date. Ex: 2000'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            $response = [
                'booked' => $this->appointment_util->bookedDetails($request),
                'follow_ups' => $this->appointment_util->followUpsDetails($request),
                're_scheduled' => $this->appointment_util->rescheduleDetails($request),
                'cancelled' => $this->appointment_util->cancelDetails($request)
            ];
            return sendDataHelper('Appointments List.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
        
    }

    /* singlePatientAppList*/

    public function singlePatientAppList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* Response required validation */
            $request = decryptData($request['response']);

            $data = Validator::make($request,[
                'patient_id' => 'required',
                'app_unit_id' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $appp = Appointment::query();
            $appp->where('reg_type_patient_id', $request['patient_id']);
            $appp->where('app_unit_id', $request['app_unit_id']);          
            $response = $appp->latest()->paginate(2);

            $arr_res = [];
            $consultant = null;
            $doctor = null;
            $department = null;
            $reason = null;
            foreach ($response as $key => $value) {
                if(!$value->doc_id)
                {
                    $doctor = $value->doctor; 
                }else{
                    $doctor = Doctor::where('unit_id', auth()->user()->unit_id)->where('id', $value->doc_id)->first();
                    if($doctor)
                    {
                        $doctor = 'Dr. '.$doctor->first_name.' '.$doctor->first_last;
                    } 
                }

                if($value->referred_by)
                {
                    $refer = Doctor::where('unit_id', auth()->user()->unit_id)->where('id', $value->referred_by)->first();
                    if($refer)
                    {
                        $consultant = 'Dr. '.$refer->first_name.' '.$refer->first_last;
                    } 
                }
                if($value->dept_id)
                {
                    $dept = Department::where('created_unit_id', auth()->user()->unit_id)->where('id', $value->dept_id)->first();
                    if($dept)
                    {
                        $department = $dept->description;
                    }
                }
                if($value->app_reason_id)
                {
                    $reas = AppointmentReason::where('created_unit_id', auth()->user()->unit_id)->where('id', $value->app_reason_id)->first();
                    if($reas)
                    {
                        $reason = $reas->description;
                    }
                }

                $response[$key] =[
                    'appointment_id' => $value->id,
                    'appointment_date' => $value->appointment_date,
                    'consultant' => $consultant, 
                    'department' => $department,
                    'doctor' => $doctor,
                    'reason' => $value->reason,
                    'department' => $department
                ];
                
            }
            return sendDataHelper('Patient appointment list.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Appointment patient wait book pagination list */
    public function appPatientWaitBookPagList(Request $request)
    {
        $wait = true;
        return self::appPaginationList($request, $wait);
    }

    /* Appointment patient book pagination list */
    public function appPatientBookPaginationList(Request $request)
    {
        $wait = false;
        return self::appPaginationList($request, $wait);
    }
        /* Appointment patient book pagination list */
    public function appPaginationList($request, $wait)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/


            $data = Validator::make($request,[
                'from_date' => 'required',
                'to_date' => 'required'
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $response = [];
            $from_date = date('Y-m-d', strtotime($request['from_date']) );
            $to_date = date('Y-m-d', strtotime($request['to_date']) );
            
            $query = Appointment::query();
            
            if(strtotime($from_date)  === strtotime($request['to_date']))
            {
                $query->whereDate('appointment_date', $from_date);
            }else{
                $query->whereBetween('appointment_date', [$from_date, $to_date]);
            }
            
            $query->with('appointment_status')->has('appointment_status');
            $query->with('appointment_reason');
            $query->with('appointment_type')->has('appointment_type');
            $query->with('doctor_detail');
            $query->with('dept_detail');
            $query->with('app_doc_slot.time_slot');

            $query->where('is_cancel', 0);
            if($wait == false)
            {
                $query->where('visit_wait', false); 
                // $query->where('visit_mark', true);
            }else{
                $query->where('visit_wait', true);            
                $query->where('visit_mark', false);
            }
            
            $query->where('app_unit_id', auth_unit_id());
            $query->orderBy('appointment_date', 'desc');
            
            // $request['page'] = 10;
            $per_page = 10;
            $page = $request['page'] ?? 1;
            $total = $query->count();

            $result = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
            if(count($result) > 0)
            {
                $appData = [];
                $single = 0;
                $arr = [];
                $return_app_id = 0;
                foreach ($result as $k => $app) {
                    if( $k && strtotime($app->appointment_date) != $single || $k == 0 && $return_app_id != $app->id)
                    {
                        $arr = $this->appointment_util->appPatientBookPaginationList($app->appointment_date, $result);
                        $response[date('d F, Y', strtotime($app->appointment_date))] = $arr;
                    }
                }
            }
            $dataRes =  [
                'result' => $response,
                'total' => $total,
                'page' => $page,
                'last_page' => ceil($total / $per_page),
                'per_page' => $per_page
            ];
            return sendDataHelper('Appointment list view.', $dataRes, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Patient visit wait */
    public function patientVisitWait(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            /* Step zero */
            $data = Validator::make($request,[
                'appointment_id' => 'required',
                'app_unit_id' => 'required',
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
            
            $app = Appointment::where('id', $request['appointment_id'])->where('app_unit_id', $request['app_unit_id'])->first();
            if($app)
            {
                $app->visit_wait = true;
                $app->update();
                $app = Appointment::where('id', $request['appointment_id'])->where('app_unit_id', $request['app_unit_id'])->first();
                $response = [
                    'appointment_id' => $app->id,
                    'appointment_date' => $app->appointment_date,
                    'vist_wait' => true
                ];
                DB::commit();
                return sendDataHelper('Patient waiting for doctor.', $response, $code = 200);
            }    
            return sendErrorHelper('Record not found.', [], 404);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}