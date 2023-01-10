<?php

namespace App\Models\API\V1\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTariff extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_id',
        'tariff_id',
        'list_class',
    ];
}
