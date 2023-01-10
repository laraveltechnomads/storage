<?php

namespace App\Models\API\V1\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_ids',
        'enquiry_no',
        'supplier_id',
        'store_id',
        'added_date',
        'header',
    ];

    public function item()
    {
        return $this->hasMany(Item::class, 'id', 'item_id')->select(['id','item_code','item_name','qty','purchase_uom','remarks']);
    }
}
