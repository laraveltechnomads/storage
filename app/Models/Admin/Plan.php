<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = "plans";
    protected $connection = "admin_db";
    protected $fillable = [
        'name',
        'description',
        'duration',
        'plan_id',
        'plan_period',
        'trialdays',
        'item_id',
        'active_status','active_status','active_status',
        'amount',
        'currency',
        'added_by',
        'updated_by',
        'features',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
