<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLoginHistory extends Model
{
    use HasFactory;
    protected $table = "client_login_histories";
    protected $fillable = [
        'client_id',
        'ip_address',
        'browser_name'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id')->where('id', auth()->guard('client')->user()->id);
    }
}