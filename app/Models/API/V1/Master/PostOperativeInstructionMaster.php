<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOperativeInstructionMaster extends Model
{
    use HasFactory;

    protected $table = "post_operative_instruction_masters";

    protected $fillable = [
        'code',
        'description',
        'status'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
