<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSponsorDetail extends Model
{
    protected $fillable = [
        'patient_id',
        'patient_unit_id',
        'patient_source_id',
        'company_id',
        'associated_company_id',
        'reference_no',
        'credit_limit',
        'effective_date',
        'expiry_date',
        'tariff_id',
        'employee_no',
        'designation_id',
        'remark',
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
        'updated_windows_login_name',
        'synchronized',
        'membership_card_issue_date',
        'prefer_name_on_card',
        'is_family',
        'parent_patient_id',
        'parent_patient_unit_id',
        'parent_sponsor_id',
        'parent_sponsor_unit_id',
        'poc_doctor_id',
        'member_relation_id',
        'patient_category_id',
        'pat_sponsor_id',
        'sponsor_unit_id',
        'visit_id',
        'visit_unit_id',
        'cat_l2_id',
        'comp_ass_id',
        'tid',
        'staff_relation_id',
        'v_from_date',
        'v_to_date',
        'is_staff_discount'
    ];
}
