<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtSchedulingMaster extends Model
{
    use HasFactory;

    protected $table = "ot_scheduling_masters";

    protected $fillable = [
        'code',
        'ot_id',
        'ot_table_id',
        'day_id',
        'schedule_id',
        'from_time',
        'to_time',
        'status'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
