<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;   
    protected $table = "employees";
    protected $fillable = [
        'name',
        'skill_id',
        'dob',
        'gender',
        'marital_status',
        'image',
        'image_id',
        'image_name',
        'image_data',
        'image_mime',
        'status',
        'first_name',
        'last_name',
        'mobile_number',
        'blood_group_id',
        'address',
        'designation_id',
        'unit_id',
        'date_of_joining',
        'employee_no',
        'pf_no',
        'pan_no',
        'email_address',
        'access_card_no',
        'education',
        'discharge_approval'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
