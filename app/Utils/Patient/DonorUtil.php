<?php

namespace App\Utils\Patient;

use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\DonorRegistration;
use App\Models\API\V1\Register\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
Class DonorUtil
{
    /* reg Valid Step One*/
    public function regDonorValidStepOne($request, $datareq)
    {
        $data = Validator::make($request,[
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'email_address' => 'email|min:1|max:90',
            'gender' => 'required|exists:genders,id',
            'age' => 'required|numeric'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
        
        $data = Validator::make($request,[
            'contact_no' => 'required|numeric|digits_between:10,16',
            'identity_proof' => 'required',
            'identity_proof_no' => 'required'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }

        if($request['date_of_birth'])
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
    public function regDonorValidStepTwo($request)
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
    public function regDonorValidStepThree($request)
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
    public function regDonorValidStepFour($request)
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

    /* reg steop one donor details */
    public function regStepOne($request, $datareq)
    {
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

        if (@$datareq['profile_image']) {
            $proof_file = uploadFile($datareq['profile_image'], patients_profile_dir(), 'p');
            $Registration->profile_image = $proof_file;
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
        if(@$request['gender'])
        {
            $Registration->gender = $request['gender'];
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

        $gender = null;
        if(@$request['gender'])
        {
            $gender = ($request['gender'] == 1) ? 'H' : 'W';
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
            $Registration = Registration::where('id', $Registration->id)->first();
            
            $donorReg = DonorRegistration::firstOrNew(['registration_number' => $Registration->id]);
            $donorReg->patient_category_id = PatientCategory::where('reg_code', $request['registration_type'])->value('id');
            $donorReg->registration_number = $Registration->id;
            $donorReg->mrn_number = $Registration->mrn_number;
            $donorReg->unit_id = auth()->user()->unit_id;
            $donorReg->updated_by = auth()->user()->id;
            $donorReg->updated_on = strtotime(now_date_time() );
            $donorReg->added_windows_login_name = strtotime(now_date_time() );
            $donorReg->updated_windows_login_name = strtotime(now_date_time() );
            $donorReg->save();
            
            $Registration->registration_number = $Registration->id;
            $Registration['step'] = $request['step'];

            if(@$request['appointment_id'])
            {
                $Appointment = Appointment::find($request['appointment_id']);
                if($Appointment)
                {
                    $Appointment->reg_type_patient_id = $Registration->id;
                    $Appointment->update();
                }
                
            }
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Personal Information Successfully Updated.', $Registration->toArray(), 200);
        }
    }

    /* Store reg step Two  ( Additional Information )*/
    public function regStepTwo($request)
    {            
        $Registration = Registration::where('id', $request['registration_number'])->first();

        if(@$request['source_reference'])
        {
            $Registration->source_reference = $request['source_reference'];
        }
        if(@$request['doctor'])
        {
            $Registration->doctor = $request['doctor'];
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
                    
        $Registration = Registration::where('id', $Registration->id)->first();
        $Registration['step'] = $request['step'];
        $Registration['registration_number'] = $Registration->id;
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Referral & Additional Information Successfully Updated.', $Registration->toArray(), $code = 200);
    }

    /* Store reg step Three   ( Permanent Address ) */
    public function regStepThree($request)
    {
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
    
            $Registration->city = $request['city'];
        
        if(@$request['zip_code'])
        {
            $Registration->zip_code = $request['zip_code'];
        }
        
        $Registration->for_communication = @$request['for_communication'] ? true : false;
        
        $Registration->update();
                    
        $Registration = Registration::where('id', $Registration->id)->first();
        $Registration['step'] = $request['step'];
        $Registration['registration_number'] = $Registration->id;
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Permanent Address Successfully Updated.', $Registration->toArray(), $code = 200);
    }

    /* Store reg step Three   ( Sponser Information ) */
    public function regStepFour($request)
    {
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
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Sponser Information Successfully Updated.', $Registration->toArray(), $code = 200);
            
    }
}