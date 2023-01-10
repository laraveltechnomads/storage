<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Client\ModeOfPayment;
use App\Models\API\V1\Clinic\ClinicMaster;
use App\Models\API\V1\Master\Specialization;
use App\Models\API\V1\Master\Unit;
use App\Models\Client\ClientLoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Utils\ClientUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    protected $clientUtil;
    public function __construct(ClientUtil $clientUtil)
    {
        $this->clientUtil = $clientUtil;
    }
    //Client details show
    public function details(Request $request)
    {
        $client = auth()->user();
        $decryptMessage = response([
            'success' => true,
            'message' => 'Client Profile Details',
            'data' => $client->toarray()
        ], config('constants.validResponse.statusCode')); 
        return encryptData($decryptMessage);
    }

    /* login History **/
    public function loginHistory(Request $request)
    {
        if($request->user()->tokenCan('type:1'))
        {
            $loginhistory = ClientLoginhistory::has('client')->select('ip_address', 'browser_name', 'created_at')->get();
            $decryptMessage = response([
                'success' => true,
                'message' => 'Client Profile Details',
                'data' => $loginhistory->toarray()
            ], config('constants.validResponse.statusCode')); 

            return encryptData($decryptMessage);
        }
        $decryptMessage =  dataNotFound('Permission Denied.');
        return encryptData($decryptMessage);
    } 

    /** Patieny Categories list*/
    public function patientCategoriesList(Request $request)
    {
       
        $PatientCategory = PatientCategory::select('id','reg_code', 'description', 'status')->whereStatus(1)->get();
        return response([
                 'success' => true,
                 'message' => 'Patients Categories List',
                 'data' => $PatientCategory->toarray()
             ], config('constants.validResponse.statusCode')); 
        // return encryptData($decryptMessage);
    }

    /* Users List*/
    public function userDetails(Request $request)
    {
        $users =  User::get();
        return response([
            'success' => true,
            'message' => 'Users List',
            'data' => $users->toArray()
        ], config('constants.validResponse.statusCode')); 
    }
    public function masterEdit(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required',
        ]);
        if($validator->fails()){
            $return = sendErrorHelper('Validation Error', $validator->errors()->first());
            return response()->json($return);
        }
        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'id' => 'required',
            'clinic_name' => 'required|unique:admin_db.units',
            'clinic_code'=>[
                'required',
                Rule::unique('units','code')->ignore($data['id']),
            ],
            'resi_no_country_code' => 'required',
            'contact_no'=>[
                'required',
                Rule::unique('units','contact_no')->ignore($data['id']),
            ],
            'mobile_country_code' => 'required',
            'mobile_no'=>[
                'required',
                Rule::unique('units','mobile_no')->ignore($data['id']),
            ]
        ]);
        if($validator->fails()){
            $return = sendErrorHelper('Validation Error', $validator->errors()->first());
            return response()->json($return);
        }else{
            try{
                DB::beginTransaction();
                $clinic = Unit::find($data['id']);
                if($clinic){
                    $input['description'] = $data['clinic_name'];
                    $input['code'] = $data['clinic_code'];
                    $input['resi_no_country_code'] = $data['resi_no_country_code'];
                    $input['contact_no'] = $data['contact_no'];
                    $input['mobile_country_code'] = $data['mobile_country_code'];
                    $input['mobile_no'] = $data['mobile_no'];
                    if(@$data['email']){
                        $input['email'] = $data['email'];
                    }
                    if(@$data['address_line1']){
                        $input['address_line1'] = $data['address_line1'];
                    }
                    if(@$data['address_line2']){
                        $input['address_line2'] = $data['address_line2'];
                    }
                    if(@$data['address_line3']){
                        $input['address_line3'] = $data['address_line3'];
                    }
                    if(@$data['country_id']){
                        $input['country_id'] = $data['country_id'];
                    }
                    if(@$data['state_id']){
                        $input['state_id'] = $data['state_id'];
                    }
                    if(@$data['city_id']){
                        $input['city_id'] = $data['city_id'];
                    }
                    if(@$data['area']){
                        $input['area'] = $data['area'];
                    }
                    if(@$data['pincode']){
                        $input['pincode'] = $data['pincode'];
                    }
                    if(@$data['database_name']){
                        $input['database_name'] = $data['database_name'];
                    }
                    if(@$data['gstn_no']){
                        $input['gstn_no'] = $data['gstn_no'];
                    }
                    if(@$data['pharmacy_license_no']){
                        $input['pharmacy_license_no'] = $data['pharmacy_license_no'];
                    }
                    if(@$data['fax_no']){
                        $input['fax_no'] = $data['fax_no'];
                    }
                    if(@$data['cin_no']){
                        $input['cin_no'] = $data['cin_no'];
                    }
                    if(@$data['pan_no']){
                        $input['pan_no'] = $data['pan_no'];
                    }
                    if(@$data['department']){
                        $input['department'] = json_encode(@$data['department']);
                    }
                    $clinic->update($input);
                    $clinic_edit = [
                        'id' => $data['id'],
                        'description' => $data['clinic_name'],
                        'code' => $data['clinic_code'],
                        'resi_no_country_code' => $data['resi_no_country_code'],
                        'contact_no' => $data['contact_no'],
                        'mobile_country_code' => $data['mobile_country_code'],
                        'mobile_no' => $data['mobile_no'],
                        'email' => @$data['email'],
                        'address_line1' => @$data['address_line1'],
                        'address_line2' => @$data['address_line2'],
                        'address_line3' => @$data['address_line3'],
                        'country_id' => @$data['country_id'],
                        'state_id' => @$data['state_id'],
                        'city_id' => @$data['city_id'],
                        'area' => @$data['area'],
                        'pincode' => @$data['pincode'],
                        'database_name' => @$data['database_name'],
                        'gstn_no' => @$data['gstn_no'],
                        'pharmacy_license_no' => @$data['pharmacy_license_no'],
                        'fax_no' => @$data['fax_no'],
                        'cin_no' => @$data['cin_no'],
                        'pan_no' => @$data['pan_no'],
                        'department' => json_encode(@$data['department']),
                    ];
                    DB::commit();
                    return sendDataHelper('ClinicMaster data edit successfully!.', $clinic_edit, $code = 200);
                }else{
                   return sendErrorHelper('Please send valid clinic id!.', []);  
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
}