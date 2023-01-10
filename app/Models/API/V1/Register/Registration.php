<?php

namespace App\Models\API\V1\Register;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $table = "registrations";
    protected $fillable = [
        'patient_category_id',
        'mrn_number',
        'registration_type',
        'first_name',
        'middle_name',
        'last_name',
        'profile_image',
        'gender',
        'contact_no',
        'email_address',
        'date_of_birth',
        'age',
        'identity_proof',
        'identity_proof_no',
        'identity_file',
        'source_reference',
        'reference_details',
        'referral_doctor',
        'remark',
        'marital_status',
        'blood_group',
        'nationality',
        'ethnicity',
        'religion',
        'education',
        'occuption',
        'married_since',
        'existing_children',
        'family',
        'address_line_1',
        'address_line_2',
        'landmark',
        'country',
        'state',
        'city',
        'zip_code',
        'same_for_partner',
        'for_communication',
        'notify_me',
        'patient_source',
        'company_name',
        'associated_company',
        'reference_no',
        'tarrif_name',
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
        'patientUnitId',
        'is_special_reg',
        'is_donor',
        'reg_from'
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    
    public function couple_female(){
        return $this->hasOne(CoupleRegistration::class, 'female_patient_id', 'id');
    }

    public function couple_male(){
        return $this->hasOne(CoupleRegistration::class, 'male_patient_id', 'id');
    }
}
