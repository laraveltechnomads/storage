<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    
    protected $table = "classifications";

    protected $fillable = [
        'code',
        'description',
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
        'updated_windows_login_name',
        'synchronized'
    ];
    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
