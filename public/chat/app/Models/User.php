<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'uniqid',
        'mobile_number',
        'church_id',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'u_type',
        'ref_user_id',
        'qr_code',
        'pic',
        'deleted_at',
        'device_token',
        'ios_device_token',
        'language',
        'church_website',
        'church_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'church_website'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->u_type == 'ADM') {
            return true;
        } else {
            return false;
        }
    }

    public function isUser()
    {
        if ($this->u_type == 'USR') {
            return true;
        } else {
            return false;
        }
    }

    public function isUserDemo()
    {
        if ($this->u_type == 'USR' && $this->church_id == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isChurch()
    {
        if ($this->u_type == 'CHR') {
            return true;
        } else {
            return false;
        }
    }

    public function church()
    {
        return $this->belongsTo(Church::class, 'email', 'email');
    }

    public function churchData() {
        return $this->belongsTo(Church::class,'church_id','id');
    }

    public function black_list() {
        return $this->belongsTo(BlackList::class,'id','member_id')->where('user_id', auth()->user()->id);
    }

    public function toArray()
    {
        // Only hide email if `guest` or not an `admin`
        if(auth()->check() &&  auth()->user()->isUser()  ) {
            $this->setAttributeVisibility();
        }
        return parent::toArray();
    }

    public function setAttributeVisibility()
    {
        $this->makeVisible(array_merge($this->fillable, $this->appends, ['church_website', 'church_name']));
    }
}
