<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Model;

class MenuMaster extends Model
{
   protected $fillable = ['menu_id','sub_title','title','image_path','parent_id','module_id','menu_order','active','path','menu_for'];
}
