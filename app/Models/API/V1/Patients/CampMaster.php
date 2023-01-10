<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampMaster extends Model
{
    protected $fillable = [
        'code',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
