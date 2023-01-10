<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAssociateMaster extends Model
{
    use HasFactory;
    protected $fillable = [	
        'comp_ass_code',	
        'description',	
        'comp_id',	
        'fcontact_person',	
        'faddress_line1',	
        'faddress_line2',	
        'femail',	
        'fstreet',	
        'flandmark',	
        'fmobile_country_id',	
        'fmobile_no',	
        'falt_mobile_country_id',	
        'falt_mobileno',	
        'fresi_std_code',	
        'fresi_landlineno',	
        'falt_resi_std_code',	
        'falt_resi_landlineno',	
        'fcountry_id',	
        'fstate_id',	
        'fcity_id',	
        'farea',	
        'fpincode',	
        'scontact_person',	
        'saddress_line1',	
        'saddress_line2',	
        'semail',	
        'sstreet',	
        'slandmark',	
        'smobile_country_id',	
        'smobile_no',	
        'salt_mobile_country_id',	
        'salt_mobileno',	
        'sresi_std_code',	
        'sresi_landlineno',	
        'salt_resi_std_code',	
        'salt_resi_landlineno',	
        'scountry_id',	
        'sstate_id',	
        'scity_id',	
        'sarea',	
        'spincode',	
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
