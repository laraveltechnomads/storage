<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSpecialization extends Model
{
    use HasFactory;
    protected $table = "sub_specializations";
    protected $fillable = [
        'code',
        'description',
        's_id',
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
        'synchronized'
    ];

    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
