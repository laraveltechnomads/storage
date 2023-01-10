<?php

namespace App\Utils\Clinic;

use App\Models\API\V1\Master\Doctor;
use Illuminate\Http\Request;

Class DoctorUtil
{
    /* reference_details */
    public function doctors_details($unit = 0)
    {
        $response = [];
        $doctors = Doctor::get();
        foreach ($doctors as $doc) {
            $arr = [
                'doctor_id' => $doc->id,
                'name' =>  $doc->first_name.' '.$doc->last_name,
                'id' => $doc->id,
            ];
            array_push($response, $arr);
        }
        return $response;
    }
}