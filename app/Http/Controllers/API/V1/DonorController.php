<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Register\DonorRegistration;
use App\Utils\Patient\DonorUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonorController extends Controller
{
    protected $donorUtil;
    public function __construct(DonorUtil $donorUtil)
    {
        $this->donorUtil = $donorUtil;
    }
    
    /* Donor Authentication */
    public function registration($request, $datareq)
    {
        DB::beginTransaction();
        try
        {  
            if(@$request['step'] == 1)
            {
                $error = DonorUtil::regDonorValidStepOne($request, $datareq);
                if($error) { return $error; }

                $donorRegistration = DonorUtil::regStepOne($request, $datareq);
            }
            elseif (@$request['step'] == 2)
            {
                
                $error = DonorUtil::regDonorValidStepTwo($request, $datareq);
                if($error) { return $error; }

                $donor = DonorRegistration::where('registration_number', $request['registration_number'])->first();
                if(!$donor)
                {   
                    return sendError('Error', 'step invalid.', 404);
                }
                
                $donorRegistration = DonorUtil::regStepTwo($request, $datareq);
            }
            elseif (@$request['step'] == 3)
            {
                $donor = DonorRegistration::where('registration_number', $request['registration_number'])->first();
                if(!$donor)
                {
                    return sendError('Error', 'step invalid.', 404);
                }
                $error = DonorUtil::regDonorValidStepThree($request, $datareq);
                if($error) { return $error; }

                $donorRegistration = DonorUtil::regStepThree($request, $datareq);
            }elseif (@$request['step'] == 4)
            {
                $Individual = DonorRegistration::where('registration_number', $request['registration_number'])->first();
                if(!$Individual)
                {
                    return sendError('Error', 'step invalid.', 404);
                }
                $error = DonorUtil::regDonorValidStepFour($request, $datareq);
                if($error) { return $error; }
                
                $donorRegistration = DonorUtil::regStepFour($request, $datareq);
            }else{
                return sendError('Error', 'step invalid.', 404);
            }

            DB::commit();
            return $donorRegistration;
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}