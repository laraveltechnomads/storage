<?php

namespace App\Models\Client;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;//, UsesTenantConnection;

    protected $guard = 'client';
    protected $table = "clients";
    // protected $connection = 'system';
    protected $fillable = [
        'fname',
        'lname',
        'email_address',
        'password',
        'sub_domain',
        'db_name',
        'clinic',
        'contact_no',
        'type',
        'identity',
        'bussiness',
        'terms',
        'plan_status',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permission' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
