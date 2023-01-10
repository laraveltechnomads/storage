<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Patients\AppointmentController;
use App\Http\Controllers\Controller;
use App\Models\API\V1\Register\Registration;
use App\Utils\Patient\IndividualUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndividualController extends Controller
{
    protected $individualUtil;
    public function __construct(IndividualUtil $individualUtil)
    {
        $this->individualUtil = $individualUtil;
    }
    
    /* Individual Registration */
    public function registration($request, $datareq)
    {
        if(@$request['step'] == 1)
        {
            $error = IndividualUtil::regIndividualValidStepOne($request, $datareq);
            if($error) { return $error; }

            $IndividualRegistration = IndividualUtil::regStepOne($request, $datareq);
        }
        elseif (@$request['step'] == 2)
        {   
            $error = IndividualUtil::regIndividualValidStepTwo($request, $datareq);
            if($error) { return $error; }

            $Individual = Registration::where('id', $request['registration_number'])->first();
            if(!$Individual)
            {   
                return sendError('Error', 'step invalid.', 404);
            }
            
            $IndividualRegistration = IndividualUtil::regStepTwo($request, $datareq);
        }
        elseif (@$request['step'] == 3)
        {
            $Individual = Registration::where('id', $request['registration_number'])->first();
            if(!$Individual)
            {
                return sendError('Error', 'step invalid.', 404);
            }
            $error = IndividualUtil::regIndividualValidStepThree($request, $datareq);
            if($error) { return $error; }

            $IndividualRegistration = IndividualUtil::regStepThree($request, $datareq);
        }
        elseif (@$request['step'] == 4)
        {
            $Individual = Registration::where('id', $request['registration_number'])->first();
            if(!$Individual)
            {
                return sendError('Error', 'step invalid.', 404);
            }
            $error = IndividualUtil::regIndividualValidStepFour($request, $datareq);
            if($error) { return $error; }

            $IndividualRegistration = IndividualUtil::regStepFour($request, $datareq);
        }else{
            return sendError('Error', 'step invalid.', 404);
        }
        return $IndividualRegistration;
    }
}
