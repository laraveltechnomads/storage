<?php

namespace App\Models\API\V1\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_id',
        'service_id',
        'qty',
        'applicable',
        'consumable',
        'adjustable_head',
        'process_name',
        'adjusted_against',
        'rate_limit',
    ];
}
