<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;
use Illuminate\Http\Request;
use App\Utils\Patient\PartnerUtil;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    protected $partnerUtil;
    public function __construct(PartnerUtil $partnerUtil)
    {
        $this->partnerUtil = $partnerUtil;
    }
    
    /* Authentication */
    public function registration($request, $datareq)
    {
        // return $request;
        DB::beginTransaction();
        try
        {   
            if(@$request['step'] == 1)
            {
                $error = PartnerUtil::regPartnerValidStepOne($request, $datareq);
                if($error) { return $error; }

                $partner_reg = PartnerUtil::regStepOne($request, $datareq);
            }
            elseif (@$request['step'] == 2)
            {
                $partner = CoupleRegistration::whereNotNull('male_patient_id')->where('female_patient_id', $request['registration_number'])->first();
                if(!$partner)
                {   
                    return sendError('Error', 'step invalid.', 404);
                }
                $error = PartnerUtil::regPartnerValidStepTwo($request, $datareq);
                if($error) { return $error; }

                $partner_reg = PartnerUtil::regStepTwo($request, $datareq);
            }
            elseif (@$request['step'] == 3)
            {
                $partner = CoupleRegistration::whereNotNull('male_patient_id')->where('female_patient_id', $request['registration_number'])->first();
                if(!$partner)
                {
                    return sendError('Error', 'step invalid.', 404);
                }
                $error = PartnerUtil::regPartnerValidStepThree($request, $datareq);
                if($error) { return $error; }

                $partner_reg = PartnerUtil::regStepThree($request, $datareq);
            }else{
                return sendError('Error', 'step invalid.', 404);
            }

            DB::commit();
            return $partner_reg;
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    
}
