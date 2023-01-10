<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'songs';
    
    protected $fillable = [
    	'song_name',
    	'song_link'
    ];
}
