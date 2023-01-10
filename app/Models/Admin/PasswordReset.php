<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $connection = "admin_db";
    protected $table = "password_resets";
    protected $fillable = [
        'email',
        'token',
        'expire_otp_time',
        'otp',
        'created_at',
    ];
    public $timestamps = false;
}
