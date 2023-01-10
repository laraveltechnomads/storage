<?php

namespace App\Models\API\V1\Inventory;

use App\Models\API\V1\Clinic\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemClinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'item_id',
        'unit_id',
        'min',
        'max',
        're_order',
        'status',
        'is_item_block',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'added_windows_login_name',
        'update_windows_login_name',
        'synchronized',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->where('status',1)->select(['id','description']);
    }
}
