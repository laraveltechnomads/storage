<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlackList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'black_lists';

    protected $fillable = [
        'user_id',
        'member_id'
    ];

    public function member_black() {
        return $this->belongsTo(User::class,'member_id','id');
    }
}
