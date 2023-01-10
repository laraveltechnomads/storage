<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'friend_requests';
    
    protected $fillable = [
    	'sender_id',
    	'receiver_id',
    ];

    //senderData
    public function senderData() {
        return $this->hasOne(User::class,'id','sender_id');
    } 

}
