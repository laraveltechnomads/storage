<?php

namespace App\Utils\Patient;

use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Patients\Appointment;
use App\Models\API\V1\Register\BabyRegistration;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\PartnerRegistration;
use App\Models\API\V1\Register\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
Class BabyUtil
{

    /* Step zero */
    public function appointmentZero($request)
    {
        $data = Validator::make($request,[
            'contact_no' => 'numeric|digits_between:10,16',
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'email_address' => 'email|min:1|max:90'
        ]);

        if($data->fails()){
            return sendError($data->errors()->first(), [], 422);
        }
    }

    /* reg Valid Step One*/
    public function regBabyValidStepOne($request, $datareq)
    {
        $data = Validator::make($request,[
            'registration_type' => 'required|exists:patient_categories,reg_code',
            'couple_registration_number' => 'required|exists:couple_registrations,id',
            'appointment_id' => 'required',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required',
            'birth_time' => 'required',
            'birth_weight' =>  'required',
            'weight_type' => 'required',
            'blood_group' => 'required',
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

    public function regStepOne($request, $datareq)
    {
        $couple_reg = CoupleRegistration::where('id', $request['couple_registration_number'])->whereStatus(1)->first();
        $baby = BabyRegistration::firstOrNew(['couple_registration_number' => $couple_reg->id]);
        $baby->patient_category_id = PatientCategory::where('reg_code', $request['registration_type'])->value('id');
        $baby->couple_registration_number = $couple_reg->id;
        $baby->patientUnitId = auth()->user()->unit_id;
        
        if(@$request['registration_type'])
        {
            $baby->registration_type = $request['registration_type'];
        }

       
        if (@$datareq['profile_image']) {
            $proof_file = uploadFile($datareq['profile_image'], patients_profile_dir(), 'p');
            $baby->profile_image = $proof_file;
        }

        if(@$datareq['profile_image_64'])
        {
            $proof_file = convertBase64($datareq['profile_image_64'], patients_profile_dir(), 'p');
            $baby->profile_image = $proof_file;
        }

        if (@$datareq['identity_file']) {
            $proof_file = uploadFile($datareq['identity_file'], patients_file_dir(), 'p_f');
            $baby->identity_file = $proof_file;
        }
        
        if(@$request['first_name'])
        {
            $baby->first_name = $request['first_name'];
        }
        if(@$request['middle_name'])
        {
            $baby->middle_name = $request['middle_name'];
        }
        if(@$request['last_name'])
        {
            $baby->last_name = $request['last_name'];
        }
        if(@$request['gender'])
        {
            $baby->gender = $request['gender'];
        }
        if(@$request['date_of_birth'])
        {
            $baby->date_of_birth = $request['date_of_birth'];
        }
        if(@$request['birth_time'])
        {
            $baby->birth_time = $request['birth_time'];
        }        
        if(@$request['identity_proof'])
        {
            $baby->identity_proof =  $request['identity_proof'];
        }
        if(@$request['identity_proof_no'])
        {
            $baby->identity_proof_no =  $request['identity_proof_no'];
        }
        $baby->mrn_number = auth_unit_id().'/'.rand(1000, 9999).'/'.date('Y');
        $baby->registration_date = date('Y-m-d');
        $baby->save();
        if($baby)
        {
            $baby_reg = BabyRegistration::where('id', $baby->id)->where('couple_registration_number', $couple_reg->id)->first();
            $baby_reg['step'] = @$request['step'];

            $reg = new Registration;
            $reg->patient_category_id = $baby_reg->patient_category_id;
            $reg->registration_type = $baby_reg->registration_type; 
            $reg->first_name = $baby_reg->first_name;
            $reg->middle_name = $baby_reg->middle_name;
            $reg->last_name = $baby_reg->last_name;
            $reg->contact_no = $baby_reg->contact_no;
            $reg->gender = $baby_reg->gender;
            $reg->date_of_birth = $baby_reg->date_of_birth;
            $reg->identity_proof = $baby_reg->identity_proof;
            $reg->identity_proof_no = $baby_reg->identity_proof_no;
            $reg->mrn_number = auth_unit_id().'/'.rand(1000, 9999).'/'.date('Y');
            $reg->save();
            
            if(@$request['appointment_id'])
            {
                $Appointment = Appointment::find($request['appointment_id']);
                $Appointment->reg_type_patient_id = $reg->id;
                $Appointment->update();
            }
            
            return sendDataHelper(Str::ucfirst($request['registration_type']).' Registration Successfully Updated.', $baby_reg->toArray(), 200);
        }
    }

    /*  Store reg Step Zero */
    public function regStepZero($request)
    {
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
            $app->reference_details = $request['referred_by'];
        }            
        if(@$request['doctor_id'])
        {
            $app->doc_id = $request['doctor_id'];
        }
        if(@$request['reason'])
        {
            $app->app_reason_id = 1;
        }            
        

        if(@$request['select_date'])
        { 
            $app->appointment_date = @$request['select_date'];
        }
        $app->app_unit_id = auth()->user()->unit_id;
        $app->app_type_id = 1;
        $app->save();
        
        $Appointment = Appointment::where('id', $app->id)->first();
        $Appointment['appointment_id'] = $Appointment->id; 
        $Appointment['step'] = $request['step'];
        // $Appointment['reg_id'] = $Appointment->reg_id;
        return sendDataHelper(Str::ucfirst($request['registration_type']).' Appointment data successfully submitted.', $Appointment->toArray(), $code = 200);
    }
}