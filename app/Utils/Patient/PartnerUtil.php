<?php

namespace App\Utils\Patient;

use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
Class PartnerUtil
{
    /* reg Valid Step One*/
    public function regPartnerValidStepOne($request, $datareq)
    {
        $data = Validator::make($request,[
            'registration_number' => 'sometimes|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
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
    }

    /* reg validation step Two */
    public function regPartnerValidStepTwo($request, $datareq)
    {
        $data = Validator::make($request,[
            'registration_number' => 'required|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code'
        ]);
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    /* reg validation step Three */
    public function regPartnerValidStepThree($request, $datareq)
    {
        $data = Validator::make($request,[
            'registration_number' => 'required|exists:registrations,id',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'country' => 'required'
        ]);
 
        if($data->fails()){
            return sendErrorHelper($data->errors()->first(), [], 422);
        }
 
        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    public function regStepOne($request, $datareq)
    {
        $reg_id = 0;
        $id = 0;
        $couple_reg = null;
        $reg = Registration::where('patientUnitId', auth()->user()->unit_id)->where('id', $request['registration_number'])->first();
        if($reg)
        {
            $reg_id = $reg->id;
            $couple_reg = CoupleRegistration::where('unit_id', auth()->user()->unit_id)->where('female_patient_id', $reg->id)->first();
        
            if($couple_reg && $couple_reg->male_patient_id)
            {
                $id = $couple_reg->male_patient_id;
            }
        }
        
        $partner = Registration::firstOrNew(['id' => $id]);
        $partner->patientUnitId =  auth()->user()->unit_id;
        $partner->patient_category_id = PatientCategory::where('reg_code', $request['registration_type'])->value('id');
        if(@$request['registration_type'])
        {
            $partner->registration_type = $request['registration_type'];
        }

        if (@$datareq['profile_image']) {
            $proof_file = uploadFile($datareq['profile_image'], patients_profile_dir(), 'p');
            $partner->profile_image = $proof_file;
        }

        if(@$datareq['profile_image_64'])
        {
            $proof_file = convertBase64($datareq['profile_image_64'], patients_profile_dir(), 'p');
            $partner->profile_image = $proof_file;
        }

        if (@$datareq['identity_file']) {
            $proof_file = uploadFile($datareq['identity_file'], patients_file_dir(), 'p_f');
            $partner->identity_file = $proof_file;
        }

        if(@$request['first_name'])
        {
            $partner->first_name = $request['first_name'];
        }
        if(@$request['middle_name'])
        {
            $partner->middle_name = $request['middle_name'];
        }
        if(@$request['last_name'])
        {
            $partner->last_name = $request['last_name'];
        }
        
        $partner->gender = 1;
        
        if(@$request['contact_no'])
        {
            $partner->contact_no = $request['contact_no'];
        }
        if(@$request['email_address'])
        {
            $partner->email_address = $request['email_address'];
        }
        if(@$request['date_of_birth'])
        {
            $partner->date_of_birth = $request['date_of_birth'];
        }
        if(@$request['age'])
        {
            $partner->age = $request['age'];
        }
        if(@$request['identity_proof'])
        {
            $partner->identity_proof =  $request['identity_proof'];
        }
        if(@$request['identity_proof_no'])
        {
            $partner->identity_proof_no =  $request['identity_proof_no'];
        }        
        
        $partner->save();
        if($partner)
        {   
            $couple_reg = CoupleRegistration::where('unit_id', auth()->user()->unit_id)->where('female_patient_id', $reg->id)->first();
            if($couple_reg)
            {
                $couple_reg->male_patient_id = $partner->id;
                $couple_reg->male_patient_unit_id = auth()->user()->unit_id;
                $couple_reg->updated_by = auth()->user()->id;
                $couple_reg->updated_on = strtotime(now_date_time() );
                $couple_reg->added_windows_login_name = strtotime(now_date_time() );
                $couple_reg->updated_windows_login_name = strtotime(now_date_time() );
                $couple_reg->save();
            }
            
            if(@$request['appointment_id'])
            {
                $appointment = Appointment::find($request['appointment_id']);
                if($appointment)
                {
                    $appointment->reg_type_patient_id = $partner->id;
                    $appointment->update();
                }
            }
            $partner = Registration::find($partner->id);
            $partner['step'] = $request['step'];
         
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Personal Information Successfully Updated.', $partner->toArray(), 200);
        }
    }

    /* Store reg step Two  ( Referral & Additional Information )*/
    public function regStepTwo($request, $datareq)
    {
        $couple_reg = CoupleRegistration::where('unit_id', auth()->user()->unit_id)->where('female_patient_id', $request['registration_number'])->first();
        $partner = Registration::firstOrNew(['id' => $couple_reg->male_patient_id]);

        if(@$request['marital_status'])
        {
            $partner->marital_status = $request['marital_status'];
        }
        if(@$request['blood_group'])
        {
            $partner->blood_group = $request['blood_group'];
        }
        if(@$request['nationality'])
        {
            $partner->nationality = $request['nationality'];
        }
        if(@$request['ethnicity'])
        {
            $partner->ethnicity = $request['ethnicity'];
        }
        if(@$request['religion'])
        {
            $partner->religion = $request['religion'];
        }
        if(@$request['education'])
        {
            $partner->education = $request['education'];
        }
        if(@$request['occuption'])
        {
            $partner->occuption = $request['occuption'];
        }
        if(@$request['married_since'])
        {
            $partner->married_since = $request['married_since'];
        }
        if(@$request['existing_children'])
        {
            $partner->existing_children = $request['existing_children'];
        }
        if(@$request['family'])
        {
            $partner->family = $request['family'];
        }
        $partner->update();
        if($partner)
        {
            $partner_reg = Registration::where('id', $couple_reg->male_patient_id)->first();
            $partner_reg['step'] = $request['step'];
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Additional Information Details Successfully Updated.', $partner_reg->toArray(), 200);
        }   
    }

    /* Store reg step Three   ( Permanent Address ) */
    public function regStepThree($request, $datareq)
    {
        $couple_reg = CoupleRegistration::where('unit_id', auth()->user()->unit_id)->where('female_patient_id', $request['registration_number'])->first();
        $partner = Registration::firstOrNew(['id' => $couple_reg->male_patient_id]);
        if(@$request['address_line_1'])
        {
            $partner->address_line_1 = $request['address_line_1'];
        }
        if(@$request['address_line_2'])
        {
            $partner->address_line_2 = $request['address_line_2'];
        }
        if(@$request['landmark'])
        {
            $partner->landmark = $request['landmark'];
        }
        if(@$request['country'])
        {
            $partner->country = $request['country'];
        }
        if(@$request['state'])
        {
            $partner->state = $request['state'];
        }
        if(@$request['city'])
        {
            $partner->city = $request['city'];
        }
        if(@$request['zip_code'])
        {
            $partner->zip_code = $request['zip_code'];
        }
        
        $partner->same_for_partner = @$request['same_for_partner'] ? true : false;
        $partner->mrn_number = auth_unit_id().'/'.rand(1000, 9999).'/'.date('Y');
        $partner->update();
        if($partner)
        {
            $partner_reg = Registration::where('id', $couple_reg->male_patient_id)->first();
            $partner_reg['step'] = $request['step'];
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Permanent Address Successfully Updated.', $partner_reg->toArray(), $code = 200);
        }
    }
}