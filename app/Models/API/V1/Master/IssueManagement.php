<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueManagement extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "issue_management";

    protected $fillable = [
        'item_id',
        'item_ids',
        'from_store_id',
        'to_store_id',
        'issue_reason',
        'amount',
        'remark',
        'status',
        'unit_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}