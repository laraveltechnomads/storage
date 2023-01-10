<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClinicConfigController extends Controller
{
    /*
    - departments
    - designation_masters
    - primary_symptoms
    - bank_masters
    - bank_branch_masters
    - countries
    - states
    - cities
    - region_masters
    - adhesions
    - emr_field_values
    - cash_counters
    - emr_chief_complaints
    - employees
    - doctor_categories
    - doctor_types
    - classifications
    */

    public function clinicCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);

            if($dbName == 'employees')
            {
                $validation = Validator::make((array)$data,[
                    'image' => "sometimes|image|mimes:jpeg,png,jpg|max:2000|dimensions:width=64,height=64"
                ]);  
                if($validation->fails()){
                    return sendError($validation->errors()->first(), [], 422);
                }

                if ($request->hasFile('image')) 
                {
                    $datareq['image'] = $request['image'];
                }
            }

            if($dbName == 'bank_branch_masters') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    'bank_id' => "required",
                    'micr_number' => "required",
                ]);    
            }elseif($dbName == 'departments') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    'is_clinical' => "required",
                ]);    
            }elseif($dbName == 'classifications') {
                $validation = Validator::make((array)$data,[
                    'cf_code' => "required|unique:$dbName,cf_code",
                    'description' => "required|unique:$dbName,description"
                ]);    
            }elseif($dbName == 'countries') { 
                $validation = Validator::make((array)$data,[
                    'country_code' => "required|unique:$dbName,country_code",
                    'country_name' => "required|unique:$dbName,country_name",
                    'default_country' => "sometimes",
                    'nationality' => "required",
                    'default_state' => "sometimes"
                ]);    
            }elseif($dbName == 'states') { 
                $validation = Validator::make((array)$data,[
                    'state_code' => "required",
                    'country_id' => "required|exists:countries,id",
                    'state_name' => "required|unique:$dbName,state_name"
                ]);    
            }elseif($dbName == 'cities') { 
                $validation = Validator::make((array)$data,[
                    'city_code' => "required",
                    'state_id' => "required|exists:states,id",
                    'country_id' => "required|exists:countries,id",
                    'city_name' => "required|unique:$dbName,city_name"
                ]);    
            }elseif($dbName == 'region_masters') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'region' => "required|unique:$dbName,region",
                    'country_id' => "required|exists:countries,id",
                    'state_id' => "required|exists:states,id",
                    'city_id' => "required|exists:cities,id",
                    'pin_code' => "required|digits:6"
                ]);    
            }elseif($dbName == 'emr_field_values') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    'used_for' => "required|exists:adhesions,id",
                ]);    
            }elseif($dbName == 'cash_counters') {
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    'unit_id' => "required|exists:units,id",
                ]);    
            }elseif($dbName == 'employees') {
                $validation = Validator::make((array)$data,[
                    'first_name' => "sometimes",
                    'last_name' => "sometimes",
                    'dob' => "sometimes",
                    'mobile_number' => "sometimes|min:6|max:15|unique:$dbName,mobile_number",
                    'blood_group_id' => "sometimes|exists:blood_groups,id",
                    'address' => "required",
                    'gender' => "required|exists:genders,id",
                    'designation_id' => "required|exists:designation_masters,id",
                    'unit_id' => "required|exists:units,id",
                    'date_of_joining' => "sometimes",
                    'marital_status' => "required|exists:marital_statuses,id",
                    'employee_no' => "sometimes",
                    'pf_no' => "sometimes",
                    'pan_no' => "sometimes",
                    'email_address' => "sometimes|unique:$dbName,email_address",
                    'education' => "sometimes",
                    'photo' => "sometimes|image|mimes:jpeg,png,jpg|max:2000|dimensions:width=64,height=64",
                    'discharge_approval' => "sometimes"
                ]);    
            }else {
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                ]);
            }
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            
            if($dbName == 'employees')
            {
                if (@$datareq['image']) {
                    $request['image'] = uploadFile($datareq['image'], employee_img_dir(), 'emp_p');
                }
            }

            $response = DB::table($dbName)->insert($data);
            if ($response) {
                DB::commit();
                return sendDataHelper("$message added successfully", $response, $code = 200);
            } else {
                return sendError("$message not added", [],422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }                                                                                                                                                                                                                                                                                                                                                                   

    public function clinicCommonSearchListConfig(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            
            $search = null;
            if(isset($data['search_description']) ) {
                $search =  $data['search_description'];
            }

            $query = DB::table($dbName);
            
            switch ($dbName) {
                case 'employees':
                    break;
                case 'bank_branch_masters':
                    $query->join('bank_masters', 'bank_branch_masters.bank_id', '=', 'bank_masters.id');
                    $query->select('bank_masters.description as bank_name','bank_branch_masters.*');
                    break;
                case 'states':
                    $query->join('countries', 'states.country_id', '=', 'countries.id');
                    $query->select('countries.country_name','states.*');
                    break;
                case 'cities':
                    $query->join('states', 'cities.state_id', '=', 'states.id');
                    $query->join('countries', 'states.country_id', '=', 'countries.id');
                    $query->select('countries.country_name', 'countries.id as country_id', 'states.state_name','cities.*');
                    break;

                case 'region_masters':
                    $query->join('countries', 'region_masters.country_id', '=', 'countries.id');
                    $query->join('states', 'region_masters.state_id', '=', 'states.id');
                    $query->join('cities', 'region_masters.city_id', '=', 'cities.id');
                    $query->select('countries.country_name', 'states.state_name','cities.city_name', 'region_masters.*');
                    break;
                case 'cash_counters':
                    
                    $query->join('units', 'cash_counters.unit_id', '=', 'units.id');
                    $query->select('units.clinic_name', 'cash_counters.*');
                    $query->Where('cash_counters.description', 'like', '%' . $search . '%');
                    break;
                
                default:
                    $query->where('description', 'like', '%' . $search . '%');
                    break;
            }   

            $response = $query->get();
            
            if ($response) {
                return sendDataHelper("$message List", $response, $code = 200);
            } else {
                return sendError("$message list not found", [],204);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function clinicCommonUpdateStatusConfig(Request $request)
    {
        $id = $request->route('id');
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data,[
                'status' => 'required|in:1,0',
            ]);
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $dbName = request()->segment(6);
            $result = DB::table($dbName)->where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper('Status updated successfully',[], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function clinicCommonUpdateItemConfig(Request $request)
    {
        $id = $request->route('id');
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            if($dbName == 'bank_branch_masters') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                    'bank_id' => "required",
                    'micr_number' => "required",
                ]);
            }elseif($dbName == 'departments') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                    'is_clinical' => "sometimes",
                ]);    
            }elseif($dbName == 'classifications') { 
                $validation = Validator::make((array)$data,[
                    'cf_code' => "required|unique:$dbName,cf_code," . $id,
                    'description' => "required|unique:$dbName,description," . $id
                ]);    
            }elseif($dbName == 'countries') { 
                $validation = Validator::make((array)$data,[
                    'country_code' => "required|unique:$dbName,country_code," . $id,
                    'country_name' => "required|unique:$dbName,country_name," . $id,
                    'default_country' => "sometimes",
                    'nationality' => "required",
                    'default_state' => "sometimes"
                ]);    
            }elseif($dbName == 'states') { 
                $validation = Validator::make((array)$data,[
                    'state_code' => "required|unique:$dbName,state_code," . $id,
                    'country_id' => "required|exists:countries,id",
                    'state_name' => "required|unique:$dbName,state_name," . $id,
                ]);    
            }elseif($dbName == 'cities') { 
                $validation = Validator::make((array)$data,[
                    'city_code' => "required|unique:$dbName,city_code," . $id,
                    'state_id' => "required|exists:states,id",
                    'country_id' => "required|exists:countries,id",
                    'city_name' => "required|unique:$dbName,city_name," . $id,
                ]);    
            }elseif($dbName == 'region_masters') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'region' => "required|unique:$dbName,region," . $id,
                    'country_id' => "required|exists:countries,id",
                    'state_id' => "required|exists:states,id",
                    'city_id' => "required|exists:cities,id",
                    'pin_code' => "required|digits:6"
                ]);    
            }elseif($dbName == 'emr_field_values') { 
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                    'used_for' => "required|exists:adhesions,id",
                ]);    
            }elseif($dbName == 'cash_counters') {
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                    'unit_id' => "required|exists:units,id",
                ]);    
            }elseif($dbName == 'employees') {
                $validation = Validator::make((array)$data,[
                    'first_name' => "sometimes",
                    'last_name' => "sometimes",
                    'dob' => "sometimes",
                    'mobile_number' => "sometimes|unique:$dbName,mobile_number," . $id,
                    'blood_group_id' => "sometimes|exists:blood_groups,id",
                    'address' => "required",
                    'gender' => "required|exists:genders,id",
                    'designation_id' => "required|exists:designation_masters,id",
                    'unit_id' => "required|exists:units,id",
                    'date_of_joining' => "sometimes",
                    'marital_status' => "required|exists:marital_statuses,id",
                    'employee_no' => "sometimes",
                    'pf_no' => "sometimes",
                    'pan_no' => "sometimes",
                    'email_address' => "sometimes|unique:$dbName,email_address," . $id,
                    'education' => "sometimes",
                    'discharge_approval' => "sometimes"
                ]);    
            }else {
                $validation = Validator::make((array)$data,[
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                ]);
            }
     
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['updated_at'] = Carbon::now();
            $result = DB::table($dbName)->where('id', $id)->update($data);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper("$message updated successfully",[], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}