<?php

namespace App\Models\API\V1\Clinic;

use App\Models\API\V1\Master\TimeSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSlotAppointment extends Model
{
    use HasFactory;

    protected $table = "doctor_slot_appointments";

    protected $fillable = [
        'unit_id',
        'doc_id',
        'dept_id',
        'doc_cat_id',
        'doc_schedule_detail_id',
        'time_slot_id',
        'appointment_id',
        'select_date',
        'status',
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
        'synchronized'
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function time_slot(){
        return $this->belongsTo(TimeSlot::class, 'time_slot_id', 'id');
    }
}