<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\V1\Client\AdvanceAgainstDetail;
use App\Models\API\V1\Client\AssCompanyTariffDetail;
use App\Models\API\V1\Client\BulkRateChange;
use App\Models\API\V1\Client\BulkRateChangeSpecialization;
use App\Models\API\V1\Client\BulkRateChangeTarrif;
use App\Models\API\V1\Client\CodeTypeMaster;
use App\Models\API\V1\Client\CompanyAddress;
use App\Models\API\V1\Client\CompanyAssociateMaster;
use App\Models\API\V1\Client\CompanyTypeMaster;
use App\Models\API\V1\Client\ConReasonMaster;
use App\Models\API\V1\Client\DoctorShare;
use App\Models\API\V1\Client\DoctorShareSpecialization;
use App\Models\API\V1\Client\ExpenseMaster;
use App\Models\API\V1\Client\ReasonOfRefundMaster;
use App\Models\API\V1\Client\ServiceClassRateDetail;
use App\Models\API\V1\Client\ServiceWiseDocRate;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\DoctorCategory;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\Client\ModeOfPayment;
use App\Models\API\V1\Master\Specialization;
use App\Models\API\V1\Master\SubSpecialization;
use App\Models\API\V1\Patients\CompanyMaster;
use App\Models\API\V1\Patients\PatientSource;
use App\Models\API\V1\Patients\PatientSponsorDetail;
use App\Models\API\V1\Patients\TariffMaster;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BillingConfigController extends Controller
{
    //advance against master list add & edit
    public function advanceAgainstList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $search = @$request['description']; 
                }
            }
            $response = [];
            $description = AdvanceAgainstDetail::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','adv_ag_code as code','description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Advance Against details list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        } 
    }
    public function advanceAgainstAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        if(@$data['type'] == 1){
            $validator = Validator::make((array)$data,[
                'code' => 'required|unique:advance_against_details',
                'description' => 'required|unique:advance_against_detail',
            ]); 
        }else{

            $validator = Validator::make((array)$data,[
                'id' => 'required',
                'code' => 'sometimes|required|unique:advance_against_details,code,'.@$data['id'],
                'description' => 'sometimes|required|unique:advance_against_details,description,'.@$data['id'],
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$data['type'] == 1){
                    $advance_detail = AdvanceAgainstDetail::create([
                        'adv_ag_code' => $data['code'],
                        'description' => $data['description'],  
                        'status' => 1  
                    ])->id;
                    $advance = [
                        'id' => $advance_detail,
                        'code' => $data['code'],
                        'description' => $data['description'],  
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('Advance against detail add successfully.', $advance, 200);  
                }else{
                    $find_data = AdvanceAgainstDetail::find($data['id']);
                    if($find_data){
                        $find_data->update([
                            'status' => (isset($data['status'])) ? $data['status'] : $find_data->status,
                            'adv_ag_code' => (@$data['code'] != null) ? @$data['code'] : $find_data->adv_ag_code,
                            'description' => (@$data['description'] != null) ? @$data['description'] : $find_data->description
                        ]);
                        DB::commit();
                        $advance = [
                            'id' => $data['id'],
                            'code' => $find_data->adv_ag_code,
                            'description' => $find_data->description
                        ];
                    return sendDataHelper('Advance against detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
                
            }catch(\Throwable $e)  {
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }

    //tariff service master list add & edit
    public function tariffMasterList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            if(isset($search))
            {
                $des_ids = [];
                $description = TariffMaster::query();
                if(isset($search))
                {
                    $description->where('description', 'like', "%{$search}%");
                }
                // $description->where('description', 'like', "%{$search}%");
                $description = $description->get();

                if( count($description) > 0)
                {
                    $des_ids = $description->pluck('id');
                }

                $ids = $des_ids;

                if( count($ids) > 0)
                {
                    $adv_data = TariffMaster::distinct('description')->whereIn('id', $ids)->get(['description']);
                    foreach ($adv_data as $key) {
                        $adv = TariffMaster::where(['description' => $key->description,'status' => 1])->first();
                        $advArr = [
                            'id' => $adv->id,
                            'code' => $adv->tariff_code,
                            'description' => $adv->description,
                            'status' =>$adv->status,
                        ];
                        array_push($response, $advArr);
                    }
                }
            }
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Tariff Service list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }  
    }
    //not add any services
    public function tariffMasterAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        if(@$data['type'] == 1){
            $validator = Validator::make((array)$data,[
                'code' => 'required|unique:tariff_masters,tariff_code',
                'description' => 'required|unique:tariff_masters',
                'service_id' => 'sometimes|required'
            ]); 
        }else{
            $validator = Validator::make((array)$data,[
                'id' => 'required',
                'status' => 'sometimes|required',
                'code' => 'sometimes|required|unique:tariff_masters,tariff_code,'.@$data['id'],
                'description' => 'sometimes|required|unique:tariff_masters,description,'.@$data['id'],
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$data['type'] == 1){
                    $advance_detail = TariffMaster::create([
                        'unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                        'tariff_code' => $data['code'],
                        'description' => $data['description'],
                        'created_unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                        'added_by' => @Auth::guard('client')->user()->fname ? Auth::guard('client')->user()->fname : 'Gemino',
                        'status' => 1  
                    ]); 
                    $advance = [
                        'id' => $advance_detail->id,
                        'code' => $data['code'],
                        'description' => $data['description'],  
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('Tariff service master detail add successfully.', $advance, 200); 
                }else{
                    $find_data = TariffMaster::find($data['id']);
                    if($find_data){
                        $find_data->update([
                            'unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                            'tariff_code' => (@$data['code'] != null) ? @$data['code'] : $find_data->tariff_code,
                            'description' => (@$data['description'] != null) ? @$data['description'] : $find_data->description,
                            'status' => (isset($data['status'])) ? $data['status'] : $find_data->status,
                            'updated_unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                            'updated_by' => @Auth::guard('client')->user()->fname ? Auth::guard('client')->user()->fname : 'Gemino',
                        ]);
                        
                        $advance = [
                            'id' => $data['id'],
                            'code' => $find_data->code,
                            'description' => $find_data->description,
                        ];
                        DB::commit();
                        return sendDataHelper('Tariff service master detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
            }catch(\Throwable $e)  {
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
        //add & edit services with code & description
    public function tariffMasterListAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $data = decryptData($request['response']);
        $validator = Validator::make((array)$data,[
            'code' => 'required|unique:tariff_masters',
            'description' => 'required',
            'service_id' => 'required',
        ]);
        
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            for($i = 0; $i < count($data['service_id']); $i++){
                $advance_detail = TariffMaster::create([
                    'unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                    'tariff_code' => @$data['code'],
                    'description' => @$data['description'],
                    'service_id' => $data['service_id'][$i],  
                    'created_unit_id' => @Auth::guard('client')->user()->id ? Auth::guard('client')->user()->id : 1,
                    'added_by' => @Auth::guard('client')->user()->fname ? Auth::guard('client')->user()->fname : 'Gemino',
                    'status' => 1  
                ]);
            }
            return sendDataHelper('Tariff master service add successfully.', [], 200);  
        }
    }
    //find tariff add service
    public function findTariffMasterList(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'description' => 'required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            $list = [];
            $tariff_lists = TariffMaster::where(['description' => $request['description'],'status' => 1])->where('service_id','!=',NULL)->get();
            if($tariff_lists){
                foreach($tariff_lists as $tariff_list){
                    $service = ServiceMaster::find($tariff_list->service_id);
                    $list[] = [
                        'description' => $service->description,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'service_code' => $service->service_code
                    ];
                }
                return sendDataHelper('Tariff Service Modified successfully.', $list, 200);
            }else{
                return sendDataHelper('No record found.', [], 200);
            }
        }
    }
    //service master list add & edit
    public function serviceMasterList(Request $request){
        try {

            $service_code = null;
            $service_name = null;
            $specialization = null;
            $sub_specialization = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $service_code = @$request['service_code'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                    $service_name = @$request['service_name'];
                    $specialization = @$request['specialization'];
                    $sub_specialization = @$request['sub_specialization'];
                    
                }
            }
            $response = [];
            // specializations , sub_specializations
            // $reg = DB::table('service_masters AS SM')->join('specializations AS SPEC', 'SPEC.id', '=', 'SM.specialization_id')
            //             ->join('sub_specializations AS SSPEC', 'SSPEC.id', '=', 'SM.sub_specialization_id');

            //     $reg->select('SM.id','SM.code','SM.description AS service_name','SPEC.description AS specialization','SSPEC.description AS sub_specialization','SM.base_service_rate AS rate','SM.status');
            //     $reg->orderBy('SM.id', 'asc')->orderBy('SM.created_at','desc');
            //     $reg = $reg->latest()->get();
               
                // return  $reg;
            
            $reg = ServiceMaster::query();
            $reg->orderBy('id', 'asc');

            if(isset($service_code))
            {
                $reg->where('service_code', 'like', "%{$service_code}%");
            }

            if(isset($service_name))
            {
                $reg->where('description', $service_name);
            }

            if(isset($specialization))
            {
                $reg->where('specialization_id', $specialization);
            }
            if(isset($sub_specialization))
            {
                $reg->where('sub_specialization_id', $sub_specialization);
            }

            $register = $reg->latest()->get();
        
            if(count($register) > 0)
            {
                foreach ($register as $key => $value) {
                    $dataArr = [
                        'id' => $value->id,
                        'code' => $value->code,
                        'service_name' => $value->description,
                        'specialization' => Specialization::find($value->specialization_id)->description,
                        'sub_specialization' => SubSpecialization::find($value->sub_specialization_id)->description,
                        'rate' => $value->base_service_rate.".00",
                        'status' => $value->status,
                    ];
                    array_push($response, $dataArr);
                }
            }
            return sendDataHelper('Service Master List.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function serviceMasterAdd(Request $request){

        if(respValid($request)) { return respValid($request); } 

        $data = decryptData($request['response']);
        if(@$data['type'] == 1){
            $validator = Validator::make((array)$data,[
                'specialization_id' => 'required',
                'sub_specialization_id' => 'required',
                'description' => 'required',
                'short_description' => 'required',
                'long_description' => 'required',
                'base_service_rate' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$data,[
                'id' => 'required',
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$data['type'] == 1){
                    $id = ServiceMaster::create([
                        'unit_id' => (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1, 
                        'service_code' => @$data['service_code'], 
                        'code_type' => @$data['code_type'], 
                        'code_details' => @$data['code_details'], 
                        'specialization_id' => @$data['specialization_id'], 
                        'sub_specialization_id' => @$data['sub_specialization_id'], 
                        'sac_code_id' => @$data['sac_code_id'], 
                        'short_description' => $data['short_description'],
                        'long_description' => $data['long_description'],
                        'description' => $data['description'],
                        'base_service_rate' => $data['base_service_rate'],
                        'in_house' => @$data['in_house'], 
                        'service_tax' => @$data['service_tax'], 
                        'service_tax_amount' => @$data['service_tax_amount'], 
                        'service_tax_percent' => @$data['service_tax_percent'], 
                        'staff_discount' => @$data['staff_discount'], 
                        'staff_discount_amount' => @$data['staff_discount_amount'], 
                        'staff_discount_percent' => @$data['staff_discount_percent'], 
                        'staff_dependant_discount' => @$data['staff_dependant_discount'], 
                        'staff_dependant_discount_amount' => @$data['staff_dependant_discount_amount'], 
                        'staff_dependant_discount_percent' => @$data['staff_dependant_discount_percent'], 
                        'concession' => @$data['concession'], 
                        'concession_amount' => @$data['concession_amount'], 
                        'concession_percent' => @$data['concession_percent'], 
                        'doctor_share' => @$data['doctor_share'], 
                        'doctor_share_percentage' => @$data['doctor_share_percentage'], 
                        'doctor_share_amount' => @$data['doctor_share_amount'], 
                        'rate_editable' => @$data['rate_editable'], 
                        'min_rate' => @$data['min_rate'], 
                        'max_rate' => @$data['max_rate'], 
                        'senior_citizen' => @$data['senior_citizen'], 
                        'senior_citizen_con_percent' => @$data['senior_citizen_con_percent'], 
                        'senior_citizen_con_amount' => @$data['senior_citizen_con_amount'], 
                        'senior_citizen_age' => @$data['senior_citizen_age'], 
                        'luxury_tax_amount' => @$data['luxury_tax_amount'], 
                        'luxury_tax_percent' => @$data['luxury_tax_percent'], 
                        'senior_citizen_age' => @$data['senior_citizen_age'], 
                        'is_mark_up' => @$data['is_mark_up'],  //apply to all class
                        'is_favorite' => @$data['is_favorite'],  //opd
                        'status' => 1, 
                    ])->id;
                    $service_detail = [
                        'id' => $id,
                        'short_description' => $data['short_description'],
                        'long_description' => $data['long_description'],
                        'description' => $data['description'],
                        'base_service_rate' => $data['base_service_rate'],
                    ];
                    return sendDataHelper('Service Modified successfully.', $service_detail, 200);
                }else{
                    $service = ServiceMaster::find($data['id']);
                    if($service){
                        $service->update($data);
                        $service_detail = [
                            'id' => $data['id'],
                            'short_description' => $service->short_description,
                            'long_description' => $service->long_description,
                            'description' => $service->description,
                            'base_service_rate' => $service->base_service_rate,
                        ];
                        return sendDataHelper('Service Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    //tariff master
    public function tariffServiceList(Request $request){
        try {

            $tariff_id = null;
            $specialization_id = null;
            $sub_specialization_id = null;
            $service_name = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $tariff_id = @$request['tariff_id'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                    $service_name = @$request['service_name'];
                    $specialization_id = @$request['specialization_id'];
                    $sub_specialization_id = @$request['sub_specialization_id'];
                    
                }
            }
            $response = [];
            $des_ids = [];
            $reg = ServiceMaster::query();
            $reg->orderBy('id', 'asc');
            $t_id = 0;
            $spe_id = 0;
            $subspe_id = 0;
            if(isset($tariff_id))
            {
                $t_id = TariffMaster::where('id',$tariff_id)->first()->id;
            }

            if(isset($service_name))
            {
                $reg->where('description', 'like', "%{$service_name}%");
                $register = $reg->get();
                if( count($register) > 0)
                {
                    $des_ids = $register->pluck('id');
                }
            }
            if(isset($specialization_id))
            {
                $spe_id = Specialization::where('id',$specialization_id)->first()->id;
            }
            if(isset($sub_specialization_id))
            {
                $subspe_id = SubSpecialization::where('id',$sub_specialization_id)->first()->id;
            }
            $ids = $des_ids; 
            
            if($t_id == 0){
                $services = ServiceMaster::join('tariff_masters','tariff_masters.service_id','=','service_masters.id')
                ->where('service_masters.specialization_id',$spe_id)
                ->where('service_masters.sub_specialization_id',$subspe_id)
                ->whereIn('service_masters.id', $ids)
                ->get(['tariff_masters.description as tariff_mastersdes','service_masters.description as service_name','service_masters.base_service_rate','service_masters.service_tax_amount','service_masters.staff_discount_amount','service_masters.staff_dependant_discount_amount','service_masters.concession_amount','service_masters.doctor_share_amount']);
                foreach($services as $service){
                    $dataArr = [
                        'tariff_name' => $service->tariff_mastersdes,
                        'service_name' => $service->service_name,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'class' => "OPD",
                        'rate' => ($service->base_service_rate == NULL) ? 0 : $service->base_service_rate.".00",
                        'service_tax_amount' => ($service->service_tax_amount == NULL) ? 0 : $service->service_tax_amount.".00",
                        'staff_discount_amount' => ($service->staff_discount_amount == NULL) ? 0 : $service->staff_discount_amount.".00",
                        'staff_dependant_discount_amount' => ($service->staff_dependant_discount_amount == NULL) ? 0 : $service->staff_dependant_discount_amount.".00",
                        'concession_amount' => ($service->concession_amount == NULL) ? 0 : $service->concession_amount.".00",
                        'doctor_share_amount' => ($service->doctor_share_amount == NULL) ? 0 : $service->doctor_share_amount.".00",
                        
                    ];
                    array_push($response, $dataArr);
                }
            }
            if($ids == []){
                $services = ServiceMaster::join('tariff_masters','tariff_masters.service_id','=','service_masters.id')
                ->where('service_masters.specialization_id',$spe_id)
                ->where('service_masters.sub_specialization_id',$subspe_id)
                ->where('tariff_masters.id',$t_id)
                ->get(['tariff_masters.description as tariff_mastersdes','service_masters.description as service_name','service_masters.base_service_rate','service_masters.service_tax_amount','service_masters.staff_discount_amount','service_masters.staff_dependant_discount_amount','service_masters.concession_amount','service_masters.doctor_share_amount']);
                foreach($services as $service){
                    $dataArr = [
                        'tariff_name' => $service->tariff_mastersdes,
                        'service_name' => $service->service_name,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'class' => "OPD",
                        'rate' => ($service->base_service_rate == NULL) ? 0 : $service->base_service_rate.".00",
                        'service_tax_amount' => ($service->service_tax_amount == NULL) ? 0 : $service->service_tax_amount.".00",
                        'staff_discount_amount' => ($service->staff_discount_amount == NULL) ? 0 : $service->staff_discount_amount.".00",
                        'staff_dependant_discount_amount' => ($service->staff_dependant_discount_amount == NULL) ? 0 : $service->staff_dependant_discount_amount.".00",
                        'concession_amount' => ($service->concession_amount == NULL) ? 0 : $service->concession_amount.".00",
                        'doctor_share_amount' => ($service->doctor_share_amount == NULL) ? 0 : $service->doctor_share_amount.".00",
                        
                    ];
                    array_push($response, $dataArr);
                }
            }
            if($spe_id == 0){
                $services = ServiceMaster::join('tariff_masters','tariff_masters.service_id','=','service_masters.id')
                ->where('service_masters.sub_specialization_id',$subspe_id)
                ->where('tariff_masters.id',$t_id)
                ->whereIn('service_masters.id', $ids)
                ->get(['tariff_masters.description as tariff_mastersdes','service_masters.description as service_name','service_masters.base_service_rate','service_masters.service_tax_amount','service_masters.staff_discount_amount','service_masters.staff_dependant_discount_amount','service_masters.concession_amount','service_masters.doctor_share_amount']);
                foreach($services as $service){
                    $dataArr = [
                        'tariff_name' => $service->tariff_mastersdes,
                        'service_name' => $service->service_name,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'class' => "OPD",
                        'rate' => ($service->base_service_rate == NULL) ? 0 : $service->base_service_rate.".00",
                        'service_tax_amount' => ($service->service_tax_amount == NULL) ? 0 : $service->service_tax_amount.".00",
                        'staff_discount_amount' => ($service->staff_discount_amount == NULL) ? 0 : $service->staff_discount_amount.".00",
                        'staff_dependant_discount_amount' => ($service->staff_dependant_discount_amount == NULL) ? 0 : $service->staff_dependant_discount_amount.".00",
                        'concession_amount' => ($service->concession_amount == NULL) ? 0 : $service->concession_amount.".00",
                        'doctor_share_amount' => ($service->doctor_share_amount == NULL) ? 0 : $service->doctor_share_amount.".00",
                        
                    ];
                    array_push($response, $dataArr);
                }
            }
            if($subspe_id == 0){
                $services = ServiceMaster::join('tariff_masters','tariff_masters.service_id','=','service_masters.id')
                ->where('service_masters.specialization_id',$spe_id)
                ->where('tariff_masters.id',$t_id)
                ->whereIn('service_masters.id', $ids)
                ->get(['tariff_masters.description as tariff_mastersdes','service_masters.description as service_name','service_masters.base_service_rate','service_masters.service_tax_amount','service_masters.staff_discount_amount','service_masters.staff_dependant_discount_amount','service_masters.concession_amount','service_masters.doctor_share_amount']);
                foreach($services as $service){
                    $dataArr = [
                        'tariff_name' => $service->tariff_mastersdes,
                        'service_name' => $service->service_name,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'class' => "OPD",
                        'rate' => ($service->base_service_rate == NULL) ? 0 : $service->base_service_rate.".00",
                        'service_tax_amount' => ($service->service_tax_amount == NULL) ? 0 : $service->service_tax_amount.".00",
                        'staff_discount_amount' => ($service->staff_discount_amount == NULL) ? 0 : $service->staff_discount_amount.".00",
                        'staff_dependant_discount_amount' => ($service->staff_dependant_discount_amount == NULL) ? 0 : $service->staff_dependant_discount_amount.".00",
                        'concession_amount' => ($service->concession_amount == NULL) ? 0 : $service->concession_amount.".00",
                        'doctor_share_amount' => ($service->doctor_share_amount == NULL) ? 0 : $service->doctor_share_amount.".00",
                        
                    ];
                    array_push($response, $dataArr);
                }
            }
            if(($t_id == 0) && ($ids == []) && ($spe_id == 0) && ($subspe_id == 0)){
                $services = ServiceMaster::join('tariff_masters','tariff_masters.service_id','=','service_masters.id')
                ->get([
                    'tariff_masters.description as tariff_mastersdes',
                    'service_masters.description as service_name',
                    'service_masters.base_service_rate',
                    'service_masters.service_tax_amount',
                    'service_masters.staff_discount_amount',
                    'service_masters.staff_dependant_discount_amount',
                    'service_masters.concession_amount',
                    'service_masters.doctor_share_amount'
                ]);
                foreach($services as $service){
                    $dataArr = [
                        'tariff_name' => $service->tariff_mastersdes,
                        'service_name' => $service->service_name,
                        'base_service_rate' => $service->base_service_rate.".00",
                        'class' => "OPD",
                        'rate' => ($service->base_service_rate == NULL) ? 0 : $service->base_service_rate.".00",
                        'service_tax_amount' => ($service->service_tax_amount == NULL) ? 0 : $service->service_tax_amount.".00",
                        'staff_discount_amount' => ($service->staff_discount_amount == NULL) ? 0 : $service->staff_discount_amount.".00",
                        'staff_dependant_discount_amount' => ($service->staff_dependant_discount_amount == NULL) ? 0 : $service->staff_dependant_discount_amount.".00",
                        'concession_amount' => ($service->concession_amount == NULL) ? 0 : $service->concession_amount.".00",
                        'doctor_share_amount' => ($service->doctor_share_amount == NULL) ? 0 : $service->doctor_share_amount.".00",
                        
                    ];
                    array_push($response, $dataArr);
                }
            }
            return sendDataHelper('All Tariff Service list.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function tariffServiceAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        
        $validator = Validator::make((array)$request,[
            'id' => 'required',   // it's service_masters table id bcoz all details find in this table
            'base_service_rate' => 'sometimes|required',
            'status' => 'sometimes|required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            if(($request['base_service_rate'] < $request['max_rate']) || ($request['base_service_rate'] < $request['min_rate'])){
                return sendErrorHelper("min rate or max rate should be less than or equal to base rate", [], 422);
            }
            if(@$request['code_type']){
                $input['code_type'] = @$request['code_type'];
            }
            if(@$request['code']){
                $input['code'] = @$request['code']; // after codetype field 
            }
            if(@$request['in_house']){
                $input['in_house'] = @$request['in_house']; 
            }
            if(@$request['service_tax']){
                $input['service_tax'] = @$request['service_tax'];  
            }
            if(@$request['service_tax_amount']){
                $input['service_tax_amount'] = @$request['service_tax_amount'];
            }
            if(@$request['service_tax_percent']){
                $input['service_tax_percent'] = @$request['service_tax_percent']; 
            }
            if(@$request['staff_discount']){
                $input['staff_discount'] = @$request['staff_discount'];  
            }
            if(@$request['staff_discount_amount']){
                $input['staff_discount_amount'] = @$request['staff_discount_amount']; 
            }
            if(@$request['staff_discount_percent']){
                $input['staff_discount_percent'] = @$request['staff_discount_percent'];  
            }
            if(@$request['staff_dependant_discount']){
                $input['staff_dependant_discount'] = @$request['staff_dependant_discount'];  
            }
            if(@$request['staff_dependant_discount_amount']){
                $input['staff_dependant_discount_amount'] = @$request['staff_dependant_discount_amount'];  
            }
            
            if(@$request['staff_dependant_discount_percent']){
                $input['staff_dependant_discount_percent'] = @$request['staff_dependant_discount_percent'];  
            }
            if(@$request['concession']){
                $input['concession'] = @$request['concession'];  
            }
            if(@$request['concession_amount']){
                $input['concession_amount'] = @$request['concession_amount'];  
            }
            if(@$request['concession_percent']){
                $input['concession_percent'] = @$request['concession_percent'];  
            }
            if(@$request['doctor_share']){
                $input['doctor_share'] = @$request['doctor_share'];  
            }
            if(@$request['doctor_share_percentage']){
                $input['doctor_share_percentage'] = @$request['doctor_share_percentage'];  
            }
            if(@$request['doctor_share_amount']){
                $input['doctor_share_amount'] = @$request['doctor_share_amount'];  
            }
            if(@$request['rate_editable']){
                $input['rate_editable'] = @$request['rate_editable'];  
            }
            if(@$request['min_rate']){
                $input['min_rate'] = @$request['min_rate'];  
            }
            if(@$request['max_rate']){
                $input['max_rate'] = @$request['max_rate'];  
            }
            if(@$request['is_mark_up']){ 
                //apply to all class
                $input['is_mark_up'] = @$request['is_mark_up'];
            }
            if(@$request['is_favorite']){ 
                //opd
                $input['is_favorite'] = @$request['is_favorite'];
            }
            $service = ServiceMaster::find($request->id);
            $service->update($input);
            return sendDataHelper('Tariff Master edit successfully.', [], 200);
        }
    }
     //company type list add & edit
    public function companyTypeList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            $des_ids = [];
            $description = CompanyTypeMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','comp_type_code as code','description','tariff_id','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Company Type list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function companyTypeAdd(Request $request){

        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:company_type_masters,comp_type_code',
                'description' => 'required|unique:company_type_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'status' => 'sometimes|required',
                'code' => 'sometimes|required|unique:company_type_masters,comp_type_code,'.@$request['id'],
                'description' => 'sometimes|required|unique:company_type_masters,description,'.@$request['id'],
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    $id = CompanyTypeMaster::create([
                        'comp_type_code' => @$request['code'], 
                        'description' => @$request['description'], 
                        'created_unit_id' => @Auth::guard('client')->user()->id,
                        'added_by' => @Auth::guard('client')->user()->fname,
                        'added_date_time' => now(),
                        'status' => 1, 
                    ])->id;
                    $service_detail = [
                        'id' => $id,
                        'code' => @$request['code'], 
                        'description' => @$request['description'],
                    ];
                    return sendDataHelper('Company Type add successfully.', $service_detail, 200);
                }else{
                    $service = CompanyTypeMaster::find($request['id']);
                    if($service){
                        $service->update([
                            'status' => (isset($request['status'])) ? @$request['status'] : $service->status,
                            'comp_type_code' => @$request['code'] ? @$request['code'] : $service->comp_type_code,
                            'description' => @$request['description'] ? @$request['description'] : $service->description, 
                            'updated_unit_id' => @Auth::guard('client')->user()->id,
                            'updated_by' => @Auth::guard('client')->user()->fname,
                            'updated_date_time' => now(),
                        ]);
                        $service_detail = [
                            'id' => @$request['id'],
                            'code' => @$request['code'], 
                            'description' => @$request['description'],
                        ];
                        return sendDataHelper('Company Type Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    //company Detail list add & edit
    public function companyDetailList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $search = @$request['description'];
                }
            }
            $response = [];
            $des_ids = [];
            $description = CompanyMaster::join('company_type_masters','company_type_masters.id','=','company_masters.comp_type_id')
            ->join('company_addresses','company_addresses.comp_id','=','company_masters.id')
            ->join('patient_sources','patient_sources.id','=','company_masters.patient_source_id');
            if(isset($search))
            {
                $description->where('company_masters.description', 'like', "%{$search}%");
            }
            $response = $description->select(
                'company_masters.id',
                'company_masters.comp_code as code',
                'company_masters.description',
                'company_masters.tariff_list',
                'company_masters.title',
                'company_masters.header_text',
                'company_masters.footer_text',
                'company_masters.logo',
                'company_masters.header_image',
                'company_masters.footer_image',
                'company_masters.status',
                'company_masters.patient_source_id',
                'patient_sources.description as patient_source_description',
                'company_addresses.contact_person',
                'company_addresses.contact_person',
                'company_addresses.resi_std_code',
                'company_addresses.mobile_no',
                'company_addresses.address_line1',
                'company_addresses.email',
                'company_masters.comp_type_id',
                'company_type_masters.description as company_type')->get();
                if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Company Type Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function companyDetailTariffSearch(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']);
                if($request)
                {
                    $search = @$request['description'];
                }
            }
            $response = [];
            $des_ids = [];
            $description = TariffMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->groupBy('description')->whereStatus(1)->get(['id','description']);
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Company Type Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function companyDetailAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 
        // $logo_img = null;
        // $head_img = null;
        // $footer_img = null;
        // if(@$request->flag == 1){
        //     $c_id = CompanyMaster::OrderBy('id','DESC')->first();
        //     if($c_id){
        //         $id = $c_id->id;
        //     }else{
        //         $id = 1;
        //     }
        //     if($request->logo){
        //         $logo = uploadFile($request->logo,'company_logo','c_l',$id ,1);
        //         return $logo_img = $logo;
        //     }
        //     if($request->header_image){
        //         $header_image = uploadFile($request->header_image,'company_h_logo','c_h',$id ,1);
        //         $head_img = $header_image;
        //     }
        //     if($request->footer_image){
        //         $footer_image = uploadFile($request->footer_image,'company_f_logo','c_f',$id ,1);
        //         $footer_img = $footer_image;
        //     }
        // }else{
            // if(@$request->logo){
            //     deleteFile($company_master->logo,'company_logo');
            //     $logo = uploadFile($request->logo,'company_logo','c_l',$company_master->id,1);
            //     $input['logo'] = @$logo;
            // }
            // if(@$request->header_image){
            //     deleteFile($company_master->header_image,'company_h_logo');
            //     $header_image = uploadFile($request->header_image,'company_h_logo','c_h',$company_master->id,1);
            //     $input['header_image'] = @$header_image;
            // }
            // if(@$request->footer_image){
            //     deleteFile($company_master->footer_image,'company_f_logo');
            //     $footer_image = uploadFile($request->footer_image,'company_f_logo','c_f',$company_master->id,1);
            //     $input['footer_image'] = @$footer_image;
            // }
        // }
        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                // 'code' => 'required|unique:company_masters,comp_code',
                // 'description' => 'required|unique:company_masters',
                'contact_no' => 'required',
                'tariff_id' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'status' => 'sometimes|required',
                'code' => 'sometimes|required|unique:company_masters,comp_code,'.@$request['id'],
                'contact_no' => 'sometimes|required',
                'contact_person' => 'sometimes|required',
                'tariff_id' => 'sometimes|required',
                'description' => 'sometimes|required|unique:company_masters,description,'.@$request['id'],
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$request['type'] == 1){

//                    echo $logo_img;
//                    echo "logo_img <br/>";
//                    echo $head_img;
//                    echo "head_img <br/>";
//             return $footer_img;
                    $logo_img = null;
                    $head_img = null;
                    $footer_img = null;
                    // if(@$request->flag == 1){
                    $c_id = CompanyMaster::OrderBy('id','DESC')->first();
                    if($c_id){
                        $id = $c_id->id;
                    }else{
                        $id = 1;
                    }
                    if($request->logo){
                        $logo = uploadFile($request->logo,'company_logo','c_l',$id ,1);
                        return $logo_img = $logo;
                    }
                    if($request->header_image){
                        $header_image = uploadFile($request->header_image,'company_h_logo','c_h',$id ,1);
                        $head_img = $header_image;
                    }
                    if($request->footer_image){
                        $footer_image = uploadFile($request->footer_image,'company_f_logo','c_f',$id ,1);
                        $footer_img = $footer_image;
                    }
                    $company_master = CompanyMaster::create([
                        'comp_code' => $request['code'], 
                        'description' => $request['description'], 
                        'comp_type_id' => @$request['comp_type_id'],
                        'tariff_list' => (@$request['tariff_id']) ? @$request['tariff_id'] : NULL,
                        'patient_source_id' => @$request['patient_source_id'],
                        'title' => @$request['title'],
                        'header_text' => @$request['header_text'],
                        'footer_text' => @$request['footer_text'],
                        'logo' => @$logo_img,
                        'header_image' => @$head_img,
                        'footer_image' => @$footer_img,
                        'added_date_time' => now(),
                        'status' => 1, 
                    ]);
                    $logo_img = null;
                    $head_img = null;
                    $footer_img = null;
                    $l_id = CompanyMaster::OrderBy('id','desc')->first();
                    if($l_id){
                        $l_id->id;
                    }else{
                        $l_id = 1;
                    }
                    if(@$request->logo){
                        $logo = uploadFile($request->logo,'company_logo','c_l',$l_id,1);
                        $logo_img = $logo;
                    }
                    if(@$request->header_image){
                        $header_image = uploadFile($request->header_image,'company_h_logo','c_h',$l_id,1);
                        $head_img = $header_image;
                    }
                    if(@$request->footer_image){
                        $footer_image = uploadFile($request->footer_image,'company_f_logo','c_f',$l_id,1);
                        $footer_img = $footer_image;
                    }
                    $input['comp_code'] = $request['code'];
                    $input['description'] = $request['description'];
                    $input['comp_type_id'] = @$request['comp_type_id'];
                    $input['tariff_list'] = implode(",",(array)@$request['tariff_id']);
                    $input['patient_source_id'] = @$request['patient_source_id'];
                    $input['title'] = @$request['title'];
                    $input['header_text'] = @$request['header_text'];
                    $input['footer_text'] = @$request['footer_text'];
                    $input['logo'] = @$logo_img;
                    $input['header_image'] = @$head_img;
                    $input['footer_image'] = @$footer_img;
                    $input['status'] = 1;
                    $company_master = CompanyMaster::create($input);
                    CompanyAddress::create([
                        'comp_id' => @$company_master->id,
                        'comp_unit_id' => $company_master->comp_unit_id,
                        'contact_person' => @$request['contact_person'],
                        'resi_std_code' => @$request['resi_std_code'],
                        'mobile_no' => @$request['contact_no'],  //
                        'address_line1' => @$request['address'], //
                        'email' => @$request['email'],   //
                        'status' => 1
                    ]);
                    DB::commit();
                    $service_detail = [
                        'id' => @$company_master->id,
                        'code' => @$request['code'], 
                        'description' => @$request['description']
                    ];
                    return sendDataHelper('Company Master add successfully.', $service_detail, 200);
                }else{
                    $company_master = CompanyMaster::where('company_masters.id',@$request['id'])->first();
                            
                    if($company_master){
                        $comp_address = CompanyAddress::where(['comp_id' => @$company_master->id])->first();
                        if(isset($request['status'])){
                            $input['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $input['comp_code'] = @$request['code'];
                        }
                        if(@$request['tariff_id']){
                            $input['tariff_list'] = implode(",",@$request['tariff_id']);
                        }
                        if(@$request['description']){
                            $input['description'] = @$request['description'];
                        }
                        if(@$request['comp_type_id']){
                            $input['comp_type_id'] = @$request['comp_type_id'];
                        }
                        if(@$request['patient_source_id']){
                            $input['patient_source_id'] = @$request['patient_source_id'];
                        }
                        if(@$request['contact_no']){
                            $input['mobile_no'] = @$request['contact_no'];
                        }
                        if(@$request['address']){
                            $input['address_line1'] = @$request['address'];
                        }
                        if(@$request['email']){
                            $input['email'] = @$request['email'];
                        }
                        if(@$request['header_text']){
                            $input['header_text'] = @$request['header_text'];
                        }
                        if(@$request['footer_text']){
                            $input['footer_text'] = @$request['footer_text'];
                        }
                        if(@$request['contact_person']){
                            $input['contact_person'] = @$request['contact_person'];
                        }
                        $input['updated_date_time'] = now();

                        if(@$request['title']){
                            $input['title'] = @$request['title'];
                        }
                        if(isset($request->logo)){
                            deleteFile($company_master->logo,'company_logo');
                            $logo = uploadFile($request->logo,'company_logo','c_l',$company_master->id,1);
                            $input['logo'] = @$logo;
                        }
                        if(isset($request->header_image)){
                            deleteFile($company_master->header_image,'company_h_logo');
                            $header_image = uploadFile($request->header_image,'company_h_logo','c_h',$company_master->id,1);
                            $input['header_image'] = @$header_image;
                        }
                        if(isset($request->footer_image)){
                            deleteFile($company_master->footer_image,'company_f_logo');
                            $footer_image = uploadFile($request->footer_image,'company_f_logo','c_f',$company_master->id,1);
                            $input['footer_image'] = @$footer_image;
                        }
                        $company_master->update($input);
                        $comp_address->update($input);
                        DB::commit();
                        $service_detail = [
                            'id' => @$request['id'],
                            'code' => @$request['code'] ? @$request['code'] : $company_master->comp_code, 
                            'description' => @$request['description'] ? @$request['description'] : $company_master->description,
                        ];
                        return sendDataHelper('Company Master Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function associatedCompanyList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = CompanyAssociateMaster::join('company_masters','company_masters.id','=','company_associate_masters.comp_id')
            ->join('ass_company_tariff_details','ass_company_tariff_details.comp_ass_id','=','company_associate_masters.id')
            ->join('tariff_masters','tariff_masters.id','=','ass_company_tariff_details.ct_id');
            if(isset($search))
            {
                $description->where('company_associate_masters.description', 'like', "%{$search}%");
            }
            $response = $description->select('company_associate_masters.id','company_associate_masters.comp_ass_code as code','company_associate_masters.description','company_associate_masters.status','company_masters.description as company','company_masters.id as comp_id','tariff_masters.id as ct_id','tariff_masters.description as tariff')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Associated Company Type list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function associatedCompanyAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:company_associate_masters,comp_ass_code',
                'description' => 'required|unique:company_associate_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'code' => 'sometimes|required|unique:company_associate_masters,comp_ass_code,'.@$request['id'],
                'description' => 'sometimes|required|unique:company_associate_masters,description,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    $company_ass_m = CompanyAssociateMaster::create([
                        'comp_ass_code' => $request['code'],
                        'description' => $request['description'],
                        'comp_id' => @$request['comp_id'],
                        'status' => 1,
                        'created_unit_id' => @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1,
                        'added_by' => @Auth::guard('client')->user()->name ? @Auth::guard('client')->user()->name : 'Gemino',
                    ]);
                    AssCompanyTariffDetail::create([
                        'ct_id' => @$request['ct_id'], //ass company tariff id
                        'comp_ass_id' => $company_ass_m->id,
                        'status' => 1,
                        'created_unit_id' => @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1,
                        'added_by' => @Auth::guard('client')->user()->name ? @Auth::guard('client')->user()->name : 'Gemino',
                    ]);
                    $service_detail = [
                        'id' => $company_ass_m->id,
                        'code' => @$request['code'], 
                        'description' => @$request['description'],
                    ];
                    return sendDataHelper('Associated Company Master add successfully.', $service_detail, 200);
                }else{
                    $company_ass_detail = CompanyAssociateMaster::find($request['id']);
                    if($company_ass_detail){
                        if(isset($request['status'])){
                            $input['status'] = $request['status'];
                        }
                        if(@$request['code']){
                            $input['comp_ass_code'] = $request['code'];
                        }
                        if(@$request['description']){
                            $input['description'] = $request['description'];
                        }
                        if(@$request['comp_id']){
                            $input['comp_id'] = $request['comp_id'];
                        }
                        if(isset($request['ct_id'])){
                            $add['ct_id'] = $request['ct_id'];
                        }
                        $add['updated_unit_id'] = @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1;
                        $add['updated_by'] = @Auth::guard('client')->user()->fname ? @Auth::guard('client')->user()->fname : 'Gemino';
                        $input['updated_unit_id'] = @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1;
                        $input['updated_by'] = @Auth::guard('client')->user()->fname ? @Auth::guard('client')->user()->fname : 'Gemino';
                        $company_ass_detail->update($input);
                        AssCompanyTariffDetail::where('comp_ass_id',$request['id'])->update($add);
                        DB::commit();
                        $service_detail = [
                            'id' => @$request['id'],
                            'code' => @$request['code'] ? @$request['code'] : $company_ass_detail->comp_ass_code,
                            'description' => @$request['description'] ? @$request['description'] : $company_ass_detail->description, 
                        ];
                        return sendDataHelper('Associated Company Master Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function expenseMasterList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = ExpenseMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','expens_code as code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Expense Master Type list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function expenseMasterAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:expense_masters,expens_code',
                'description' => 'required|unique:expense_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'description' => 'sometimes|required|unique:expense_masters,description,'.@$request['id'],
                'code' => 'sometimes|required|unique:expense_masters,expens_code,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    
                    $expense_master = ExpenseMaster::create([
                        'expens_code' => $request['code'],
                        'description' => $request['description'],
                        'status' => 1,
                        'created_unit_id' => @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1,
                        'added_by' => @Auth::guard('client')->user()->name ? @Auth::guard('client')->user()->name : 'Gemino',
                    ]);
                    $service_detail = [
                        'id' => $expense_master->id,
                        'code' => @$request['code'], 
                        'description' => @$request['description'],
                    ];
                    return sendDataHelper('Expense Master add successfully.', $service_detail, 200);
                }else{
                    $expense_master = ExpenseMaster::find($request['id']);
                    if($expense_master){
                        $expense_master->update([
                            'status' => (isset($request['status'])) ? $request['status'] : $expense_master->status,
                            'expens_code' => (@$request['code']) ? @$request['code'] : $expense_master->expens_code,
                            'description' => (@$request['description']) ? @$request['description'] : $expense_master->description,
                            'updated_unit_id' => @Auth::guard('client')->user()->id ? @Auth::guard('client')->user()->id : 1,
                            'updated_by' => @Auth::guard('client')->user()->fname ? @Auth::guard('client')->user()->fname : 'Gemino'
                        ]);
                        DB::commit();
                        $service_detail = [
                            'id' => @$request['id'],
                            'code' => @$request['code'] ? @$request['code'] : $expense_master->expens_code,
                            'description' => @$request['description'] ? @$request['description'] : $expense_master->description, 
                        ];
                        return sendDataHelper('Expense Master Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function serRateDocCatList(Request $request){
        try { 
            $doc_cat_id = null;
            $service_name = null;
            $class_id = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $doc_cat_id = @$request['doc_cat_id'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                    $service_name = @$request['service_name'];
                    $class_id = @$request['class_id'];
                    
                }
            }
            $description = ServiceClassRateDetail::join('doctor_categories','doctor_categories.id','=','service_class_rate_details.doc_cat_id')
                ->join('service_wise_doc_rates','service_wise_doc_rates.ser_rate_id','=','service_class_rate_details.id')
                ->join('service_masters','service_masters.id','=','service_wise_doc_rates.ser_id')
                ->join('class_masters','class_masters.id','=','service_class_rate_details.class_id');
            if(isset($class_id)){
                $description->where('service_class_rate_details.class_id',$class_id);
            }
            
            if(isset($doc_cat_id))
            {
                $description->where('service_class_rate_details.doc_cat_id',$doc_cat_id);
            }

            if(isset($service_name))
            {
                $description->where('service_masters.description', 'like', "%{$service_name}%");
            }
            $response = [];
            $service_rates = $description->select('service_class_rate_details.id','doctor_categories.description as doc_cat','service_masters.description as service_name','service_masters.base_service_rate','class_masters.description as class_name')->get();
            foreach($service_rates as $service_rate){
                $response[$service_rate->doc_cat][] = [
                    'id' => $service_rate->id,
                    'service_name' => $service_rate->service_name,
                    'class_name' => $service_rate->class_name,
                    'service_rate' => $service_rate->base_service_rate,
                ];
            }
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Company Type Master list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function serRateDocCatAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'doc_cat_id' => 'required',
                'ser_id' => 'required',
                'class_id' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'doc_cat_id' => 'sometimes|required',
                'ser_id' => 'sometimes|required',
                'class_id' => 'sometimes|required',
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$request['type'] == 1){
                    $service = ServiceClassRateDetail::create([
                        'doc_cat_id' => $request['doc_cat_id'],
                        'ser_id' => @$request['ser_id'],
                        'class_id' => @$request['class_id'],
                        'added_date_time' => now(),
                        'created_unit_id' => Auth::guard('client')->user()->id,
                        'added_utc_date_time' => now(),
                        'added_by' => Auth::guard('client')->user()->fname,
                        'class_unit_id' => Auth::guard('client')->user()->id,
                        'status' => 1
                    ]);
                    // $request['ser_id'] = [1,2,3,4,5];
                    for($i = 0; $i < count($request['ser_id']); $i++){
                        ServiceWiseDocRate::create([
                            'ser_rate_id' => @$service->id,
                            'ser_id' => $request['ser_id'][$i],
                            'doc_cat_id' => @$request['doc_cat_id'],
                        ]);
                    }
                    $service_detail = [
                        'id' => $service->id,
                        'doc_cat_id' => $request['doc_cat_id'],
                        'ser_id' => @$request['ser_id'],
                    ];
                    DB::commit();
                    return sendDataHelper('Service Rate Doctor Category add successfully.', $service_detail, 200);
                }else{
                    $service = ServiceClassRateDetail::find($request['id']);
                    if($service){
                        if(@$request['doc_cat_id']){
                            $input['doc_cat_id'] = @$request['doc_cat_id'];
                        }
                        if(@$request['ser_id']){
                            $input['ser_id'] = $request['ser_id'];
                        }
                        $input['updated_unit_id'] = (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1;
                        $input['updated_by'] = (@Auth::guard('client')->user()->fname) ? @Auth::guard('client')->user()->fname : 'Gemino';
                        $input['updated_date_time'] = now();
                        $input['updated_utc_date_time'] = now();

                        $service->update($input);
                        // $request['ser_id'] = [3,5,8];
                        for($i = 0; $i < count($request['ser_id']); $i++){
                            $service_detail_id = ServiceWiseDocRate::where(['ser_rate_id' => $service->id,'doc_cat_id' => $service->doc_cat_id,'ser_id' => $request['ser_id'][$i]])->first();
                            if(!$service_detail_id){
                                ServiceWiseDocRate::create([
                                    'ser_rate_id' => @$service->id,
                                    'ser_id' => $request['ser_id'][$i],
                                    'doc_cat_id' => $service->doc_cat_id,
                                ]);
                            }
                        }
                        DB::commit();
                        $service_detail = [
                            'id' => $request['id'],
                        ];
                        return sendDataHelper('Service Rate Doctor Category Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function doctorShareList(Request $request){
        try {
            $t_id = null;
            $specialization_id = null;
            $subspecialization_id = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $t_id = @$request['t_id'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                    $specialization_id = @$request['specialization_id'];
                    $subspecialization_id = @$request['subspecialization_id'];
                    
                }
            }
            $response = [];
            $specialization = DoctorShareSpecialization::join('doctors','doctors.id','=','doctor_share_specializations.doc_id')
            ->join('specializations','specializations.id','=','doctor_share_specializations.s_id')
            ->join('sub_specializations','sub_specializations.id','=','doctor_share_specializations.su_id')
            ->join('tariff_masters','tariff_masters.id','=','doctor_share_specializations.t_id');
            if(isset($t_id))
            {
                $specialization->where('doctor_share_specializations.t_id',$t_id);
            }

            if(isset($specialization_id))
            {
                $specialization->where('doctor_share_specializations.s_id', $specialization_id);
            }

            if(isset($subspecialization_id))
            {
                $specialization->where('doctor_share_specializations.su_id', $subspecialization_id);
            }
           $doc_specializations = $specialization->select('doctor_share_specializations.id','doctors.first_name','doctors.last_name','tariff_masters.description as tariff_name','specializations.description as specialization','sub_specializations.description as sub_specializations',DB::raw('count(doctor_share_specializations.id) as total_doc'))
           ->groupBy('doctor_share_specializations.doc_id')
           ->get();
            
            foreach($doc_specializations as $doc_specialization){
                $response[$doc_specialization->first_name.' '.$doc_specialization->last_name. " (" .$doc_specialization->total_doc . " items)"][] = [
                    'id' => $doc_specialization->id,
                    'specialization_name' => $doc_specialization->specialization,
                    'tariff_name' => $doc_specialization->tariff_name,
                    'doc_name' => $doc_specialization->first_name.' '.$doc_specialization->last_name,
                    'subspecialization_name' => $doc_specialization->sub_specializations,
                ];
            }
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Doctor Share details list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function doctorShareAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                's_id' => 'required',
                'su_id' => 'sometimes|required',
                'list_ser_id' => 'sometimes|required',
                't_id' => 'required',
                'doc_id' => 'required',
                'apply_to_all_service' => 'required',
                'share_pr' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'status' => 'sometimes|required',
            ]);
        }
        if(@$request['type'] == 1){
            DB::beginTransaction();
            $doc_share = DoctorShare::where('doc_id' , @$request['doc_id'])->first();
            if(!$doc_share){
                $bid = DoctorShare::create([
                    'doc_id' => @$request['doc_id'],
                    'status' => 1,
                    'created_unit_id' => Auth::guard('client')->user()->id,
                    'added_by' => Auth::guard('client')->user()->fname,
                    'added_on' => now(),
                    'added_date_time' => now(),
                    'added_utc_date_time' => now(),
                ]);
            }else{
                $bid = $doc_share;
            }
            $input = [
                'doc_share_id' => $bid->id,
                'doc_id' => @$request['doc_id'],
                't_id' => @$request['t_id'],
                's_id' => @$request['s_id'],
                'su_id' => @$request['s_id'],
                'fname' => @$request['fname'],
                'lname' => @$request['lname'],
                'share_pr' => @$request['share_pr'],
                'apply_all_subsup' => @$request['apply_all_subsup'],   // list specialization apply to all subspecialization checkbox
                'apply_to_all_service' => @$request['apply_to_all_service'],   // tariff right checkbox
                'apply_to_all_doc' => @$request['apply_to_all_doc'],   // first checkbox
                'status' => 1,
                'created_unit_id' => Auth::guard('client')->user()->id,
                'added_by' => Auth::guard('client')->user()->fname,
                'added_on' => now(),
                'added_date_time' => now(),
                'added_utc_date_time' => now(),
            ];
            if((@$request['su_id'] && @$request['list_ser_id']) == ""){
                DoctorShareSpecialization::create($input);
            }
            if((@$request['s_id']  === @$request['s_id']) && (@$request['su_id']  === @$request['s_id']) && (@$request['list_ser_id']  === @$request['s_id'])){
                DoctorShareSpecialization::create($input);
            }
                
            DB::commit();
            $bulk_rate_chg = [
                'id' => $bid->id,
                'doc_id' => @$request['doc_id'],
            ];
            return sendDataHelper('Doctor Share Add successfully.', $bulk_rate_chg, 200);
        }else{

        }
    }
    public function bulkRateChangeList(Request $request){
        try {
            $start_date = null;
            $end_date = null;
            $name = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $start_date = @$request['start_date'];
                    $end_date = @$request['end_date'];
                    $name = @$request['name'];
                    
                }
            }
            $description = BulkRateChange::join('bulk_rate_change_tarrifs','bulk_rate_change_tarrifs.bulk_id','=','bulk_rate_changes.id')
                ->join('tariff_masters','tariff_masters.id','=','bulk_rate_change_tarrifs.t_id');
            
            if(isset($start_date) && ($end_date))
            {
                $description->whereBetween('effective_date',[$start_date, $end_date]);
            }
            if(isset($name))
            {
                $description->where('description', 'like', "%{$name}%");
            }
            $response = $description->select('bulk_rate_changes.id',DB::raw('bulk_rate_changes.effective_date',"Y-m-d"),'tariff_masters.description as tariff_name','bulk_rate_changes.added_by','bulk_rate_changes.is_freeze')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Bulk Rate Change List.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function bulkRateChangeAdd(Request $request){
        
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'tariff_name' => 'required',
                'service_spec' => 'required',
                'remark' => 'required',
                'effective_date' => 'required|date|date_format:Y-m-d',
                'is_freeze' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    DB::beginTransaction();
                    $json_spec = 
                    '[
                        { 
                            "sub_specialization":1,
                            "amount":true,
                            "percent":1,
                            "rate":0,
                            "ope_type":"Add"
                        },
                    
                        { 
                            "sub_specialization":11,
                            "amount":true,
                            "percent":0,
                            "rate":1,
                            "ope_type":"Add"
                        },
                    
                        { 
                            "sub_specialization":19,
                            "amount":true,
                            "percent":1,
                            "rate":0,
                            "ope_type":"Add"
                        }
                    ]';
                    $bid = BulkRateChange::create([
                        // 'is_applicable' => @$request['is_applicable'],
                        'effective_date' => @$request['effective_date'],
                        'is_freeze' => @$request['is_freeze'],
                        'status' => 1,
                        'created_unit_id' => Auth::guard('client')->user()->id,
                        'added_by' => Auth::guard('client')->user()->fname,
                        'added_on' => now(),
                        'added_date_time' => now(),
                        'added_utc_date_time' => now(),
                        'remark' => @$request['remark']
                    ]);
                    $specializations = json_decode($json_spec,true);
                    foreach($specializations as $specialization){
                        BulkRateChangeSpecialization::create([
                            'bulk_id' => $bid->id,
                            'su_id' => @$specialization['sub_specialization'],
                            'is_set_rate_for_all' => @$specialization['is_set_rate_for_all'],
                            'is_percentage_rate' => @$specialization['is_percentage_rate'],
                            'percentage_rate' => @$specialization['percentage_rate'],
                            'amount_rate' => @$specialization['amount_rate'],
                            'operation_type' => @$specialization['operation_type'],
                            'status' => 1,
                        ]);
                    }
                    $tariff_names = [1,3];
                    foreach($tariff_names as $tariff_name){
                        BulkRateChangeTarrif::create([
                            'bulk_id' => $bid->id,
                            't_id' => $tariff_name,
                            'status' => 1,
                            'created_unit_id' => Auth::guard('client')->user()->id,
                            'added_by' => Auth::guard('client')->user()->fname,
                            'added_on' => now(),
                            'added_date_time' => now(),
                            'added_utc_date_time' => now(),
                        ]);
                    }
                    DB::commit();
                    $bulk_rate_chg = [
                        'id' => $bid->id,
                        'effective_date' => @$request['effective_date'],
                        'is_freeze' => @$request['is_freeze'],
                    ];
                    return sendDataHelper('Bulk Rate Change successfully.', $bulk_rate_chg, 200);
                }else{
                    $bulk_rate_chg = BulkRateChange::find($request['id']);
                    if($bulk_rate_chg){
                        $date_now = time(); //current timestamp
                        $date_convert = strtotime($bulk_rate_chg->effective_date);
                    
                        if ($date_now > $date_convert) {
                            
                            if(@$request['is_freeze']){
                                $input['is_freeze'] = @$request['is_freeze'];
                            }
                            if(@$request['effective_date']){
                                $input['effective_date'] = @$request['effective_date'];
                            }
                            if(isset($request['status'])){
                                $input['status'] = @$request['status'];
                            }
                            $input['updated_unit_id'] = @Auth::guard('client')->user()->id;
                            $input['updated_by'] = @Auth::guard('client')->user()->fname;
                            $input['updated_date_time'] = now();
                            $bulk_rate_chg->update($input);
                            $json_spec = 
                            '[
                                { 
                                    "sub_specialization":3,
                                    "amount":true,
                                    "percent":1,
                                    "rate":0,
                                    "ope_type":"Add"
                                },
                            
                                { 
                                    "sub_specialization":10,
                                    "amount":true,
                                    "percent":0,
                                    "rate":1,
                                    "ope_type":"Add"
                                },
                            
                                { 
                                    "sub_specialization":15,
                                    "amount":true,
                                    "percent":1,
                                    "rate":0,
                                    "ope_type":"Add"
                                }
                            ]';
                            $specializations = json_decode($json_spec,true);
                            if($specializations){
                                BulkRateChangeSpecialization::where('bulk_id' , $bulk_rate_chg->id)->delete();
                            }
                            foreach($specializations as $specialization){
                                
                                BulkRateChangeSpecialization::create([
                                    'bulk_id' => $bulk_rate_chg->id,
                                    'su_id' => @$specialization['sub_specialization'],
                                    'is_set_rate_for_all' => @$specialization['is_set_rate_for_all'],
                                    'is_percentage_rate' => @$specialization['is_percentage_rate'],
                                    'percentage_rate' => @$specialization['percentage_rate'],
                                    'amount_rate' => @$specialization['amount_rate'],
                                    'operation_type' => @$specialization['operation_type'],
                                    'status' => 1,
                                ]);
                            }
                            $tariff_names = [2,3];
                            if(@$tariff_names){
                                BulkRateChangeTarrif::where('bulk_id', $bulk_rate_chg->id)->delete();
                            }
                            
                            foreach($tariff_names as $tariff_name){
                                BulkRateChangeTarrif::create([
                                    'bulk_id' => $bulk_rate_chg->id,
                                    't_id' => $tariff_name,
                                    'status' => 1,
                                    'created_unit_id' => Auth::guard('client')->user()->id,
                                    'added_by' => Auth::guard('client')->user()->fname,
                                    'added_on' => now(),
                                    'added_date_time' => now(),
                                    'added_utc_date_time' => now(),
                                ]);
                            }
                        }
                        
                        DB::commit();
                        $bulk_detail = [
                            'id' => $request['id'],
                            'effective_date' => @$request['effective_date'],
                            'is_freeze' => @$request['is_freeze'],
                        ];
                        return sendDataHelper('Bulk Rate Change modify successfully.', $bulk_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    // Concession Reason Master add,edit,list & search
    public function conReasonMasterList(Request $request){
        try {

            $search = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];
                    
                }
            }
            $reg = ConReasonMaster::query();
            $reg->orderBy('id', 'asc');

            if(isset($search))
            {
                $reg->where('con_r_description', 'like', "%{$search}%");
            }

            $response = $reg->latest()->select('id','con_r_code as code','con_r_description as description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Concession Reason Master List.', $response, $code = 200);	
            }
           
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function conReasonMasterAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:con_reason_masters,con_r_code',
                'description' => 'required|unique:con_reason_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'code' => 'sometimes|required|unique:con_reason_masters,con_r_code,'.@$request['id'],
                'description' => 'sometimes|required|unique:con_reason_masters,description,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    $id = ConReasonMaster::create([
                        'created_unit_id' => (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1, 
                        'con_r_code' => @$request['code'], 
                        'con_r_description' => @$request['description'], 
                        'added_by' => (@Auth::guard('client')->user()->fname) ? @Auth::guard('client')->user()->fname : 'Gemino', 
                        'added_date_time' => now(), 
                        'status' => 1, 
                    ])->id;
                    $con_reason_master = [
                        'id' => $id,
                        'description' => $request['description'],
                        'code' => $request['code'],
                    ];
                    return sendDataHelper('Concession Reason add successfully.', $con_reason_master, 200);
                }else{
                    $service = ConReasonMaster::find($request['id']);
                    if($service){
                        if(@$request['code']){
                            $input['con_r_code'] = @$request['code'];
                        }
                        if(@$request['description']){
                            $input['con_r_description'] = @$request['description'];
                        }
                        if(isset($request['status'])){
                            $input['status'] = @$request['status'];
                        }
                        
                        $input['updated_unit_id'] = (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1;
                        $input['updated_by'] = (@Auth::guard('client')->user()->fname) ? @Auth::guard('client')->user()->fname : 'Gemino';
                        $input['updated_date_time'] = now();
                        $service->update($input);
                        $service_detail = [
                            'id' => $request['id'],
                            'description' => $service->con_r_description,
                            'code' => $service->con_r_code,
                        ];
                        return sendDataHelper('Concession Reason Modified successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    public function reasonRefundMasterList(Request $request){
        try {

            $search = null;

            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];
                    
                }
            }
            $reg = ReasonOfRefundMaster::query();
            $reg->orderBy('id', 'asc');

            if(isset($search))
            {
                $reg->where('description', 'like', "%{$search}%");
            }

            $response = $reg->latest()->select('id','code','description','status')->get();
            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Reason Of Refund Master List.', $response, $code = 200);	
            }
            
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function reasonRefundMasterAdd(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:reason_of_refund_masters',
                'description' => 'required|unique:reason_of_refund_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'code' => 'sometimes|required|unique:reason_of_refund_masters,code,'.@$request['id'],
                'description' => 'sometimes|required|unique:reason_of_refund_masters,description,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                if(@$request['type'] == 1){
                    $id = ReasonOfRefundMaster::create([
                        'created_unit_id' => (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1, 
                        'code' => @$request['code'], 
                        'description' => @$request['description'], 
                        'added_by' => (@Auth::guard('client')->user()->fname) ? @Auth::guard('client')->user()->fname : 'Gemino', 
                        'added_date_time' => now(), 
                        'status' => 1, 
                    ])->id;
                    $con_reason_master = [
                        'id' => $id,
                        'description' => $request['description'],
                        'code' => $request['code'],
                    ];
                    return sendDataHelper('Reason Of Refund Master add successfully.', $con_reason_master, 200);
                }else{
                    $service = ReasonOfRefundMaster::find($request['id']);
                    if($service){
                        if(@$request['code']){
                            $input['code'] = @$request['code'];
                        }
                        if(@$request['description']){
                            $input['description'] = @$request['description'];
                        }
                        if(isset($request['status'])){
                            $input['status'] = @$request['status'];
                        }
                        
                        $input['updated_unit_id'] = (@Auth::guard('client')->user()->id) ? @Auth::guard('client')->user()->id : 1;
                        $input['updated_by'] = (@Auth::guard('client')->user()->fname) ? @Auth::guard('client')->user()->fname : 'Gemino';
                        $input['updated_date_time'] = now();
                        $service->update($input);
                        $service_detail = [
                            'id' => $request['id'],
                            'code' => $service->code,
                            'description' => $service->description,
                            'status' => $service->status,
                        ];
                        return sendDataHelper('Reason Of Refund Master modify successfully.', $service_detail, 200);
                    }else{
                        return sendError('please provide valid id.', [], 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
    //sac code master list add & edit
    public function sacCodeList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = CodeTypeMaster::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All sac code detail list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function sacCodeAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $data = decryptData($request['response']);
        if(@$data['type'] == 1){
            $validator = Validator::make((array)$data,[
                'code' => 'required|unique:code_type_masters',
                'description' => 'required|unique:code_type_masters',
            ]); 
        }else{
            $validator = Validator::make((array)$data,[
                'id' => 'required',
                'code' => 'sometimes|required|unique:code_type_masters,code,'.@$request['id'],
                'description' => 'sometimes|required|unique:code_type_masters,description,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$data['type'] == 1){
                    $advance_detail = CodeTypeMaster::create([
                        'code' => $data['code'],
                        'description' => $data['description'],  
                        'status' => 1  
                    ])->id;
                    $advance = [
                        'id' => $advance_detail,
                        'code' => $data['code'],
                        'description' => $data['description'],  
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('SAC code detail add successfully.', $advance, 200);  
                }else{
                    $find_data = CodeTypeMaster::find($data['id']);
                    if($find_data){
                        $find_data->update([
                            'status' => (isset($data['status'])) ? @$data['status'] : $find_data->status,
                            'code' => (@$data['code'] != null) ? @$data['code'] : $find_data->code,
                            'description' => (@$data['description'] != null) ? @$data['description'] : $find_data->description
                        ]);
                        $advance = [
                            'id' => $data['id'],
                            'code' => $find_data->code,
                            'description' => $find_data->description
                        ];
                        DB::commit();
                        return sendDataHelper('SAC code detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400); 
            }
        }
    }
    //specialization list add & edit
    public function specializationList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = Specialization::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Specialization detail list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function specializationAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:specializations',
                'description' => 'required|unique:specializations',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'status' => 'sometimes|required',
                'description' => 'sometimes|required|unique:specializations,description,'.@$request['id'],
                'code' => 'sometimes|required|unique:specializations,code,'.@$request['id'],
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$request['type'] == 1){
                    $specialization = Specialization::create($request)->id;
                    $advance = [
                        'id' => $specialization,
                        'code' => $request['code'],
                        'description' => $request['description'],  
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('Specialization detail add successfully.', $advance, 200);  
                }else{
                    $find_data = Specialization::find($request['id']);
                    if($find_data){
                        if(isset($request['status'])){
                            $add['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $add['code'] = @$request['code'];
                        }
                        if(@$request['description']){
                            $add['description'] = @$request['description'];
                        }
                        $find_data->update($add);
                        $advance = [
                            'id' => $request['id'],
                            'code' => $find_data->code,
                            'description' => $find_data->description
                        ];
                        DB::commit();
                        return sendDataHelper('Specialization detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400); 
            }
        }
    }
    //sub specialization list add & edit
    public function subSpecializationList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = SubSpecialization::join('specializations','specializations.id','=','sub_specializations.s_id');
            if(isset($search))
            {
                $description->where('sub_specializations.description', 'like', "%{$search}%");
            }
            $response = $description->select('sub_specializations.id','sub_specializations.code','sub_specializations.description','sub_specializations.status','specializations.id as s_id','specializations.description as specialization')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Sub Specialization detail list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function subSpecializationAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:sub_specializations',
                'description' => 'required|unique:sub_specializations',
                's_id' => 'required',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'description' => 'sometimes|required|unique:sub_specializations,description,'.@$request['id'],
                'code' => 'sometimes|required|unique:sub_specializations,code,'.@$request['id'],
                's_id' => 'sometimes|required',
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$request['type'] == 1){
                    $specialization = SubSpecialization::create($request)->id;
                    $advance = [
                        'id' => $specialization,
                        'code' => $request['code'],
                        'description' => $request['description'],  
                        'specialization_id' => $request['s_id'],  
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('Sub Specialization detail add successfully.', $advance, 200);  
                }else{
                    $find_data = SubSpecialization::find($request['id']);
                    if($find_data){
                        if(isset($request['status'])){
                            $add['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $add['code'] = @$request['code'];
                        }
                        if(@$request['description']){
                            $add['description'] = @$request['description'];
                        }
                        if(@$request['s_id']){
                            $add['s_id'] = @$request['s_id'];
                        }
                        $find_data->update($add);
                        $advance = [
                            'id' => $request['id'],
                            'code' => $find_data->code,
                            's_id' => $find_data->s_id,
                            'description' => $find_data->description
                        ];
                        DB::commit();
                        return sendDataHelper('Sub Specialization detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400); 
            }
        }
    }
    //mode Payment list add & edit
    public function modePaymentList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                    $search = @$request['description'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $description = ModeOfPayment::query();
            if(isset($search))
            {
                $description->where('description', 'like', "%{$search}%");
            }
            $response = $description->select('id','code','description','json_text','status')->get();

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('All Mode Payment detail list.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function modePaymentAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'response' => 'required'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $request = decryptData($request['response']);
        if(@$request['type'] == 1){
            $validator = Validator::make((array)$request,[
                'code' => 'required|unique:mode_of_payments',
                'description' => 'required|unique:mode_of_payments',
            ]); 
        }else{
            $validator = Validator::make((array)$request,[
                'id' => 'required',
                'description' => 'sometimes|required|unique:mode_of_payments,description,'.@$request['id'],
                'code' => 'sometimes|required|unique:mode_of_payments,code,'.@$request['id'],
                'status' => 'sometimes|required',
            ]);
        }
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{
            try{
                DB::beginTransaction();
                if(@$request['type'] == 1){ 
                    $request['status'] = 1;
                    $request['json_text'] = implode(",",$request['json_text']);
                    $mode_pay = ModeOfPayment::create($request)->id;
                    $advance = [
                        'id' => $mode_pay,
                        'code' => $request['code'],
                        'description' => $request['description'],   
                        'json_text' => $request['json_text'],   
                        'status' => 1  
                    ];
                    DB::commit();
                    return sendDataHelper('Mode Payment detail add successfully.', $advance, 200);  
                }else{
                    $find_data = ModeOfPayment::find($request['id']);
                    if($find_data){
                        if(isset($request['status'])){
                            $add['status'] = @$request['status'];
                        }
                        if(@$request['code']){
                            $add['code'] = @$request['code'];
                        }
                        if(@$request['description']){
                            $add['description'] = @$request['description'];
                        }
                        if(@$request['json_text']){
                            $add['json_text'] = implode(",",$request['json_text']);
                        }
                        $find_data->update($add);
                        $advance = [
                            'id' => $request['id'],
                            'code' => $find_data->code,
                            'description' => $find_data->description,
                            'json_text' => $find_data->json_text
                        ];
                        DB::commit();
                        return sendDataHelper('Mode Payment detail edit successfully.', $advance, 200);  
                    }else{
                        return sendErrorHelper('Error', 'Please send valid id.', 400);
                    }
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400); 
            }
        }
    }
}
