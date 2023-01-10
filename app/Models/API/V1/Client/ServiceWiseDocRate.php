<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceWiseDocRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'ser_id',
        'doc_cat_id',
        'ser_rate_id',
    ];
}
