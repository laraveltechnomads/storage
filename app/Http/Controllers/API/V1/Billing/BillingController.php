<?php

namespace App\Http\Controllers\API\V1\Billing;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Billing\BillMaster;
use App\Models\API\V1\Billing\ExpenseDetails;
use App\Models\API\V1\Client\ExpenseMaster;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\DonorRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BillingController extends Controller
{
    public function patientAdvanceList(Request $request)
    {
        $pt_advances = CoupleRegistration::join('registrations','registrations.id','=','couple_registrations.registration_number')
        ->join('baby_registrations','couple_registrations.id','=','baby_registrations.couple_registration_number')
        ->select(
            'registrations.id',
            'registrations.first_name',
            'registrations.middle_name',
            'registrations.last_name',
            'registrations.date_of_birth',
            'baby_registrations.birth_weight',
            'baby_registrations.weight_type',
            'registrations.created_at',
            'registrations.contact_no',
            'registrations.email_address',
            'registrations.gender',
            'registrations.marital_status',
            'registrations.identity_proof',
            'registrations.identity_proof_no',
            'registrations.is_special_reg',
            'registrations.reg_from',
            'registrations.is_donor'
            )
            ->get();
        $collect = [];
        foreach ($pt_advances as $pt_advance) {
            $collect[] = [
                'id' => $pt_advance->id,
                'name' => $pt_advance->first_name . ' ' . $pt_advance->middle_name . ' ' . $pt_advance->last_name,
                'date_of_birth' => $pt_advance->date_of_birth,
                'baby_birth_weight' => $pt_advance->birth_weight . ' ' . $pt_advance->weight_type,
                'registration_date' => $pt_advance->created_at,
                'mobile_no' => $pt_advance->contact_no,
                'email' => $pt_advance->email_address,
                'gender' => $pt_advance->gender,
                'marital_status' => $pt_advance->marital_status,
                'identity_type' => $pt_advance->identity_proof,
                'identity_numb' => $pt_advance->identity_proof_no,
                'special_registration' => NULL,
                'registration_from' => $pt_advance->reg_from,
                'old_registration' => NULL,
                'donor_code' => DonorRegistration::find($pt_advance->is_donor)->donor_code,
            ];
        }
        return sendDataHelper('Patient Advance List.', $collect, $code = 200);
    }

    public function expensesList(Request $request)
    {
        try {
            if ($request['response']) {
                $from_date = null;
                $to_date = null;
                $clinic_id = null;
                $expense_id = null;
                $voucher_no = null;
                $voucher_created_by = null;
                if ($request['response']) {
                    $request = decryptData($request['response']); /* Dectrypt  **/
                    if ($request) {
                        $from_date = @$request['from_date'];
                        $to_date = @$request['to_date'];
                        $clinic_id = @$request['clinic_id'];
                        $expense_id = @$request['expense_id'];
                        $voucher_no = @$request['voucher_no'];
                        $voucher_created_by = @$request['voucher_created_by'];
                    }
                }
                $response = [];
                $v_no = [];
                $s_no = [];
                if ($voucher_no) {
                    $voucher_nos = ExpenseDetails::where('voucher_no', 'like', "%{$voucher_no}%")->get();
                    if ($voucher_nos) {
                        $v_no = $voucher_nos->pluck('id');
                    }
                }
                if ($voucher_created_by) {
                    $voucher = ExpenseDetails::where('synchronized', 'like', "%{$voucher_created_by}%")->get();
                    if ($voucher) {
                        $s_no = $voucher->pluck('id');
                    }
                }

                if (($from_date != "") && ($to_date != "") && ($clinic_id != "") && ($expense_id != "") && ($s_no != []) && ($v_no != [])) {
                    $search_expenses = ExpenseDetails::whereBetween('voucher_date', [$from_date, $to_date])
                        ->whereIn('id', $s_no)
                        ->whereIn('id', $v_no)
                        ->where('expense_id', $expense_id)
                        ->where('unit_id', $clinic_id)
                        ->where('status', 1)
                        ->get(['id', 'expense_id', 'unit_id', 'voucher_no', 'voucher_date', 'amount', 'remark', 'freeze', 'status']);
                } else {
                    $search_expenses = ExpenseDetails::whereBetween('voucher_date', [$from_date, $to_date])
                        ->orWhereIn('id', $s_no)
                        ->orWhereIn('id', $v_no)
                        ->orWhere('expense_id', $expense_id)
                        ->orWhere('unit_id', $clinic_id)
                        ->Where('status', 1)
                        ->get(['id', 'expense_id', 'unit_id', 'voucher_no', 'voucher_date', 'amount', 'remark', 'freeze', 'status']);
                }
                foreach ($search_expenses as $search_expense) {
                    $dataArr = [
                        'id' => $search_expense->id,
                        'voucher_no' =>  $search_expense->voucher_no,
                        'voucher_date' => $search_expense->voucher_date,
                        'clinic_name' => Unit::find($search_expense->unit_id)->clinic_name,
                        'expense_against' => ExpenseMaster::find($search_expense->expense_id)->description,
                        'amount' => $search_expense->amount . ".00",
                        'voucher_created_by' => "Admin",
                        'remark' => $search_expense->remark,
                        'voucher_status' => $search_expense->status,
                        'is_freeze' => $search_expense->freeze,
                    ];
                    array_push($response, $dataArr);
                }
                return sendDataHelper('Expense Details List.', $response, $code = 200);
            } else {
                $response = [];
                $expenses = ExpenseDetails::where('status', 1)->get(['id', 'expense_id', 'unit_id', 'voucher_no', 'voucher_date', 'amount', 'remark', 'freeze', 'status']);
                foreach ($expenses as $expense) {
                    $dataArr = [
                        'id' => $expense->id,
                        'voucher_no' =>  $expense->voucher_no,
                        'voucher_date' => $expense->voucher_date,
                        'clinic_name' => Unit::find($expense->unit_id)->clinic_name,
                        'expense_against' => ExpenseMaster::find($expense->expense_id)->description,
                        'amount' => $expense->amount . ".00",
                        'voucher_created_by' => "Admin",
                        'remark' => $expense->remark,
                        'voucher_status' => $expense->status,
                        'is_freeze' => $expense->freeze,
                    ];
                    array_push($response, $dataArr);
                }
                return sendDataHelper('Expense Details List.', $response, $code = 200);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function expensesAdd(Request $request)
    {
        if (respValid($request)) {
            return respValid($request);
        }
        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request, [
            'clinic_id' => 'required',
            'voucher_date' => 'required|after_or_equal:' . date('Y-m-d'),
            'expense_id' => 'required',
            'amount' => 'required',
            'remark' => 'required',
            'freeze' => 'required',
        ]);
        if ($validator->fails()) {
            return sendErrorHelper($validator->errors()->first(), [], 422);
        } else {
            try {
                DB::beginTransaction();
                $request['status'] = 1;
                $request['unit_id'] = $request['clinic_id'];
                $request['created_unit_id'] = Auth::guard('client')->user()->id;
                $request['added_by'] = Auth::guard('client')->user()->fname;
                $request['added_on'] = now();
                $request['added_date_time'] = now();
                $request['synchronized'] = 'admin';
                $expense = ExpenseDetails::create($request);
                ExpenseDetails::where('id', $expense->id)->update(['voucher_no' => 'BJFC/VNO/' . $expense->id]);
                DB::commit();
                $response = [
                    'id' => $expense->id,
                    'voucher_no' => 'BJFC/VNO/' . $expense->id,
                    'amount' => $expense->amount,
                    'remark' => $expense->remark,
                    'freeze' => $expense->freeze,
                ];
                return sendDataHelper('Expenses added successfully', $response, $code = 200);
            } catch (\Throwable $e) {
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }

    public function billMasterList(Request $request)
    {
        // Search by Clinic is remaining
        try {
            if ($request['response']) {
                $date_by = null; // it should be visit,dob,registration
                $from_date =  $to_date = $mrn_number = $first_name = $last_name = $contact_no = $identity_proof = $identity_proof_no = $is_special_reg = $reg_from = null;

                $request = decryptData($request['response']);
                if ($request) {
                    $from_date = @$request['from_date'];
                    $to_date = @$request['to_date'];
                    $date_by = @$request['date_by'];
                    $mrn_number = @$request['mrn_number'];
                    $first_name = @$request['first_name'];
                    $last_name = @$request['last_name'];
                    $contact_no = @$request['contact_no'];
                    $identity_proof = @$request['identity_proof'];
                    $identity_proof_no = @$request['identity_proof_no'];
                    $is_special_reg = @$request['is_special_reg'];
                    $reg_from = @$request['reg_from'];
                }

                $billQuery = DB::table('bill_masters AS BM')->join('registrations AS REG', 'REG.id', '=', 'BM.patient_id');
                // $billQuery->whereBetween('registrations.registration_date', [$from_date, $to_date]);
                // $billQuery->select('bill_masters.*','registrations.mrn_number as mrn_number');
                // $billData = $billQuery->get();
                // // print_r($billQuery->toSql());
                // // die;
                // return  $billData;
                // $billQuery = BillMaster::query();
                // $billQuery->with('patient_list')->has('patient_list');


                if ($from_date && $to_date && $date_by) {

                    if ($date_by == "registration") { //patient_id , "registrations
                        $billQuery->whereBetween('REG.registration_date', [$from_date, $to_date]);
                        // $billQuery->whereHas('patient_list', function ($q) use ($from_date, $to_date) {
                        //     $q->whereBetween('registration_date', [$from_date, $to_date]);
                        // });

                    } else if ($date_by == "dob") { //patient_id , "registrations

                        $billQuery->whereBetween('REG.date_of_birth', [$from_date, $to_date]);
                    } else if ($date_by == "visit") { // patient_id , "visits"
                        $billQuery->leftJoin('visits AS VL', 'VL.patient_id', '=', 'BM.patient_id')->whereBetween('VL.date_time', [$from_date, $to_date]);
                        // $billQuery->with('visit_list')->has('visit_list')->whereBetween('visit_list.date_time', [$from_date, $to_date]);
                    }
                }
                if ($mrn_number) {
                    $billQuery->Where('REG.mrn_number', 'like', '%' . $mrn_number . '%');
                }
                if ($first_name) {
                    $billQuery->Where('REG.first_name', 'like', '%' . $first_name . '%');
                }
                if ($last_name) {
                    $billQuery->Where('REG.last_name', 'like', '%' . $last_name . '%');
                }
                if ($contact_no) {
                    $billQuery->Where('REG.contact_no', 'like', '%' . $contact_no . '%');
                }
                if ($identity_proof && $identity_proof_no) {
                    $billQuery->Where('REG.contact_no', $identity_proof);
                    $billQuery->Where('REG.identity_proof_no', 'like', '%' . $identity_proof_no . '%');
                }
                if ($is_special_reg) {
                    $billQuery->Where('REG.is_special_reg', $is_special_reg);
                }
                if ($reg_from) {
                    $billQuery->Where('REG.reg_from', $reg_from);
                }
                $billQuery->where('BM.status', 1);
                $billQuery->select(
                    'BM.id',
                    'BM.bill_no',
                    'REG.mrn_number',
                    'REG.first_name',
                    'REG.last_name',
                    'REG.date_of_birth',
                    'REG.registration_date',
                    'REG.profile_image',
                    'REG.gender',
                    'REG.contact_no',
                    'REG.email_address',
                    'REG.marital_status',
                    'REG.identity_proof',
                    'REG.identity_proof_no',
                    'REG.identity_file',
                    'REG.reg_from',
                    'REG.is_special_reg',
                    'BM.inter_or_final',
                    'BM.total_bill_amount',
                    'BM.total_settle_disc_amount',
                    'BM.net_bill_amount',
                    'BM.self_amount',
                    'BM.non_self_amount',
                    'BM.balance_amount_self',
                    'BM.balance_amount_non_self'
                );
                $billData = $billQuery->get();
                // dd($billQuery->toSql());
                // die;
                // $appData = [];
                // foreach ($billData as $key => $bill) {
                //     $appData = [
                //         'id' => $bill->id,
                //         'bill_no' => $bill->bill_no,
                //         'mrn_number' => $bill->patient_list->mrn_number,
                //         'first_name' => $bill->patient_list->first_name,
                //         'last_name' => $bill->patient_list->last_name,
                //         'date_of_birth' => $bill->patient_list->date_of_birth,
                //         'registration_date' => $bill->patient_list->registration_date,
                //         'profile_image' => $bill->patient_list->profile_image,
                //         'gender' => $bill->patient_list->gender,
                //         'contact_no' => $bill->patient_list->contact_no,
                //         'email_address' => $bill->patient_list->email_address,
                //         'marital_status' => $bill->patient_list->marital_status,
                //         'identity_proof' => $bill->patient_list->identity_proof,
                //         'identity_proof_no' => $bill->patient_list->identity_proof_no,
                //         'identity_file' => $bill->patient_list->identity_file,
                //         'reg_from' => $bill->patient_list->reg_from,
                //         'is_special_reg' => $bill->patient_list->is_special_reg,
                //         'inter_or_final' => $bill->inter_or_final,
                //         'total_bill_amount' => $bill->total_bill_amount,
                //         'total_settle_disc_amount' => $bill->total_settle_disc_amount,
                //         'net_bill_amount' => $bill->net_bill_amount,
                //         'self_amount' => $bill->self_amount,
                //         'non_self_amount' => $bill->non_self_amount,
                //         'balance_amount_self' => $bill->balance_amount_self,
                //         'balance_amount_non_self' => $bill->balance_amount_non_self,
                //     ];
                // }


                return sendDataHelper('Bill Details List.', $billData, $code = 200);
            } else {
                $response = [];
                $expenses = BillMaster::where('status', 1);

                return sendDataHelper('Bill Details List.', $expenses, $code = 200);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}