<?php

namespace App\Models\API\V1\Clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visits";

    protected $fillable = [
        'unit_id',
        'date_time',
        'spouse_id'.
        'patient_id',
        'patient_unit_id',
        'OPD_no',
        'visit_type_id',
        'complaints',
        'department_id',
        'doctor_id',
        'cabin_id',
        'referred_doctor_id',
        'visit_notes',
        'referred_doctor',
        'visit_status',
        'current_visit_status',
        'visit_type_service_id',
        'patient_case_record',
        'case_referral_sheet',
        'token_no',
        'time',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_windows_login_name',
        'synchronized'
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
