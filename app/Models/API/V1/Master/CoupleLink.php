<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Model;

class CoupleLink extends Model
{
    protected $fillable = [
        'patient_id',
        'patient_unit_id',
        'spouse_id',
        'spouse_unit_id',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_data_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_data_time',
        'update_windows_login_name'
    ];
}
