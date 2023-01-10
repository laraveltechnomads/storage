<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PostComment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
    	'post_id',
    	'user_id',
    	'comment',
    ];

    public function user() {
        return $this->hasOne(User::class,'id','user_id');
    } 
}
