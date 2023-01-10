<?php

namespace App\Utils\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

Class RegisterUtil
{
    /* Couple Registration */
    public function coupleRegValidation($request)
    {
        $request['email_address'] = Str::replace(' ','', $request['email_address']);
     
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }

    /* Partner Registration */
    public function partnerRegValidation($request)
    {
        $request['email_address'] = Str::replace(' ','', $request['email_address']);
        $request->registration_type;
        
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }

    /* Baby Registration */
    public function babyRegValidation($request)
    {
        $request['email_address'] = Str::replace(' ','', $request['email_address']);
        $request->registration_type;
        
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }

    /* Donor Registration */
    public function donorRegValidation($request)
    {
        $request['email_address'] = Str::replace(' ','', $request['email_address']);
        $request->registration_type;
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }

    /* ANC Registration */
    public function ancRegValidation($request)
    {
        $request['email_address'] = Str::replace(' ','', $request['email_address']);
        $request->registration_type;
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }

    /* Individual Registration */
    public function individualRegValidation($request)
    {
        $original = json_decode(decryptData($request['data']))->original;
        // $request['email_address'] = Str::replace(' ','', $request->email_address);
        // if($original->registration)
        // {
        //     $validation = Validator::make($original->registration,[
        //         'response' => 'required'
        //     ]);
        //     if($validation->fails()){
        //         $return = sendError('Validation Error', $validation->errors()->first());
        //         return response()->json($this->encryptData($return));
        //     }
        // }
        
        $request->validate([
            'registration_type' => 'required',
            'first_name' => 'required|min:2|max:50',
            'middle_name' => 'sometimes|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'gender' => 'required|min:1|max:10',
            'contact_no' => 'required|numeric|digits_between:10,16',
            'email_address' => 'required|email|unique:registrations|min:1|max:90',
            'date_of_birth' => 'required',
            'age' => 'required|min:1|max:4',
            'identity_proof' => 'required|min:1|max:100',
            'identity_proof_no' => 'required|min:1|max:50',
            'identity_file' => 'required',
            'source_reference' => 'required|min:1|max:100',
            'reference_details' => 'required|min:1|max:100',
            'referral_doctor' => 'required|min:1|max:100',
            'remark' => 'required|min:1|max:100',
            'marital_status' => 'required|min:1|max:20',
            'blood_group' => 'required|min:1|max:20',
            'nationality' => 'required|min:1|max:50',
            'ethnicity' => 'required|min:1|max:50',
            'religion' => 'required|min:1|max:50',
            'education' => 'required|min:1|max:20',
            'occuption' => 'required|min:1|max:20',
            'married_since' => 'required|min:1|max:20',
            'existing_children' => 'required|min:1|max:20',
            'family' => 'required|min:1|max:20',
            'address_line_1' => 'required|min:1|max:250',
            'address_line_2' => 'required|min:1|max:250',
            'landmark' => 'required|min:1|max:50',
            'country' => 'required|min:1|max:50',
            'state' => 'required|min:1|max:50',
            'city' => 'required|min:1|max:50',
            'zip_code' => 'required|min:1|max:10',
            // 'same_for_partner' => 'required',
            // 'for_communication' => 'required',
            // 'notify_me' => 'required',
            'patient_source' => 'required|min:1|max:100',
            'company_name' => 'required|min:1|max:200',
            'associated_company' => 'required|min:1|max:200',
            'reference_no' => 'required|min:1|max:100',
            'tarrif_name' => 'required|min:1|max:100'
        ],[
            'identity_file.required' => "Attach a File."
        ]);
    }
}