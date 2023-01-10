<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\API\V1\Master\Gender;
use App\Models\API\V1\Patients\AgentMaster;
use App\Models\API\V1\Patients\PatientRegistrationCharges;
use App\Models\API\V1\Patients\ConsultationVisitType;
use App\Models\API\V1\Billing\PackegeMaster;

class PatientConfigController extends Controller
{
    /** Item Category */
    /**
     * 1. Patient Source = patient_sources (code/description/status)
     * 2. Patient Relation Master  = patient_relation_masters (code/description/status)
     * 3. Referral Name Master  = referral_name_masters (code/description/status)
     * 4. Special Registration  = special_registrations (code/description/status)
     * 5. Preffix Master  = preffix_masters (code/description/gender_id/status)
     * 6. Nationality Master  = nationality_masters (code/description/status)
     * 7. Preferred Language Master  = preferred_language_masters (code/description/status)
     * 8. Treatment Required Master  = treatment_required_masters (code/description/status)
     * 9. Education Details Master  = education_details_masters (code/description/status)
     * 10. Camp Master  = camp_masters (code/description/status)
     * 11. Blood Group Master  = blood_groups (blood_code/description/status)
     */


    public function patientCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $validateData['description'] =  "required|unique:$dbName,description";
            if ($dbName == 'preffix_masters') {
                $validateData['code'] =  "required|unique:$dbName,code";
                $validateData['gender_id'] =  "required";
            } else if ($dbName == 'visit_types') {
                $validateData['code'] =  "required|unique:$dbName,code";
                if ($data['is_free'] && $data['is_free'] == "1") {
                    $validateData['free_days'] = "required";
                    $validateData['consultation_visit_type_id'] = "required";
                }
            } else if ($dbName == 'blood_groups') {
                $validateData['blood_code'] =  "required|unique:$dbName,blood_code";
            } else {
                $validateData['code'] =  "required|unique:$dbName,code";
            }

