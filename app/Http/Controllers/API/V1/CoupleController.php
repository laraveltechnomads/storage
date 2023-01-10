<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\V1\Register\BabyRegistration;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;

class CoupleController extends Controller
{
    /* baby parent couple details */
    public function coupleDetails(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            
            $request = decryptData($request['response']); /* Dectrypt  **/

            $couple_details = CoupleRegistration::where('id', $request['couple_registration_number'])->first();
            if($couple_details && isClinic($couple_details->unit_id) && $couple_details->unit_id = auth()->user()->unit_id) 
            {
                $dataArray = null;
                $parents = null;
                $registration = Registration::find($couple_details->female_patient_id);
                if($registration)
                {  
                    $parents['couple_registration_number'] = $couple_details->id;
                    $parents['mother_full_name'] = $registration->first_name.' '.$registration->middle_name.' '.$registration->last_name;
                    $parents['mother_mrn_number'] = $registration->mrn_number ?? null;
                    $parents['mother_email_address'] = $registration->email_address ?? "-";
                    $parents['mother_age'] = $registration->age.' years';
                    $parents['mother_contact_no'] = $registration->contact_no ?? "-";
                    $parents['mother_date_of_birth'] = date('d/m/Y', strtotime($registration->date_of_birth) ) ?? "-";
                    
                    $couple_reg = CoupleRegistration::where('unit_id', auth()->user()->unit_id)->where('female_patient_id', $registration->id)->first();
                    $partner = Registration::where('id', $couple_reg->male_patient_id)->first();

                    $parents['father_full_name'] = $partner ? $partner->first_name.' '.$partner->middle_name.' '.$partner->last_name :  "-";
                    $parents['father_mrn_number'] = $partner ? $partner->mrn_number :  null;
                    $parents['father_email_address'] = $partner ? $partner->email_address : "-";
                    $parents['father_age'] = $partner ? $partner->age.' years' : "-";
                    $parents['father_contact_no'] = $partner ? $partner->contact_no : "-";
                    $parents['father_date_of_birth'] = $partner ? date('d/m/Y', strtotime($partner->date_of_birth) ) : "-";
                    $parents['father_profile_image'] = $partner ? $partner->profile_image : null;
                    $parents['mother_profile_image'] = $registration ? $registration->profile_image : "-";
                    
                    return sendDataHelper('Parent details.', $parents, $code = 200);
                }
            }
            return sendErrorHelper('Record not found.', [], 404);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}