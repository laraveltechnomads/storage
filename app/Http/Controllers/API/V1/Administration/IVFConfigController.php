<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IVFConfigController extends Controller
{
    /** Item Category */
    /**
     * 1. Needle  = needles
     * 2. Type of Needle  = type_of_needles
     * 3. Sperm Preparation  = sperm_preparations
     * 4. Tank  = tanks
     * 5. Cane  = canes
     * 6. Canister  = canisters
     * 7. Straw/Vials  = straw_or_vials
     * 8. Goblet Color  = goblet_colors
     * 9. ET Pattern Master  = et_pattern_masters
     * 10. Built Master  = built_masters
     * 11. Eye Color  = eye_colors
     * 12. Skin Color  = skin_colors
     * 13. Hair Color  = hair_colors
     * 14. Catheter Type  = catheter_types
     * 15. Difficulty Type  = difficulty_types
     * 16. Laboratory Master  = laboratory_masters
     * 17. Surrogate Agency Master  = surrogate_agency_masters

     */
    public function ivfCommonAddConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            if ($dbName == 'surrogate_agency_masters') {
                $validation = Validator::make((array)$data, [
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    'referral_name' => "required",
                ]);
            } else {
                $validation = Validator::make((array)$data, [
                    // 'unit_id' => 'required',
                    'code' => "required|unique:$dbName,code",
                    'description' => "required|unique:$dbName,description",
                    //created_unit_id, updated_unit_id, added_by, added_on, added_date_time, updated_by, updated_on, updated_date_time, added_windows_login_name, update_windows_login_name, synchronized
                ]);
            }
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

    public function ivfCommonSearchListConfig(Request $request)
    {
        try {
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            if (isset($data['search_description'])) {
                $response = DB::table($dbName)->where('description', 'like', '%' . $data['search_description'] . '%')->get();
            } else {
                $response = DB::table($dbName)->get();
            }

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

    public function ivfCommonUpdateStatusConfig(Request $request)
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

    public function ivfCommonUpdateItemConfig(Request $request)
    {
        DB::beginTransaction();
        try {
            $id =  $request->route('id');
            if (respValid($request)) {
                return respValid($request);
            }  /* response required validation */
            $data = decryptData($request['response']); /* Dectrypt  **/
            $dbName = request()->segment(6);
            if ($dbName == 'surrogate_agency_masters') {
                $validation = Validator::make((array)$data, [
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,
                    'referral_name' => "required",
                ]);
            } else {
                $validation = Validator::make((array)$data, [
                    // 'unit_id' => 'required',
                    'code' => "required|unique:$dbName,code," . $id,
                    'description' => "required|unique:$dbName,description," . $id,

                ]);
            }

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
}