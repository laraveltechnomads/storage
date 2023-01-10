<?php

namespace App\Models\API\V1\Inventory;

use App\Models\API\V1\Master\Attachment;
use App\Models\API\V1\Master\UserAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'supplier_id',
        'store_id',
        'expiry_date',
        'from',
        'concession_percentage',
        'concession_amount',
        'excise',
        'excise_amount',
        'tax',
        'tax_amount',
        'sgst',
        'sgst_amount',
        'igst',
        'igst_amount',
        'net_amount',
        'specification',
        'item_ids',
    ];
}
