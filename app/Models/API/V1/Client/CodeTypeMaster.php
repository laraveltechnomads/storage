<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Model;

class CodeTypeMaster extends Model
{
    protected $fillable = [
        'code',	
        'description',	
        'status'
    ];
}
