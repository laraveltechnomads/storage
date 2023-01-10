<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model
{
    use HasFactory;
    protected $connection = "admin_db";
    protected $guard = 'client';
    protected $table = "clients";

    protected $fillable = [
        'fname',
        'lname',
        'email_address',
        'password',
        'sub_domain',
        'db_name',
        'clinic',
        'country_code',
        'contact_no',
        'type',
        'identity',
        'bussiness',
        'terms',
        'plan_status',
        'status'      
    ];
}
