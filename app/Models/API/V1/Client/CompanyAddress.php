<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'comp_id',	
        'comp_unit_id',	
        'contact_person',	
        'address_line1',	
        'address_line2',	
        'email',	
        'street',	
        'landmark',	
        'mobile_country_id',	
        'mobile_no',	
        'alt_mobile_country_id',	
        'alt_mobileno',	
        'resi_std_code',	
        'resi_landlineno',	
        'altresi_std_code',	
        'altresi_landlineno',	
        'country_id',	
        'state_id',	
        'city_id',	
        'area',	
        'pincode',	
        'is_default',	
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
