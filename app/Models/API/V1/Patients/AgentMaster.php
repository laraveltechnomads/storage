<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date_of_birth',
        'occupation_id',
        'is_married',
        'years_of_merrage',
        'spouse_name',
        'spouse_date_of_birth',
        'previouly_egg_donation',
        'no_of_donation_time',
        'donation_detail',
        'previous_surogacy_done',
        'no_of_surogacy_done',
        'surogacy_detail',
        'mob_country_code',
        'mobile_no',
        'alt_mob_country_code',
        'alt_mobile_no',
        'landline_area_code',
        'landline_no',
        'address_line_1',
        'address_line_2',
        'area',
        'street',
        'landmark',
        'country_id',
        'state_id',
        'city_id',
        'pincode',
        'pan_no',
        'aadhar_no',
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
