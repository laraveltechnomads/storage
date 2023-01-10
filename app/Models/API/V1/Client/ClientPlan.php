<?php

namespace App\Models\API\V1\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    use HasFactory;
    protected $table = "client_plans";
    protected $connection = "admin_db";
    protected $fillable = [
        'client_id',
        'plan_id',
        'amount',
        'payment_method',
        'transaction_id',
        'transaction_json',
        'invoice_no',
        'razorpay_payment_id',
        'unique_number',
        'cust_id',
        'token_id',
        'expire_on',
        'pay_id',
        'order_id',
        'invoice_id',
        'subscription_id',
        'short_url',
        'international_tran',
        'card_id',
        'bank_id',
        'wallet',
        'vpa_id',
        'expire_on',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
