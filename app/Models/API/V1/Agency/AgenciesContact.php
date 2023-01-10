<?php

namespace App\Models\API\V1\Agency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciesContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'unit_id',
        'agency_id',
        'person',
        'name',
        'email',
        'mobile_no',
        'alt_mobile_no',
        'status',	
        'created_unit_id',	
        'updated_unit_id',	
        'added_by',	
        'added_on',	
        'added_date_time',
        'updated_by',	
        'updated_on',	
        'updated_date_time',	
        'added_windows_login_name',	
        'update_windows_login_name',	
        'synchronized',
    ];
}
