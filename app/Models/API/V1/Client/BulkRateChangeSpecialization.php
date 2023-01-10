<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkRateChangeSpecialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'bulk_id',	
        's_id',	
        'su_id',	
        'is_set_rate_for_all',	
        'is_percentage_rate',	
        'percentage_rate',	
        'amount_rate',	
        'operation_type',	
        'status',	
        'synchronized',
    ];
}
