<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Json;

class Doctor extends Model
{
    use HasFactory;

    protected $table = "doctors";

    protected $fillable = [
        's_id',
        'su_id',
        'doc_cat_id',
        'doc_type_id',
        'employee_no',
        'first_name',
        'middle_name',
        'last_name',
        'gender_id',
        'date_of_birth',
        'education',
        'experience',
        'registration_number',
        'signature',
        'is_referral',
        'bdm_id',
        'date_of_joining',
        'pan_no',
        'medical_reg_no',
        'medical_pan_no',
        'status',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'added_windows_login_name',
        'updated_windows_login_name',
        'patientUnitId',
        'photo',
        'documents',
        'marital_status',
        'pf_no',
        'email_address',
        'access_card_no',
        'user_id',
        'unit_id',
        'departments',
        'classifications'
    ];
    protected $casts = [
        'departments' => 'array',
        'classifications' => 'array',
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'updated_utc_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}