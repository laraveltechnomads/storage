<?php

namespace App\Models\API\V1\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigAutoEmailNew extends Model
{
    use HasFactory;
    protected $fillable = [
        'ce_sms_event_type_id',	
        'email_template_id',	
        'sms_template_id',	
        'email_id',	
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
        'app_config_id',	
        'unit_id',	
    ];
}
