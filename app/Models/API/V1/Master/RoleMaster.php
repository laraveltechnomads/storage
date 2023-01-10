<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Model;

class RoleMaster extends Model
{
    protected $table = "role_masters";
    protected $fillable = [
        'code',
        'description',
        'status',
        'reason_for_add',
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

}
