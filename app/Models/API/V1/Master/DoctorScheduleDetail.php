<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorScheduleDetail extends Model
{
    use HasFactory;
    protected $table = "doctor_schedule_details";
    protected $fillable = [
        'schedule_id',
        'unit_id',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'doc_id',
        'dept_id',
        'start_date_time',
        'end_date_time',
        'is_end_date',
        'apply_to_all_day',
        'status',
        'synchronized',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_windows_login_name',
        'day_of_the_week',
        'month'
    ];
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
