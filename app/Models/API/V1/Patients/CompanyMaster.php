<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Model;

class CompanyMaster extends Model
{
    protected $fillable = [
        'comp_unit_id',
        'comp_code',
        'description',
        'title',
        'comp_type_id',
        'patient_source_id',
        'status',
        'tariff_list',
        'header_text',
        'footer_text',
        'logo',
        'header_image',
        'footer_image',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'added_windows_login_name',
        'update_windows_login_name',
        'synchronized',
    ];
}
