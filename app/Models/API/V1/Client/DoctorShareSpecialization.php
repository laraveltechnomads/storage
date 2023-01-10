<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorShareSpecialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_share_id',
        'doc_id',
        't_id',
        's_id',
        'su_id',
        'fname',
        'lname',
        'share_pr',
        'apply_all_subsup',
        'apply_to_all_service',
        'apply_to_all_doc',
        'created_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'updated_unit_id',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'added_windows_login_name',
        'update_windows_login_name',
            
        'synchronized',
    ];
}
