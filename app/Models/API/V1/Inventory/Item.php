<?php

namespace App\Models\API\V1\Inventory;

use App\Models\API\V1\Master\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'item_code',
        'brand_name',
        'strength',
        'item_name',
        'molecule_name',
        'item_group',
        'item_category',
        'dispensing_type',
        'storage_type',
        'storage_degree',
        'preg_class',
        'ther_class',
        'mfg_by',
        'mrk_by',
        'PUM',
        'SUM',
        'conversion_factor',
        'route',
        'purchase_rate',
        'MRP',
        'vat_per',
        'reorder_qnt',
        'batches_required',
        'inclusive_of_tax',
        'discount_on_sale',
        'item_margin_id',
        'item_movement_id',
        'margin',
        'highest_retail_price',
        'min_stock',
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
        'barcode',
        'is_ABC',
        'is_FNS',
        'is_VED',
        'strength_unit_type_id',
        'base_um',
        'selling_um',
        'conv_fact_stock_base',
        'conv_fact_base_sale',
        'item_expired_in_days',
        'hsn_codes_id',
        'molecule_id',
        'item_group_id',
        'item_category_id',
        'qty',
        'purchase_uom',
        'remarks',
        'expiry_alert',
        'clinic_id',
        'rank',
        'shelf',
        'container',
        'list_of_supplier',
        'base_unit_cost_price',
        'staff_discount_on_sale',
        'regi_patient_discount_on_sale',
        'walk_in_patient_discount_on_sale',
        'cgst',
        'sgst',
        'igst',
        // 'batch_id',
    ];

    public function clinic()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id')->select(['id','description as unit_description'])->where('status',1);
    }

    public function item_clinics()
    {
        return $this->hasMany(ItemClinic::class, 'item_id', 'id')->select(['id','item_id','store_id'])->where('status',1)->where('is_item_block',0)->with('store');
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id')->where('status',1)->select(['id','description']);
    }

    public function itemGroup()
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id', 'id')->where('status',1)->select(['id','description']);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'item_id', 'id')->select(['is_free','batch_code','batch_code','expiry_date','mrp'])->where('status',1);
    }
}
