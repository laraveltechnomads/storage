<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Model;

class RoleMenuDetails extends Model
{
    protected $fillable = ['id','unit_id','role_id','menu_id','submenu_id','parent_id','status','is_create','is_update','is_all','is_read','is_print','synchronized'];
}
