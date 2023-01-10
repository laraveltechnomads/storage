<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Event;

class Church extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'churches';

    protected $fillable = [
            'email',
            'password',
            'uniqid',
            'user_id',
            'church_name',
            'location',
            'mobile_number',
            'website_url',
            'church_image',
            'latitude',
            'longitude'
    ];

    //own details
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    //church events
    public function event()
    {
        return $this->hasMany(Event::class, 'user_id', 'user_id');
    }

    //other app user selected
    public function appUser()
    {
        return $this->hasMany(User::class, 'church_id', 'id');
    }
}