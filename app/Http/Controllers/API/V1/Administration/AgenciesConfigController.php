<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\API\V1\Agency\AgenciesClinicLinking;
use App\Models\API\V1\Agency\AgenciesMaster;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\Agency\AgenciesServicesLinking;
use App\Models\API\V1\Agency\AgenciesSpecialization;
use App\Models\API\V1\Agency\AgenciesContact;
use App\Models\API\V1\Master\Specialization;
use App\Models\API\V1\Master\SubSpecialization;

class AgenciesConfigController extends Controller
{
    public function getSpecializationList()
    {
        DB::beginTransaction();
        try {
            $specialization = Specialization::select('id', 'code', 'description', 'status')->whereStatus(1)->get();

            return sendDataHelper("Specialization list lodded successfully.", $specialization, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function getClinicList()
    {
        DB::beginTransaction();
        try {
            $clientID = auth()->user()->id; //check user auhentication it should be client
            $specialization = Unit::select('id', 'dept_id', 'store_id', 'code', 'description', 'clinic_name', 'status')->whereStatus(1)->where('c_id', $clientID)->get();

            return sendDataHelper("Client list lodded successfully.", $specialization, $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /** Agency */
    public function addAgency(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'code' => "required|unique:agencies_masters,code",
                'description' => "required|unique:agencies_masters,description",
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }
            $clientID = auth()->user()->id;
            $data['client_id'] = $clientID;
            $data['status'] = 1;
            $response = AgenciesMaster::create($data);
            $insertedID = $response->id;

            if ($data['specializations']) {
                $allSpecialize = explode(',', $data['specializations']);
                // return $allSpecialize;
                $insertSpecializations = [];
                foreach ($allSpecialize as $key => $value) {
                    $insertSpecializations[] = ['agency_id' => $insertedID, 'specialization_id' => $value, 'status' => 1];
                }
                $responseOfSpe = AgenciesSpecialization::insert($insertSpecializations);
                if (!$responseOfSpe) {
                    DB::rollBack();
                    return sendError('Something is wrong while add Agencies specialization, Please try again.', [], 422);
                }
                DB::commit();
            }

            if ($data['contacts']) {
                $contactList = $data['contacts'];
                $insertContacts = [];
                foreach ($contactList as $key => $value) {
                    $insertContacts[$key] = $value;
                    $insertContacts[$key]['agency_id'] = $insertedID;
                }
                $responseOfCon = AgenciesContact::insert($insertContacts);
                if (!$responseOfCon) {
                    DB::rollBack();
                    return sendError('Something is wrong while add Agencies contacts, Please try again.', [], 422);
                }
                DB::commit();
            }

            if ($response) {
                DB::commit();
                return sendDataHelper('Agency added successfully', $response, $code = 200);
            } else {
                return sendError("Agency not added", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }


    public function searchAgency(Request $request)
    {
        try {

            if (respValid($request)) {
                return respValid($request);
            }

            $data = decryptData($request['response']);

            $agencyData  = AgenciesMaster::select('id', 'code', 'description', 'status');
            if (isset($data['search_description'])) {
                $agencyData->where('description', 'like', '%' . $data['search_description'] . '%');
            }

            $agencyData = $agencyData->get();

            if ($agencyData) {
                return sendDataHelper("Agency list list loadded", $agencyData, $code = 200);
            } else {
                return sendError("Agency list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function updateAgencyStatus(Request $request, $id)
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

            if (AgenciesMaster::where('id', $id)->update(['status' => $data['status']])) {
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

    public function updateAgency(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $validation = Validator::make((array)$data, [
                'code' => "required|unique:agencies_masters,code," . $id,
                'description' => "required|unique:agencies_masters,description," . $id,
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }
            $agentData['code'] =  $data['code'];
            $agentData['description'] =  $data['description'];
            $agentData['address'] =  ($data['address']) ? $data['address'] : null;
            $agentData['country_id'] =  ($data['country_id']) ? $data['country_id'] : null;
            $agentData['state_id'] =  ($data['state_id']) ? $data['state_id'] : null;
            $agentData['city_id'] =  ($data['city_id']) ? $data['city_id'] : null;
            $agentData['pincode'] =  ($data['pincode']) ? $data['pincode'] : null;
            if (AgenciesMaster::where('id', $id)->update($agentData)) {

                if ($data['specializations']) {
                    $deleteSpe = AgenciesSpecialization::where(['agency_id' => $id])->delete();
                    if ($deleteSpe) {
                        $allSpecialize = explode(',', $data['specializations']);
                        // return $allSpecialize;
                        $insertSpecializations = [];
                        foreach ($allSpecialize as $key => $value) {
                            $insertSpecializations[] = ['agency_id' => $id, 'specialization_id' => $value, 'status' => 1];
                        }
                        $responseOfSpe = AgenciesSpecialization::insert($insertSpecializations);
                        if (!$responseOfSpe) {
                            DB::rollBack();
                            return sendError('Something is wrong while add Agencies specialization, Please try again.', [], 422);
                        }
                        DB::commit();
                    }
                }

                if ($data['contacts']) {
                    $deleteSpe = AgenciesContact::where(['agency_id' => $id])->delete();
                    if ($deleteSpe) {
                        $contactList = $data['contacts'];
                        $insertContacts = [];
                        foreach ($contactList as $key => $value) {
                            $insertContacts[$key] = $value;
                            $insertContacts[$key]['agency_id'] = $id;
                        }
                        $responseOfCon = AgenciesContact::insert($insertContacts);
                        if (!$responseOfCon) {
                            DB::rollBack();
                            return sendError('Something is wrong while add Agencies contacts, Please try again.', [], 422);
                        }
                        DB::commit();
                    }
                }
                DB::commit();
                return sendDataHelper('Agency updated successfully', [], $code = 200);
            } else {
                return sendError("Agency not updated", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function addAgencyLinkWithClinic(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }
            $data = decryptData($request['response']);
            $validation = Validator::make((array)$data, ['unit_id' => "required", 'agency_ids' => "required"]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $allAgency = explode(',', $data['agency_ids']);


            $insertAgency = [];
            foreach ($allAgency as $key => $value) {
                $insertAgency[] = ['agency_id' => $value, 'unit_id' => $data['unit_id'], 'status' => 1];
            }
            $deleteSpe = AgenciesClinicLinking::where(['unit_id' => $data['unit_id']])->delete();

            $responseOfAgenciesLink = AgenciesClinicLinking::insert($insertAgency);

            if ($responseOfAgenciesLink) {
                DB::commit();
                return sendDataHelper('Clininc linked successfully', $responseOfAgenciesLink, $code = 200);
            } else {
                return sendError('Something is wrong while add link clinic with Agencies, Please try again.', [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getAgencyLinkWithClinic(Request $request, $id)
    {
        try {


            $clientID = auth()->user()->id;
            $response = DB::table('agencies_masters AS AGM')->leftJoin('agencies_clinic_linkings AS ACM', function ($join) use ($id) {
                $join->on('ACM.agency_id', '=', 'AGM.id')->where('ACM.unit_id', $id);
            })->where('AGM.client_id', $clientID)->where('AGM.status', 1)
                ->select('AGM.id', 'AGM.code', 'AGM.description', 'AGM.status', DB::Raw('IFNULL(ACM.id,0) AS is_selected'));

            $responseData = $response->get();

            if ($responseData) {
                return sendDataHelper("Agency list list loadded", $responseData, $code = 200);
            } else {
                return sendError("Agency list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getAgencyLinkWithService(Request $request)
    {
        try {
            $clientID = auth()->user()->id;
            $clinicList = Unit::select('id', 'dept_id', 'store_id', 'code', 'description', 'clinic_name', 'status')->whereStatus(1)->where('c_id', $clientID)->get();
            $returnArray = [];
            if ($clinicList && count($clinicList) > 0) {
                foreach ($clinicList as $key => $clinic) {
                    $unit_id = $clinic->id;
                    $agenciesClinicData = DB::table('agencies_clinic_linkings AS ACM')->join('agencies_masters AS AGM', 'ACM.agency_id', '=', 'AGM.id')
                        ->where('ACM.unit_id', $unit_id)->select('AGM.id', 'AGM.code', 'AGM.description', 'AGM.status')->get();
                    $returnArray[$key] = $clinic;
                    $returnArray[$key]['agenc_list'] = $agenciesClinicData;
                }
            }

            if (count($clinicList) > 0) {
                return sendDataHelper("Agency list list loadded", $returnArray, $code = 200);
            } else {
                return sendError("Agency list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }


    public function addAgencyLinkWithService(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }
            $data = decryptData($request['response']);
            $validation = Validator::make((array)$data, [
                'unit_id' => "required",
                'agency_id' => "required",
                'specialization_id' => "required",
                'sub_specialization_id' => "required",
                'linked_services' => "required"
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $deleteSpe = AgenciesServicesLinking::where(['unit_id' => $data['unit_id']])->where(['agency_id' => $data['agency_id']])->delete();

            $data['status'] = 1;
            $response = AgenciesServicesLinking::create($data);
            if ($response) {
                DB::commit();
                return sendDataHelper('Service linked successfully', $response, $code = 200);
            } else {
                return sendError("Service can not linked ", [], 422);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function getLinkedService(Request $request)
    {

        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }
            $data = decryptData($request['response']);
            $validation = Validator::make((array)$data, [
                'unit_id' => "required",
                'agency_id' => "required",
                'specialization_id' => "required",
                'sub_specialization_id' => "required",
            ]);

            if ($validation->fails()) {
                return sendError($validation->errors()->first(), [], 422);
            }

            $responseData = AgenciesServicesLinking::where(['unit_id' => $data['unit_id']])->where(['agency_id' => $data['agency_id']])->first();

            if ($responseData) {
                // $returnArray['linked_agency'] = $getListOfAgency;
                $serviceList = ServiceMaster::where(['unit_id' => $data['unit_id']])
                    ->where(['specialization_id' => $data['specialization_id']])
                    ->where(['sub_specialization_id' => $data['sub_specialization_id']])
                    ->select('id', 'code', 'description', DB::raw('(CASE WHEN id IN (' . $responseData->linked_services . ') THEN 1 ELSE 0 END) AS is_selected'))
                    ->get();
                $responseData->service_list = $serviceList;
            }

            if ($responseData) {
                return sendDataHelper("Agency list list loadded", $responseData, $code = 200);
            } else {
                return sendError("Agency list not found", [], 204);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
