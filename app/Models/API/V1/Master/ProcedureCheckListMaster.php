<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureCheckListMaster extends Model
{
    use HasFactory;

    protected $table = "procedure_check_list_masters";

    protected $fillable = [
        'code',
        'description',
        'status',
        'procedure_cat_id',
        'procedure_sub_cat_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
