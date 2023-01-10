<?php

namespace App\Models\API\V1\Clinic;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'description',	
        'code',	
        'clinic_id',	
        'cost_center_code',	
        'opening_balance',	
        'indent',	
        'issue',	
        'item_return',	
        'goods_received_note',	
        'grn_return',	
        'items_sale',	
        'items_sale_return',	
        'expiry_item_return',	
        'receive_issue',	
        'receive_issue_return',	
        'isparent',	
        'status',	
        'is_central_store',	
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
        'is_quarantine_store',
    ];
}
