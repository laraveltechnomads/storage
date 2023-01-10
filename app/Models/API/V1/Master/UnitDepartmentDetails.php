<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitDepartmentDetails extends Model
{
    use HasFactory;

    protected $table = "unit_department_details";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function unit_departments()
    {
        return $this->belongsTo(Department::class);
    }

    public function departments(){
        return $this->hasMany(Department::class, 'id', 'department_id');    
    }

    public function units(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id')->where('status', 1)->select('id','clinic_name');
    }
}
