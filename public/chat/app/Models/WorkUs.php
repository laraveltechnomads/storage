<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Church;
class WorkUs extends Model
{
    use HasFactory;

    protected $table = 'work_us';
    
    protected $fillable = [
    	'user_id',
    	'first_name',
        'last_name',
        'email',
        'mobile_number',
        'description',
        'is_read',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->where('church_id', Church::where('user_id', auth()->user()->id)->value('id'));
    }
}
