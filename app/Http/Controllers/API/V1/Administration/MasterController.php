<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\BankMaster;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Master\UnitDepartmentDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    /* Clinic details */
    public function allTablesList(Request $request)
    {
        $search = $search = $request->search ? $request->search : null;
        $dbName = request()->segment(6);
        try {
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));

            $query = DB::table($dbName);
            switch ($dbName) {
                case 'classifications':
                    $query->orWhere('description', 'like', '%' . $search . '%');
                    break;
                case 'trans_types':
                    $query->orWhere('description', 'like', '%' . $search . '%');
                    break;                    
                default:
                    break;
            }
            $response = $query->get();

            return sendDataHelper("$message table details", $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Sub table details */
    /*
    -ot_table_masters
    -procedure_sub_category_masters
    -sub_specializations
    */

    public function allSubList(Request $request)
    {   
        $id = $request->route('id');
        $dbName = request()->segment(6);
        try {
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            
            $query = DB::table($dbName);
            $query->where('status',1);
            
            switch ($dbName) {
                case 'ot_table_masters':
                    $query->where('ot_id', $id);
                    break;
                case 'procedure_sub_category_masters':
                    $query->where('procedure_cat_id', $id);
                    break;
                case 'sub_specializations':
                    $query->where('s_id', $id);
                    break;
                case 'states':
                    $query->where('country_id', $id);
                    break;
                case 'cities':
                    $query->where('state_id', $id);
                    break;
                default:
                    break;
            }

            $response = $query->get();

            if ($response) {
                DB::commit();
                return sendDataHelper("$message table details", $response, $code = 200);
            } else {
                return sendError("$message not added", [], 422);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function allUnitDeptList(Request $request)
    {   
        $id = $request->route('id');
        $dbName = request()->segment(6);
        try {
            $response = [];
            $get_data = Unit::select('id', 'clinic_name')->where('status', 1)->get();
            $arr = [];
            foreach ($get_data as $key => $value) {
                $arr['unit_id'] = $value->id;
                $arr['clinic_name'] = $value->clinic_name;
                $arr['departments'] = UnitDepartmentDetails::join('units','unit_department_details.unit_id', '=', 'units.id')
                ->join('departments','unit_department_details.department_id', '=', 'departments.id')
                ->where(['unit_department_details.status' => 1, 'units.id' => $value->id, 'departments.status' => 1])
                ->select('unit_department_details.unit_id', 'unit_department_details.department_id','departments.description',)
                ->get();
                array_push($response, $arr);
            }
            return sendDataHelper("Units & department details", $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
