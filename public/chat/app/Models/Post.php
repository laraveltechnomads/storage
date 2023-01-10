<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    	'user_id',
    	'title',
    	'description',
        'likes',
        'shares'
    ];

    public function postMedia() {
        return $this->hasMany(PostMedia::class);
    }

    public function postComment() {
        return $this->hasMany(PostComment::class);
    }

    public function user() {
        return $this->hasOne(User::class,'id','user_id');
    } 

    public function like() {
        return $this->hasMany(Like::class);
    }

}
