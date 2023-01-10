<?php

namespace App\Models\API\V1\Patients;

use App\Models\API\V1\Clinic\DoctorSlotAppointment;
use App\Models\API\V1\Master\AppointmentReason;
use App\Models\API\V1\Master\AppointmentStatus;
use App\Models\API\V1\Master\AppointmentType;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Register\Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use HasFactory, HasFactory, Notifiable, SoftDeletes;

    protected $table = "appointments";
    protected $fillable = [
        'registration_number',
        'app_unit_id',
        'reg_type_patient_id',
        'reg_id',
        'reg_unit_id',
        'visit_id',
        'visit_unit_id',
        'app_slot_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender_id',
        'date_of_birth',
        'marital_status',
        'mobile_country',
        'contact_no',
        'alt_mobile_country',
        'alt_mobile_number',
        'resi_no_country_code',
        'resi_std_code',
        'lanline_number',
        'email_address',
        'dept_id',
        'doc_id',
        'doctor',
        'reason',
        'app_reason_id',
        'referred_by',
        'appointment_date',
        'from_date',
        'to_date',
        'remark',
        'app_type_id',
        'is_acknowledge',
        'reminder_count',
        'user_name',
        'is_cancel',
        'app_cancel_reason',
        'visit_mark',
        'is_sendmail',
        'is_send_cancel_mail',
        's_reg_id',
        'app_status_id',
        'parent_appoint_id',
        'parent_appoint_unit_id',
        'is_reschedule',
        're_shedule_against_app_id',
        're_schedulling_reason',
        'status',
        'created_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'added_windows_login_name',
        'update_windows_login_name',
        'synchronized',
        'status',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'added_windows_login_name',
        'updated_windows_login_name',
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function registration_list(){
        return $this->belongsTo(Registration::class, 'reg_type_patient_id', 'id');
    }

    public function appointment_status(){
        return $this->belongsTo(AppointmentStatus::class, 'app_status_id', 'id')->whereStatus(1);
    }

    public function appointment_reason(){
        return $this->belongsTo(AppointmentReason::class, 'app_reason_id', 'id')->whereStatus(1)->select('id', 'description', 'status');
    }

    public function appointment_type(){
        return $this->belongsTo(AppointmentType::class, 'app_type_id', 'id')->whereStatus(1);
    }

    public function doctor_detail(){
        return $this->belongsTo(Doctor::class, 'doc_id', 'id')->whereStatus(1);
    }

    public function refer_by_detail(){
        return $this->belongsTo(Doctor::class, 'referred_by', 'id')->whereStatus(1);
    }

    public function dept_detail(){
        return $this->belongsTo(Department::class, 'dept_id', 'id')->whereStatus(1);
    }

    public function app_doc_slot(){
        return $this->belongsTo(DoctorSlotAppointment::class, 'id', 'appointment_id')->whereStatus(1);
    }
}
