<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertEventType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "alert_event_types";

    protected $fillable = [
        'code',
        'description',
        'status',
        'unit_id',
        'client_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


}
