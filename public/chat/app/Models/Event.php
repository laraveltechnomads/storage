<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Church;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'events';
    
    protected $fillable = [
    	'user_id',
    	'title',
    	'schedule',
    	'description'
    ];

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:i:s',
    //     'updated_at' => 'datetime:Y-m-d H:i:s',
    // ];

    //events church 
    public function church()
    {
        return $this->hasMany(Church::class, 'user_id', 'user_id');
    }
}
