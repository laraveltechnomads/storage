<?php

namespace App\Models\API\V1\Register;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorRegistration extends Model
{
    use HasFactory;
    protected $table = "donor_registrations";

    protected $fillable = [
        'patient_category_id',
        'registration_number',
        'mrn_number',
        'unit_id',
        'donor_code',
        'registration_date',
        'agnecy_id',
        'blood_group_id',
        'eye_color_id',
        'hair_color_id',
        'skin_color_id',
        'height_id',
        'built_id',
        'added_user_id',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'added_windows_login_name',
        'updated_windows_login_name',
        'synchronized',
        'education_id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}