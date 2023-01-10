<?php

namespace App\Models\API\V1\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    use HasFactory;

    protected $table = "store_items";

    protected $fillable = [
        'store_no',
        'store_date',
        'exp_delivery_date',
        'store_item_type_id',
        'from_store_id',
        'to_store_id',
        'patient_id',
        'item_ids',
        'unit_id',
        'status',
        'freezed',
        'approved',
        'reason',
        'remark',
        'against_patient'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
