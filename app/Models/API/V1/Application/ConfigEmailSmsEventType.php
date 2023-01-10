<?php

namespace App\Models\API\V1\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigEmailSmsEventType extends Model
{
    use HasFactory;
    protected $fillable = [
        'ce_sms_event_type_code',	
        'description',	
        'status'
    ];
}
