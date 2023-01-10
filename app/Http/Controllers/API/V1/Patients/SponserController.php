<?php

namespace App\Http\Controllers\API\V1\Patients;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\Master\Specialization;
use App\Models\API\V1\Master\SubSpecialization;
use App\Models\API\V1\Patients\CompanyMaster;
use App\Models\API\V1\Patients\PatientSource;
use App\Models\API\V1\Patients\PatientSponsorDetail;
use App\Models\API\V1\Patients\TariffMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SponserController extends Controller
{
    //patient source
    public function patientSource(){
        $patient_list = PatientSource::where('status',1)->get(['id','unit_id','code','description','status']);
        return sendDataHelper('All Patient Source details.', $patient_list, 200);
    }
    //company list
    public function companyList(){
        $company_list = CompanyMaster::where('status',1)->get(['comp_unit_id','comp_code','description','status']);
        return sendDataHelper('All Insurance Company list details.', $company_list, 200);
    }

    public function coupleSponser(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'patient_source_id' => 'required',
            'company_id' => 'required',
            'patient_unit_id' => 'required',
            'tariff_id' => 'required',
            'patient_id' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                $input = [
                    'patient_id' => $data['patient_id'],
                    'patient_unit_id' => $data['patient_unit_id'],
                    'patient_source_id' => $data['patient_source_id'],
                    'reference_no' => @$data['reference_no'],
                    'associated_company_id' => @$data['associated_company_id'],
                    'company_id' => $data['company_id'],
                    'tariff_id' => $data['tariff_id'],
                    'status' => 1
                ];
                PatientSponsorDetail::create($input);
                DB::commit();
                return sendDataHelper('Patient sponsor information store done.', $input, $code = 200);
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
}
