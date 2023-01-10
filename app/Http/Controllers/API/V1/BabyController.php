<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Register\BabyRegistration;
use App\Utils\Patient\BabyUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BabyController extends Controller
{
    protected $babyUtil;
    public function __construct(BabyUtil $babyUtil)
    {
        $this->babyUtil = $babyUtil;
    }
    public function registration($request, $datareq)
    {
        if(@$request['step'] == 0)
        {
            $error = BabyUtil::appointmentZero($request, $datareq);
            if($error) { return $error; }

            $babyRegistration = BabyUtil::regStepZero($request, $datareq);
        }
        elseif(@$request['step'] == 1)
        {
            $error = BabyUtil::regBabyValidStepOne($request, $datareq);
            if($error) { return $error; }

            $babyRegistration = BabyUtil::regStepOne($request, $datareq);
        }else{
            return sendError('Error', 'step invalid.', 404);
        }
        return $babyRegistration;
    }
}
