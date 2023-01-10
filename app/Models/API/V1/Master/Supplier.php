<?php

namespace App\Models\API\V1\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_code',
        'description',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'country_code',
        'state_code',
        'city_code',
        'pin_code',
        'contact_person1_name',
        'contact_person1_mobile_no',
        'contact_person1_email_id',
        'contact_person2_name',
        'contact_person2_mobile_no',
        'contact_person2_email_id',
        'phone_no',
        'fax',
        'mode_of_payment',
        'tax_nature',
        'term_of_payment',
        'cu_id',
        'mast_number',
        'vat_number',
        'cst_number',
        'drug_licence_number',
        'service_tax_number',
        'pan_number',
        'm_flag',
        'depreciation',
        'rating_system',
        'supplier_category_id',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'updated_by',
        'updated_date_time',
        'updated_utc_date_time',
        'added_windows_login_name',
        'update_windows_login_name',
        'synchronized',
        'area',
        'po_auto_close',
        'gstin_number',
    ];
}

