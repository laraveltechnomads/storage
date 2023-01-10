<?php

namespace App\Http\Controllers\API\V1\Patients;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Register\Registration;
use App\Utils\Patient\ANCUtil;
use Illuminate\Http\Request;

class ANC_Controller extends Controller
{
    protected $ANCUtil;
    public function __construct(ANCUtil $ANCUtil)
    {
        $this->ANCUtil = $ANCUtil;
    }
    
    /* ANC Authentication */
    public function registration($request, $datareq)
    {
        if(@$request['step'] == 1)
        {
            $error = ANCUtil::regValidStepOne($request, $datareq);
            if($error) { return $error; }

            $ANCRegistration = ANCUtil::regStepOne($request, $datareq);
        }
        elseif (@$request['step'] == 2)
        {
            
            $error = ANCUtil::regValidStepTwo($request, $datareq);
            if($error) { return $error; }

            $ANCUtil = Registration::where('id', $request['registration_number'])->first();
            if(!$ANCUtil)
            {   
                return sendError('Error', 'step invalid.', 404);
            }
            
            $ANCRegistration = ANCUtil::regStepTwo($request, $datareq);
        }
        elseif (@$request['step'] == 3)
        {
            $ANCUtil = Registration::where('id', $request['registration_number'])->first();
            if(!$ANCUtil)
            {
                return sendError('Error', 'step invalid.', 404);
            }
            $error = ANCUtil::regValidStepThree($request, $datareq);
            if($error) { return $error; }

            $ANCRegistration = ANCUtil::regStepThree($request, $datareq);
        }
        elseif (@$request['step'] == 4)
        {
            $ANCUtil = Registration::where('id', $request['registration_number'])->first();
            if(!$ANCUtil)
            {
                return sendError('Error', 'step invalid.', 404);
            }
            $error = ANCUtil::regValidStepFour($request, $datareq);
            if($error) { return $error; }

            $ANCRegistration = ANCUtil::regStepFour($request, $datareq);
        }else{
            return sendError('Error', 'step invalid.', 404);
        }
        return $ANCRegistration;
    }
}
