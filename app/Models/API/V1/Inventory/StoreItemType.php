<?php

namespace App\Models\API\V1\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItemType extends Model
{
    use HasFactory;

    protected $table = "store_item_types";

    protected $fillable = [
        'description',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'from_store_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'update_windows_login_name',
        'synchronized'
    ];

    protected $casts = [
        'added_date_time' => 'datetime:Y-m-d H:i:s',
        'updated_date_time' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