            $validation = Validator::make((array)$data, $validateData);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $response = DB::table($dbName)->insert($data);
            if ($response) {
                DB::commit();
                return sendDataHelper("$message added successfully", $response, $code = 200);
            } else {
                return sendError("$message not added", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function patientCommonSearchListConfig(Request $request)
    {
        try {

            $method = $request->method();
            if ($method == 'POST') {
                if (respValid($request)) {
                    return respValid($request);
                }  /* response required validation */
            }
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $response = DB::table($dbName);

            if (isset($data['search_description']) ) {
                $response->where('description', 'like', '%' . $data['search_description'] . '%');
            }
            if ($dbName == 'preffix_masters') {
                $response->join('genders', 'genders.id', '=', 'preffix_masters.gender_id')
                ->select('preffix_masters.id','preffix_masters.unit_id','preffix_masters.gender_id','genders.gender_code','genders.description AS gender','preffix_masters.code','preffix_masters.description','preffix_masters.status');
            }
            $response =  $response->get();

            if ($response) {
                return sendDataHelper("$message List", $response, $code = 200);
            } else {
                return sendError("$message list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function patientCommonUpdateStatusConfig(Request $request)
    {

        DB::beginTransaction();
        try {

            $id =  $request->route('id');

            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'status' => 'required|in:1,0',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $dbName = request()->segment(6);

            $result = DB::table($dbName)->where('id', $id)->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);

            if ($result) {
                DB::commit();
            }
            return sendDataHelper('Status updated successfully', [], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function patientCommonUpdateItemConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            $id =  $request->route('id');
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);

            $validateData['description'] =  "required|unique:$dbName,description," . $id;
            if ($dbName == 'preffix_masters') {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
                $validateData['gender_id'] =  "required";
            } else if ($dbName == 'blood_groups') {
                $validateData['blood_code'] =  "required|unique:$dbName,blood_code," . $id;
            } else if ($dbName == 'visit_types') {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
                if ($data['is_free'] && $data['is_free'] == "1") {
                    $validateData['free_days'] = "required";
                    $validateData['consultation_visit_type_id'] = "required";
                }
            } else {
                $validateData['code'] =  "required|unique:$dbName,code," . $id;
            }

            $validation = Validator::make((array)$data, $validateData);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $data['updated_at'] = Carbon::now();
            $result = DB::table($dbName)->where('id', $id)->update($data);
            if ($result) {
                DB::commit();
            }
            return sendDataHelper("$message updated successfully", [], $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getGenderCodeList()
    {
        DB::beginTransaction();
        try {
            $gender = Gender::select('id', 'gender_code', 'description')->whereStatus(1)->get();

            return sendDataHelper("Gender code list lodded successfully.", $gender, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Patient Registration Charges */
    public function addPatientRegistrationCharges(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }
            $data = decryptData($request['response']);
            $validation = Validator::make((array)$data, [
                'service_id' => "required|unique:patient_registration_charges,service_id",
                'patient_category_id' => 'required',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = PatientRegistrationCharges::where('service_id', $data['service_id'])->first();
            if ($checkRecord) {
                return sendError("Record can't be saved because this serviceice charges already exist.", [], 422);
            }

            $data['status'] = 1;
            $response = PatientRegistrationCharges::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Charges added successfully', $response, $code = 200);
            } else {
                return sendError("Charges Category not added", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchPatientRegistrationCharges(Request $request)
    {
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $response = DB::table('patient_registration_charges AS PRC')->join('service_masters AS SM', 'SM.id', '=', 'PRC.service_id')
                ->join('patient_categories AS PC', 'PC.id', '=', 'PRC.patient_category_id');

            if (isset($data['search_description'])) {
                $response->orWhere('SM.description', 'like', '%' . $data['search_description'] . '%');
                $response->orWhere('PC.description', 'like', '%' . $data['search_description'] . '%');
            }
            $response->select('PRC.id', 'PRC.unit_id', 'PRC.service_id', 'SM.description AS service_description', 'PRC.patient_category_id', 'PC.description AS patient_category_description', 'PRC.status');
            $responseDara = $response->get();

            if ($responseDara) {
                return sendDataHelper('Charges added successfully', $responseDara, $code = 200);
            } else {
                return sendError("Charges list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updatePatientRegistrationChargeStatus(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'status' => 'required|in:1,0',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            if (PatientRegistrationCharges::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Status updated successfully', [], $code = 200);
            } else {
                return sendError("Status not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updatePatientRegistrationCharges(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'service_id' => "required",
                'patient_category_id' => 'required',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $checkRecord = PatientRegistrationCharges::where('id', '!=', $id)->where('service_id', $data['service_id'])->first();
            if ($checkRecord) {
                return sendError("Record can't be saved because this serviceice charges already exist.", [], 422);
            }

            if (PatientRegistrationCharges::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Item category updated successfully', [], $code = 200);
            } else {
                return sendError("Item Category not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Patient Registration Charges */
    public function addAgent(Request $request)
    {

        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }
            $data = decryptData($request['response']);

            $requiredData['name'] = "required";
            if ($data['previouly_egg_donation'] && $data['previouly_egg_donation'] == '1') {
                $requiredData['no_of_donation_time'] = "required";
                $requiredData['donation_detail'] = "required";
            }
            if ($data['previous_surogacy_done'] && $data['previous_surogacy_done'] == '1') {
                $requiredData['no_of_surogacy_done'] = "required";
                $requiredData['surogacy_detail'] = "required";
            }

            $validation = Validator::make((array)$data, $requiredData);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $data['status'] = 1;
            $response = AgentMaster::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Agent added successfully', [], $code = 200);
            } else {
                return sendError("Agent not added. Please try again.", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchAgent(Request $request)
    {
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $response = DB::table('agent_masters AS AMS');

            if (isset($data['search_description'])) {
                $response->orWhere('AMS.name', 'like', '%' . $data['search_description'] . '%');
            }
            // $response->select('AMS.id', 'AMS.name', 'AMS.spouse_name', 'AMS.mob_country_code', 'AMS.mobile_no', 'AMS.status');
            $responseDara = $response->get();

            if ($responseDara) {
                return sendDataHelper('Agent list loadded successfully', $responseDara, $code = 200);
            } else {
                return sendError("Agent list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateAgnetStatus(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'status' => 'required|in:1,0',
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            if (AgentMaster::where('id', $id)->update(['status' => $data['status']])) {
                DB::commit();
                return sendDataHelper('Agent detail updated successfully', [], $code = 200);
            } else {
                return sendError("Agent detail status not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateAgent(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $requiredData['name'] = "required";
            if ($data['previouly_egg_donation'] && $data['previouly_egg_donation'] == '1') {
                $requiredData['no_of_donation_time'] = "required";
                $requiredData['donation_detail'] = "required";
            }
            if ($data['previous_surogacy_done'] && $data['previous_surogacy_done'] == '1') {
                $requiredData['no_of_surogacy_done'] = "required";
                $requiredData['surogacy_detail'] = "required";
            }

            $validation = Validator::make((array)$data, $requiredData);
            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }


            if (AgentMaster::where('id', $id)->update($data)) {
                DB::commit();
                return sendDataHelper('Agent detail updated successfully', [], $code = 200);
            } else {
                return sendError("Agent detail not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getConsultationVisitType()
    {
        DB::beginTransaction();
        try {
            $gender = ConsultationVisitType::select('id', 'code', 'description')->whereStatus(1)->get();

            return sendDataHelper("Consultation list lodded successfully.", $gender, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getPackegeList()
    {
        DB::beginTransaction();
        try {
            $gender = PackegeMaster::select('id', 'code', 'description',)->whereStatus(1)->get();

            return sendDataHelper("Consultation list lodded successfully.", $gender, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
