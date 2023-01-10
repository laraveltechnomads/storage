<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diaries';
    
    protected $fillable = [
    	'user_id',
    	'title',
    	'description',  
        'image'
    ];
}
