<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Model;

class TariffMaster extends Model
{
    protected $fillable = [	
        'tariff_code',	
        'description',	
        'service_id',
        'unit_id',	
        'startdate',	
        'enddate',	
        'status',	
        'created_unit_id',	
        'updated_unit_id',	
        'added_by',	
        'added_on',	
        'added_date_time',	
        'added_utc_date_time',	
        'updated_by',	
        'updated_date_time',	
        'updated_utc_date_time',	
        'added_windows_login_name',	
        'update_windows_login_name',	
        'synchronized',
    ];
}
