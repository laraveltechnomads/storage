<?php

namespace App\Models\API\V1\Clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',	
        'description', 
        'unit_id',	 
        'status',	 
        'created_unit_id', 
        'updated_unit_id', 
        'added_by', 
        'added_on', 
        'added_date_time', 
        'added_utc_date_time',	  
        'added_windows_login_name',  
        'updated_by', 
        'updated_on',	   
        'updated_date_time', 
        'updated_utc_date_time',
        'updated_windows_login_name',
        'synchronized',	
        'is_clinical',
        'is_free',
        'free_days',
        'consultation_visit_type_id',
        'service_id'
    ];
}
