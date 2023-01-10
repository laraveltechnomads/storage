<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientDatabase extends Model
{
    protected $connection = "admin_db";
    protected $table = "client_databases";

    protected $fillable = [
    'client_id',
    'database_name'
    ];

    protected $casts = [
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
