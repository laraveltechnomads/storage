<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_table_id',
        'attachment_id',
        'table_type',
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id', 'id')->select(['id','images']);
    }
}
