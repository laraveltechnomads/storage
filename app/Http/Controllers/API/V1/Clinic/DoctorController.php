<?php

namespace App\Http\Controllers\API\V1\Clinic;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /*List view & search to view */
    public function index(Request $request)
    {
        try {
            $query = Doctor::query();
            $query->join('specializations','doctors.s_id', 'specializations.id');
            $query->join('sub_specializations','doctors.su_id', 'sub_specializations.id');
            $query->join('doctor_types','doctors.doc_type_id', 'doctor_types.id');
            $query->join('doctor_categories','doctors.doc_cat_id', 'doctor_categories.id');
            $query->select('doctors.*', 'doctor_types.description as doctor_type_name', 'doctor_categories.description as doctor_category_name','specializations.description as specialization_name', 'sub_specializations.description as sub_specialization_name');
            if(isset($request['search_description'])) {
                $query->where('doctors.first_name', 'like', '%' . $request['search_description'] . '%')->orWhere('doctors.last_name', 'like', '%' . $request['search_description'] . '%')->get();
            }
            $response = $query->get();
            if ($response) {
                return sendDataHelper("Doctores List", $response, $code = 200);
            } else {
                return sendError("Doctores list not found", [],204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Store doctor list */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) 
            {
                $datareq['photo'] = $request['photo'];
            }

            if ($request->hasFile('signature'))
            {
                $datareq['signature'] = $request['signature'];
            }

            if ($request->hasFile('documents'))
            {
                $datareq['documents'] = $request['documents'];
            }

            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $get_data = decryptData($request['response']); /* Dectrypt  **/

            $validation = Validator::make((array)$get_data,[
                'step' => 'required'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            switch ($get_data['step']) {
                case 1:
                    $validation = Validator::make((array)$get_data,[
                        'first_name' => 'required',
                        'middle_name' => 'sometimes',
                        'last_name' => 'sometimes',
                        'gender_id' => 'required|exists:genders,id',
                        'date_of_birth' => 'date|date_format:Y-m-d',
                        's_id' => 'required|exists:specializations,id',
                        'su_id' => 'required|exists:sub_specializations,id',
                        'doc_type_id' => 'sometimes|exists:doctor_types,id',
                        'doc_cat_id' => 'sometimes|exists:doctor_categories,id',
                        'signature' => 'sometimes',
                        'photo' => 'sometimes',
                        'documents' => 'sometimes'
                    ]);
                    break;
                case 2:
                    $validation = Validator::make((array)$get_data,[
                        'marital_status' => 'required|exists:marital_statuses,id',
                        'employee_no' => 'sometimes',
                        'pf_no' => 'numeric',
                        'pan_no' => 'sometimes',
                        'email_address' => 'sometimes|email|unique:doctors,email_address',
                        'access_card_no' => 'sometimes',
                        'date_of_joining' => 'date|date_format:Y-m-d',
                        'registration_number' => 'sometimes',
                        'experience' => 'sometimes',
                        'education' => 'sometimes'
                    ]);
                    break;
                case 3:
                    $validation = Validator::make((array)$get_data,[
                        'step' => 'required',
                        'departments' => 'sometimes'
                    ]);
                    break;
                case 4:
                    $validation = Validator::make((array)$get_data,[
                        'classifications' => 'sometimes'
                    ]);
                    break;
                
                default:
                    
                    break;
            }
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }
            if($get_data['step'] === 4)
            {
                if (@$datareq['photo']) {
                    $get_data['photo'] = uploadFile($datareq['photo'], doctor_profile_dir(), 'doc_p');
                }

                if (@$datareq['signature']) {
                    $get_data['signature'] = uploadFile($datareq['signature'], doctor_signature_dir(), 'doc_s');
                }
                if (@$datareq['documents']) {
                    $get_data['documents'] = uploadFile($datareq['documents'], doctor_documents_dir(), 'doc_d');
                }
                $store_data = Doctor::create($get_data);
                if($store_data) {
                    DB::commit();
                    return sendDataHelper('List Added', $store_data, $code = 200);
                }
            }else{
                $response = [
                    'next_step' => $get_data['step'] + 1
                ];
                return sendDataHelper('List Added', $response, $code = 200);
            }
            return sendError("Record not found", [], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Doctores list update*/
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $doctor = Doctor::where('id', $id)->first();
            if(!$doctor)
            {
                return sendError("Record not found", [], 422);
            }
            if ($request->hasFile('photo')) 
            {
                $datareq['photo'] = $request['photo'];
            }

            if ($request->hasFile('signature')) 
            {
                $datareq['signature'] = $request['signature'];
            }

            if ($request->hasFile('documents')) 
            {
                $datareq['documents'] = $request['documents'];
            }

            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $get_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($get_data,[
                'step' => 'required'
            ]);
        
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $validation = Validator::make((array)$get_data,[
                'first_name' => 'required',
                'middle_name' => 'sometimes',
                'last_name' => 'sometimes',
                'gender_id' => 'required|exists:genders,id',
                'date_of_birth' => 'date|date_format:Y-m-d',
                's_id' => 'required|exists:specializations,id',
                'su_id' => 'required|exists:sub_specializations,id',
                'doc_type_id' => 'sometimes|exists:doctor_types,id',
                'doc_cat_id' => 'sometimes|exists:doctor_categories,id',
                'signature' => 'sometimes',
                'photo' => 'sometimes',
                'documents' => 'sometimes'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $validation = Validator::make((array)$get_data,[
                'marital_status' => 'required|exists:marital_statuses,id',
                'employee_no' => 'sometimes',
                'pf_no' => 'numeric',
                'pan_no' => 'sometimes',
                'email_address' => 'sometimes|email|required|unique:doctors,email_address,'.$id,
                'access_card_no' => 'sometimes',
                'date_of_joining' => 'date|date_format:Y-m-d',
                'registration_number' => 'sometimes',
                'experience' => 'sometimes',
                'education' => 'sometimes'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $validation = Validator::make((array)$get_data,[
                'departments' => 'sometimes'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            $validation = Validator::make((array)$get_data,[
                'classifications' => 'sometimes'
            ]);
            if($validation->fails()){
                return sendError($validation->errors()->first(), [], 422);
            }

            if (@$datareq['photo']) {
                deleteFile($doctor->photo,doctor_profile_dir());
                $get_data['photo'] = uploadFile($datareq['photo'], doctor_profile_dir(), 'doc_p');
            }

            if (@$datareq['signature']) {
                deleteFile($doctor->signature,doctor_signature_dir());
                $get_data['signature'] = uploadFile($datareq['signature'], doctor_signature_dir(), 'doc_s');
            }

            if (@$datareq['documents']) {
                deleteFile($doctor->signature,doctor_documents_dir());
                $get_data['documents'] = uploadFile($datareq['documents'], doctor_documents_dir(), 'doc_d');
            }
            $doctor['email_address'] = $get_data['email_address'];
            $store_data = $doctor->update($get_data);
            if($store_data) {
                DB::commit();
                return sendDataHelper('List updated', $store_data, $code = 200);
            }
            return sendError("Record not updated", [], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function doctorUpdateStatus(Request $request, $id)
    {
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
            $result = Doctor::where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);
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

    /* Selected doctor list */
    public function show(Request $request, $id)
    {
        try {
            $query = Doctor::query();
            $query->where('doctors.id', $id);
            $query->join('specializations','doctors.s_id', 'specializations.id');
            $query->join('sub_specializations','doctors.su_id', 'sub_specializations.id');
            $query->join('doctor_types','doctors.doc_type_id', 'doctor_types.id');
            $query->join('doctor_categories','doctors.doc_cat_id', 'doctor_categories.id');
            $query->select('doctors.*', 'doctor_types.description as doctor_type_name', 'doctor_categories.description as doctor_category_name','specializations.description as specialization_name', 'sub_specializations.description as sub_specialization_name');
            $response = $query->first();
            if ($response) {
                return sendDataHelper("Doctores List", $response, $code = 200);
            } else {
                return sendError("Doctores list not found", [],204);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
