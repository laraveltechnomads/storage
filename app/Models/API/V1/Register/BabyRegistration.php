<?php

namespace App\Models\API\V1\Register;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyRegistration extends Model
{
    use HasFactory;

    protected $table = "baby_registrations";
    protected $fillable = [
        'patient_category_id',
        'registration_type',
        'registration_number',
        'mrn_number',
        'parent_id',
        'first_name',
        'middle_name',
        'last_name',
        'profile_image',
        'gender',
        'contact_no',
        'date_of_birth',
        'birth_time',
        'birth_weight',
        'blood_group',
        'identity_proof',
        'identity_proof_no',
        'identity_file',
        'registration_date',
        'status',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'added_windows_login_name',
        'updated_windows_login_name',
        'patientUnitId'     
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
