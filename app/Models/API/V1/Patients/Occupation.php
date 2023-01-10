<?php

namespace App\Models\API\V1\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'description',
        'status',
    ];
}
