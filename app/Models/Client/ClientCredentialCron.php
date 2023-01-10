<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCredentialCron extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_fname',
        'client_lname',
        'email_address',
        'sub_domain',
        'db_name',
        'client_json',
        'status',
    ];
}
