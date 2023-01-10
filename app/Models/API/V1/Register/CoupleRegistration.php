<?php

namespace App\Models\API\V1\Register;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoupleRegistration extends Model
{
    use HasFactory;

    protected $table = "couple_registrations";
    protected $fillable = [
        'patient_category_id',
        'unit_id',
        'couple_registration_number',
        'male_patient_id',
        'male_patient_unit_id',
        'female_patient_id',
        'female_patient_unit_id',
        'registration_date',
        'status',
        'added_by',
        'added_on',
        'updated_by',
        'updated_on',
        'added_windows_login_name',
        'updated_windows_login_name',
        'synchronized'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
