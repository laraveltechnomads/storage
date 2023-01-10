<?php

namespace App\Models\API\V1\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        's_id',
        'ss_id',
        'code',
        'package_name',
        'sac_code',
        'rate',
        'duration',
        'service_component',
        'pharmacy_component',
        'distribution_in',
        'item_list',
        'item_category_list',
        'item_group_list',
        'total_amt',
        'remain_amt',
        'use_amt',
        'set_all_items',
        'is_enable',
        'status',
    ];
}
