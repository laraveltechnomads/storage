<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = "email_templates";

    protected $fillable = [
        'code',
        'template_name',
        'subject',
        'text',
        'attachments',
        'status',
        'event_type_id',
        'field_id',
        'unit_id',
        'client_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
