<?php

namespace App\Http\Controllers\API\V1\Billing;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Billing\IpdBillingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BillingListController extends Controller
{
    public function billFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function billMedicineFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function billServiceFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function opdBillFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function opdBillMedicineFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function opdBillServiceFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function doctorBillFilterPageList(Request $request)
    {
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $req_data = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make($req_data,[
                'unit_id'=>'required',
                'from_date'=>'required|date_format:Y-m-d',
                'to_date'=>'required|date_format:Y-m-d|after:from_date',
            ],[
                'from_date.date' => 'From date required',
                'to_date.date' => 'To date required'
            ]);
    
            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            $from_date = date('Y-m-d', strtotime(@$req_data['from_date']) );
            $to_date = date('Y-m-d', strtotime(@$req_data['to_date']) );

            $dbName = request()->segment(6);
            $singular = Str::singular($dbName);
            $message = ucfirst(Str::replace('_', ' ', $singular));
            $response = IpdBillingList::whereBetween('date', [$from_date, $to_date])->paginate(10);
            
            return sendDataHelper("$message List", $response, $code = 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}
