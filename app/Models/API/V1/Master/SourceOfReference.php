<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Model;

class SourceOfReference extends Model
{
    // 'id as ref_type_id'

    protected $fillable = [
        'description',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'added_windows_login_name',
        'updated_windows_login_name',
        'synchronized'
    ];
}
