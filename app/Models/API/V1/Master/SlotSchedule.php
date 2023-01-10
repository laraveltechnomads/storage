<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotSchedule extends Model
{
    use HasFactory;
    
    protected $table = "slot_schedules";

    protected $fillable = [
        'code',
        'description',
        'start_time',
        'end_time',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'updated_windows_login_name',
        'synchronized',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'updated_utc_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
