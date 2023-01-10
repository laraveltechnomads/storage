<?php

namespace App\Models\API\V1\IPD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_unit_id',	
        'c_code',	
        'deposit_for_ipd',	
        'deposit_for_ot',	
        'description',	
        'status',	
        'created_unit_id',	
        'added_by',	
        'added_on',	
        'added_date_time',	
        'updated_unit_id',	
        'updated_by',	
        'updated_on',	
        'updated_date_time',	
        'added_windows_login_name',	
        'update_windows_login_name',	
        'synchronized',
    ];
}
