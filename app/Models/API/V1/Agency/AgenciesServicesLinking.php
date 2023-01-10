<?php

namespace App\Models\API\V1\Agency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciesServicesLinking extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'unit_id',
        'agency_id',
        'specialization_id',
        'sub_specialization_id',
        'linked_services',
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
