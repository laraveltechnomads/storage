<?php

namespace App\Http\Controllers\API\V1\Patients;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\V1\BabyController;
use App\Http\Controllers\API\V1\DonorController;
use App\Http\Controllers\API\V1\IndividualController;
use App\Http\Controllers\API\V1\PartnerController;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Register\BabyRegistration;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;
use App\Utils\API\RegisterUtil;
use App\Utils\Patient\AppointmentUtil;
use App\Utils\Patient\CoupleUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    protected $register_util;
    protected $couple_util;
    protected $appointment_util;

    public function __construct(RegisterUtil $register_util, CoupleUtil $couple_util, AppointmentUtil $appointment_util)
    {
        $this->register_util = $register_util;
        $this->couple_util = $couple_util;
        $this->appointment_util = $appointment_util;
    }
    
    /* 
        Patients register 
    */
    public function patientsRegister(Request $request, $reg_code)
    {   
        DB::beginTransaction();
        try {        
            $datareq = [];
            $request['identity_file'];
            if ($request->hasFile('identity_file')) 
            {
                $datareq['identity_file'] = $request['identity_file'];
            }
            
            if ($request->hasFile('profile_image')) 
            {
                $datareq['profile_image'] = $request['profile_image'];
            }else{
                if($request['profile_image'])
                {
                    if (strpos($request['profile_image'], 'base64') !== false) {
                        $datareq['profile_image_64'] = $request['profile_image'];
                    }
                }
            }

            if(respValid($request)) { return respValid($request); }  /* Response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            // $date = date('d-m-Y_H:i:s');
            // Storage::disk('local')->put('register'.$date.'.json', response()->json($request));
            // Storage::disk('cdn_local')->put('register_'.$date.'.json', response()->json($request));
            
            $patientTypes = config('constants.patientType');
            
            $couple = config('constants.patientType')[0];
            $partner = config('constants.patientType')[1];
            $baby = config('constants.patientType')[2];
            $donor = config('constants.patientType')[3];
            $individual = config('constants.patientType')[4];
            $anc = config('constants.patientType')[5];
            
            if($reg_code && $patientCategory = PatientCategory::whereIn('reg_code', $patientTypes)->where('reg_code', $reg_code)->first())
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
                    $error = $this->appointment_util->appointmentZero($request, $datareq);
                    if($error) { return $error; }

                    $appointment =  $this->appointment_util->regStepZero($request, $datareq);
                    DB::commit();
                    return $appointment;
                }

                if($patientCategory && $patientCategory->reg_code == $couple)
                {
                    if(@$request['step'] == 0)
                    {
                        $appointment = $coupleRegister = $this->couple_util->registrationStep($request);
                        DB::commit();
                        return $appointment;
                    }
                    elseif(@$request['step'] == 1)
                    {
                        $couple = $this->couple_util->registrationUpdateStep1($request, $datareq);
                        DB::commit();
                        return $couple;
                    }
                    elseif(@$request['step'] == 2)
                    {
                        $couple = $this->couple_util->regUpdateStepTwo($request);
                        DB::commit();
                        return $couple;
                    }
                    elseif(@$request['step'] == 3)
                    {
                        $couple = $this->couple_util->regStoreStepThree($request);
                        DB::commit();
                        return $couple;
                    }
                    elseif(@$request['step'] == 4)
                    {
                        $couple = $this->couple_util->regStoreStepFour($request);
                        DB::commit();
                        return $couple;
                    }
                }
                elseif($patientCategory && $patientCategory->reg_code == $partner)
                {
                    $appointment = PartnerController::registration($request, $datareq);
                    DB::commit();
                    return $appointment;
                }
                elseif($patientCategory && $patientCategory->reg_code == $baby)
                {
                    $appointment =  BabyController::registration($request, $datareq);
                    DB::commit();
                    return $appointment;
                }
                elseif($patientCategory && $patientCategory->reg_code == $individual)
                {
                    if(@$request['step'] == 0)
                    {
                        $appointment = AppointmentController::appointmentGet($request, $datareq);
                        DB::commit();
                        return $appointment;
                    }
                    $appointment = IndividualController::registration($request, $datareq);
                    DB::commit();
                    return $appointment;
                }
                elseif($patientCategory && $patientCategory->reg_code == $donor)
                {
                    $appointment = DonorController::registration($request, $datareq);
                    DB::commit();
                    return $appointment;
                }
                elseif($patientCategory && $patientCategory->reg_code == $anc)
                {
                    if(@$request['step'] == 0)
                    {
                        $appointment = AppointmentController::appointmentGet($request, $datareq);
                        DB::commit();
                        return $appointment;
                    }
                    $appointment = IndividualController::registration($request, $datareq);
                    DB::commit();
                    return $appointment;
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
    
    public function patientsDetailsSelected(Registration $registration)
    {
        try {
            $dataArray = null;
            if($registration->patientUnitId = auth()->user()->unit_id)
            {
                $clinic = Unit::where('id', $registration->patientUnitId)->first();
                $registration['registration_number'] = $registration->id;
                $dataArray = $registration;
                
                $dataArray['country_name'] = country_details($dataArray->country, 'name');
                $dataArray['state_name'] = state_details($dataArray->state, 'name');
                $dataArray['city_name'] = city_details($dataArray->city, 'name');

                $couple_id = 0;
                $couple = CoupleRegistration::where('female_patient_id', $registration->id)->first();
                if($couple)
                {
                    $couple_id = $couple->id;
                    $part_reg_id = $couple->male_patient_id;
                }
                
                $dataArray['partner_details'] = Registration::where('id', $part_reg_id)->get();    
                $dataArray['baby_details'] = BabyRegistration::where('couple_registration_number', $couple_id)->get();
                
                return sendDataHelper('Patient Details.', $dataArray->toArray(), $code = 200);
            }
            return sendErrorHelper('Record not found.', [], 404);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }    
}