<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Friend extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'friends';
    
    protected $fillable = [
    	'user_id',
    	'friend_id',
    ];

    //friendData
    public function friendData() {
        return $this->hasOne(User::class,'id','friend_id');
    }
}     