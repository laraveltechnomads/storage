<?php

namespace App\Utils\Apppointment;

use App\Models\API\V1\Master\AppointmentReason;
use App\Models\API\V1\Master\Doctor;
use Illuminate\Http\Request;

Class ReasonUtil
{

    /* reference_details */
    public function reason_appointment($unit = 0)
    {
        $response = [];
        $reasons = AppointmentReason::get();
        foreach ($reasons as $reason) {
            $arr = [
                'app_reason_id' => $reason->id,
                'description' =>  $reason->description,
            ];
            array_push($response, $arr);
        }
        return $response;
    }
}