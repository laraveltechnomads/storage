<?php

namespace App\Utils\Patient;

use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Patients\Appointment;

Class CoupleUtil
{
    /* Step zero */
    public function regTypeValidStep($request)
    {
        $data = Validator::make($request,[
            'contact_no' => 'numeric|digits_between:10,16',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'email_address' => 'email|unique:registrations|min:1|max:90'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }

        if(@$request['date_of_birth'])
        {
            $data = Validator::make($request,[
                'date_of_birth' => 'sometimes|date|date_format:Y-m-d'
            ],[
                'date_of_birth.date' => 'The date of birth is not a valid date. Ex: 1990-01-01'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
        }
    }
    
    /* reg Valid Step One*/
    public function regUpdateValidStep1($request)
    {
        if(@$request['registration_number'])
        {
            $data = Validator::make($request,[
                'registration_number' => 'exists:registrations,id',
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
        }

        $data = Validator::make($request,[
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|exists:genders,id'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }

        $data = Validator::make($request,[
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|min:1|max:90',
            'identity_proof' => 'required',
            'identity_proof_no' => 'required'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }

        if(@$request['date_of_birth'])
        {
            $data = Validator::make($request,[
                'date_of_birth' => 'sometimes|date|date_format:Y-m-d'
            ],[
                'date_of_birth.date' => 'The date of birth is not a valid date. Ex: 1990-01-01'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
        }

        if(@$request['registration_number'] && @$request['email_address']){

            $Registration = Registration::where('id', $request['registration_number'])->where('email_address', $request['email_address'])->first();   
            if($Registration)
            {
            }else{
                $data = Validator::make($request,[
                    'email_address' => 'email|unique:registrations,email_address'
                ]);

                if($data->fails()){
                    return sendError($data->errors()->first(), [], 422);
                }
            }
        }else{
            $data = Validator::make($request,[
                'email_address' => 'email|unique:registrations,email_address'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
        }

        if(@$request['registration_number'] && @$request['contact_no']){

            $Registration = Registration::where('id', $request['registration_number'])->where('contact_no', $request['contact_no'])->first();   
            if($Registration)
            {
            }else{
                $data = Validator::make($request,[
                    'contact_no' => 'unique:registrations,contact_no'
                ]);

                if($data->fails()){
                    return sendError($data->errors()->first(), [], 422);
                }
            }
        }else{
            $data = Validator::make($request,[
                'contact_no' => 'unique:registrations,contact_no'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }
        }
    }

    /* reg Valid Step Two*/
    public function regValidStepTwo($request)
    {
        $data = Validator::make($request,[
            'registration_number' => 'required|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'source_reference' => 'required|min:1|max:100'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    /* reg Valid Step Three*/
    public function regValidStepThree($request)
    {
        $data = Validator::make($request,[
            'registration_number' => 'required|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'country' => 'required',
            'zip_code' => 'numeric'
        ]);
 
        if($data->fails()){
            return sendErrorHelper($data->errors()->first(), [], 422);
        }
    }

    /* reg Valid Step Four*/
    public function regValidStepFour($request)
    {
        $data = Validator::make($request,[
            'registration_number' => 'required|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'patient_source' => 'required'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    /*  Store reg Step Zero */
    public function registrationStep($request)
    {
        DB::beginTransaction();
        try
        {  
            $error = $this->regTypeValidStep($request);
            if($error)
            {
                return $error;
            }

            
            
            if(@$request['registration_number'])
            {
                $Registration = Registration::where('id', $request['registration_number'])->first();
            }else{
                $Registration = new Registration;
            }
            
            $Registration->patient_category_id = PatientCategory::where('reg_code', $request['registration_type'])->value('id');
            $Registration->registration_type = $request['registration_type'];
            if(@$request['first_name'])
            {
                $Registration->first_name = $request['first_name'];
            }
            if(@$request['middle_name'])
            {
                $Registration->middle_name = $request['middle_name'];
            }
            if(@$request['last_name'])
            {
                $Registration->last_name = $request['last_name'];    
            }
            if(@$request['contact_no'])
            {
                $Registration->contact_no = $request['contact_no'];
            }
            if(@$request['email_address'])
            {
                $Registration->email_address = $request['email_address'];
            }
            if(@$request['date_of_birth'])
            {
                $Registration->date_of_birth = $request['date_of_birth'];
            }
            if(@$request['reference_details'])
            {
                $Registration->reference_details = $request['reference_details'];
            }            
            if(@$request['doctor'])
            {
                $Registration->doctor = $request['doctor'];
            }
            if(@$request['reason'])
            {
                $Registration->reason = $request['reason'];
            }            
            
            if(!$Registration->registration_date)
            {
                $Registration->registration_date = date('Y-m-d');
            }

            $Registration->patientUnitId =  auth_unit_id();
            $Registration->save();

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
            if(@$request['doctor'])
            {
                $app->doctor = $request['doctor'];
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
            $app->app_unit_id = auth_unit_id();
            $app->app_type_id = 1;
            $app->save();

            DB::commit();
            if($Registration)
            {
                $Registration = Registration::where('id', $Registration->id)->first();
                $Registration['step'] = $request['step'];
                $Registration['registration_number'] = $Registration->id;

                if(@$app)
                {
                    $Appointment = Appointment::find($app->id);
                    if($Appointment)
                    {
                        $Registration['appointment_id'] = $Appointment->id;
                        $Appointment->reg_type_patient_id = $Registration->id;
                        $Appointment->update();
                    }
                }

                return sendDataHelper('Couple Appointment Data Successfully Done.', $Registration->toArray(), $code = 200);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 500);
        }
    }

    /* Store reg step One ( Personal Information )*/ 
    public function registrationUpdateStep1($request, $datareq)
    {
        DB::beginTransaction();
        try
        {  
            $error = $this->regUpdateValidStep1($request);
            if($error)
            {
                return $error;
            }

            if(@$request['registration_number'])
            {
                $check_cont = Registration::where('id', $request['registration_number'])->whereNotIn('contact_no', [@$request['contact_no']])->first();
                if($check_cont)
                {
                    return sendError('The contact no. has already been taken.', [], 422);
                }

                $check_email = Registration::where('id', $request['registration_number'])->whereNotIn('email_address', [@$request['email_address']])->first();
                if($check_email)
                {
                    return sendError('The email address has already been taken.', [], 422);
                }

                $Registration = Registration::where('id', $request['registration_number'])->first();
                if(@$request['contact_no'])
                {
                    $Registration->contact_no = $request['contact_no'];
                }
                if(@$request['email_address'])
                {
                    $Registration->email_address = $request['email_address'];
                }
                $proof_file = $Registration['identity_file'];
            }else{
                $Registration = new Registration;
                if(@$request['contact_no'])
                {
                    $Registration->contact_no = $request['contact_no'];
                }
                if(@$request['email_address'])
                {
                    $Registration->email_address = $request['email_address'];
                }
            }

            $Registration->patientUnitId =  auth_unit_id();
            
            if (@$datareq['profile_image']) {
                $proof_file = uploadFile($datareq['profile_image'], patients_profile_dir(), 'p');
                $Registration->profile_image = $proof_file;
                // $Registration->profile_image = $datareq['profile_image'];
            }

            if(@$datareq['profile_image_64'])
            {
                $proof_file = convertBase64($datareq['profile_image_64'], patients_profile_dir(), 'p');
                $Registration->profile_image = $proof_file;
            }
    
            if (@$datareq['identity_file']) {
                $proof_file = uploadFile($datareq['identity_file'], patients_file_dir(), 'p_f');
                $Registration->identity_file = $proof_file;
            }
            if(@$request['registration_type'])
            {
                $Registration->registration_type = $request['registration_type'];
            }            
            if(@$request['first_name'])
            {
                $Registration->first_name = $request['first_name'];
            }

            if(@$request['middle_name'])
            {
                $Registration->middle_name = $request['middle_name'];
            }
            if(@$request['last_name'])
            {
                $Registration->last_name = $request['last_name'];
            }
            
            $Registration->gender = 2;
            
            if(@$request['date_of_birth'])
            {
                $Registration->date_of_birth = $request['date_of_birth'];
            }
            if(@$request['age'])
            {
                $Registration->age =  $request['age'];
            }
            if(@$request['identity_proof'])
            {
                $Registration->identity_proof =  $request['identity_proof'];
            }
            if(@$request['identity_proof_no'])
            {
                $Registration->identity_proof_no =  $request['identity_proof_no'];
            }
            $Registration->patient_category_id = PatientCategory::where('reg_code', $request['registration_type'])->value('id');
            $Registration->added_by = auth()->user()->id;
            $Registration->added_on = strtotime(now_date_time() );
            $Registration->added_date_time = strtotime(now_date_time() );
            $Registration->updated_by = auth()->user()->id;
            $Registration->updated_on = strtotime(now_date_time() );
            $Registration->updated_date_time = strtotime(now_date_time() );
            $Registration->added_windows_login_name = strtotime(now_date_time() );
            $Registration->updated_windows_login_name = strtotime(now_date_time() );
            $Registration->save();
            
            if($Registration)
            {
                $coupleReg = CoupleRegistration::firstOrNew(['registration_number' => $Registration->id]);
                $coupleReg->unit_id = auth_unit_id();
                $coupleReg->registration_number = $Registration->id;
                $coupleReg->female_patient_id = $Registration->id;
                $coupleReg->female_patient_unit_id = auth_unit_id();
                $coupleReg->registration_date = now_date();
                $coupleReg->status = 1;
                $coupleReg->added_by = auth()->user()->id;
                $coupleReg->added_on = strtotime(now_date_time() );
                $coupleReg->updated_by = auth()->user()->id;
                $coupleReg->updated_on = strtotime(now_date_time() );
                $coupleReg->added_windows_login_name = strtotime(now_date_time() );
                $coupleReg->updated_windows_login_name = strtotime(now_date_time() );
                $coupleReg->synchronized = 1;
                $coupleReg->save();

                if(@$request['appointment_id'])
                {
                    $Appointment = Appointment::find($request['appointment_id']);
                    $Appointment->reg_type_patient_id = $Registration->id;
                    $Appointment->update();
                }

                DB::commit();
                $Registration = Registration::where('id', $Registration->id)->first();
                $Registration['step'] = $request['step'];
                $Registration['registration_number'] = $Registration->id;
                return sendDataHelper('Couple Personal Information Successfully Updated.', $Registration->toArray(), $code = 200);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Store reg step Two  ( Referral & Additional Information )*/
    public function regUpdateStepTwo($request)
    {
        DB::beginTransaction();
        try
        {  
            $error = $this->regValidStepTwo($request);
            if($error)
            {
                return $error;
            }

            $Registration = Registration::where('id', $request['registration_number'])->first();

            if(@$request['source_reference'])
            {
                $Registration->source_reference = $request['source_reference'];
            }
            if(@$request['reference_details'])
            {
                $Registration->reference_details = $request['reference_details'];
            }
            if(@$request['referral_doctor'])
            {
                $Registration->referral_doctor = $request['referral_doctor'];
            }
            if(@$request['remark'])
            {
                $Registration->remark = $request['remark'];
            }
            if(@$request['marital_status'])
            {
                $Registration->marital_status = $request['marital_status'];
            }
            if(@$request['blood_group'])
            {
                $Registration->blood_group = $request['blood_group'];
            }
            if(@$request['nationality'])
            {
                $Registration->nationality = $request['nationality'];
            }
            if(@$request['ethnicity'])
            {
                $Registration->ethnicity = $request['ethnicity'];
            }
            if(@$request['religion'])
            {
                $Registration->religion = $request['religion'];
            }
            if(@$request['education'])
            {
                $Registration->education = $request['education'];
            }
            if(@$request['occuption'])
            {
                $Registration->occuption = $request['occuption'];
            }
            if(@$request['married_since'])
            {
                $Registration->married_since = $request['married_since'];
            }
            if(@$request['existing_children'])
            {
                $Registration->existing_children = $request['existing_children'];
            }
            if(@$request['family'])
            {
                $Registration->family = $request['family'];
            }

            $Registration->update();
                        
            DB::commit();
            $Registration = Registration::where('id', $Registration->id)->first();
            $Registration['step'] = $request['step'];
            $Registration['registration_number'] = $Registration->id;
            return sendDataHelper('Couple  Referral & Additional Information Successfully Updated.', $Registration->toArray(), $code = 200);
            
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Store reg step Three   ( Permanent Address ) */
    public function regStoreStepThree($request)
    {
        DB::beginTransaction();
        try
        {  
            $error = $this->regValidStepThree($request);
            if($error)  {  return $error; }

            $Registration = Registration::where('id', $request['registration_number'])->first();
            if(@$request['address_line_1'])
            {
                $Registration->address_line_1 = $request['address_line_1'];
            }
            if(@$request['address_line_2'])
            {
                $Registration->address_line_2 = $request['address_line_2'];
            }
            if(@$request['landmark'])
            {
                $Registration->landmark = $request['landmark'];
            }
            if(@$request['country'])
            {
                $Registration->country = $request['country'];
            }
            if(@$request['state'])
            {
                $Registration->state = $request['state'];
            }
            if(@$request['city'])
            {
                $Registration->city = $request['city'];
            }
            if(@$request['zip_code'])
            {
                $Registration->zip_code = $request['zip_code'];
            }
            
            $Registration->same_for_partner = @$request['same_for_partner'] ? true : false;
            $Registration->for_communication = @$request['for_communication'] ? true : false;
            $Registration->notify_me = @$request['notify_me'] ? true : false;

            $Registration->update();
                        
            DB::commit();
            $Registration = Registration::where('id', $Registration->id)->first();
            $Registration['step'] = $request['step'];
            $Registration['registration_number'] = $Registration->id;
            return sendDataHelper('Couple Permanent Address Successfully Updated.', $Registration->toArray(), $code = 200);
            
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Store reg step Three   ( Sponser Information ) */
    public function regStoreStepFour($request)
    {
            $error = $this->regValidStepFour($request);
            if($error)
            {
                return $error;
            }

            $Registration = Registration::where('id', $request['registration_number'])->first();
            
            if(@$request['patient_source'])
            {
                $Registration->patient_source = $request['patient_source'];
            }
            if(@$request['company_name'])
            {
                $Registration->company_name = $request['company_name'];
            }
            if(@$request['associated_company'])
            {
                $Registration->associated_company = $request['associated_company'];
            }
            if(@$request['reference_no'])
            {
                $Registration->reference_no = $request['reference_no'];
            }
            if(@$request['tarrif_name'])
            {
                $Registration->tarrif_name = $request['tarrif_name'];
            }
            $Registration->mrn_number = auth_unit_id().'/'.rand(1000, 9999).'/'.date('Y');
            $Registration->update();
            $Registration = Registration::where('id', $Registration->id)->first();
            $Registration['step'] = $request['step'];
            $Registration['registration_number'] = $Registration->id;
            return sendDataHelper('Couple Sponser Information Successfully Updated.', $Registration->toArray(), $code = 200);
            
    }
}