<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $connection = "admin_db";
    protected $fillable = ['plan_detail','status'];
}
