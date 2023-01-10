<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class GroupChat extends Model
{
    use HasFactory;

    protected $table = 'group_chats';
    
    protected $fillable = [
    	'user_id',
    	'group_id',
        'members_id',
        'group_pic',
        'group_name'
    ];

    protected $casts = [
        'members_id' => 'array'
    ];

    //friendData
    public function user() {
        return $this->hasOne(User::class,'id','user_id');
    }
        
}
