<?php

namespace App\Models\API\V1\IVF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrogateAgencyMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'code',
        'description',
        'referral_id',
        'email_address',
        'contact_no',
        'affiliated_by',
        'affiliated_year',
        'registration_no',
        'address',
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
