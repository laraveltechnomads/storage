<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Model;

class AdvanceAgainstDetail extends Model
{
    protected $fillable = [
        'adv_ag_code',	
        'description',	
        'status',	
        'created_unit_id',	
        'updated_unit_id',
        'added_by',	
        'added_on',	
        'added_date_time',	
        'Added_utc_date_time',	
        'updated_by',	
        'updated_on',	
        'updated_date_time',	
        'updated_utc_date_time',	
        'added_windows_login_name',	
        'update_windows_login_name',	
        'synchronized',
    ];
}
