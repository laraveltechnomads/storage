<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['user_id','role_id','unit_id','status','addedby','addedon','addeddatetime','updatedby','updatedon','updateddatetime'];
    
    public function roles(){
        return $this->belongsTo(RoleMaster::class, 'role_id', 'id')->where('status', 1);
    }
}
