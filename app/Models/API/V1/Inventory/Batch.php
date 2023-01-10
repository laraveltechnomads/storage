<?php

namespace App\Models\API\V1\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'date',
        'time',
        'item_id',
        'batch_code',
        'expiry_date',
        'qty',
        'conversion_factor',
        'purchase_rate',
        'mrp',
        'stocking_purchase_rate',
        'stocking_mrp',
        'vat_percentage',
        'vat_amount',
        'discount_on_sale',
        'remarks',
        'landedRate',
        'barcode',
        'is_consignment',
        'is_free',
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
        'update_windows_login_name',
        'synchronized',
    ];
}
