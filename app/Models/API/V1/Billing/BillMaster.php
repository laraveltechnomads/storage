<?php

namespace App\Models\API\V1\Billing;

use App\Models\API\V1\Clinic\Visit;
use App\Models\API\V1\Register\Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    use HasFactory;
    protected $table = "bill_masters";
    protected $fillable = [
        'bill_id',
        'bill_unit_id',
        'date',
        'bill_type',
        'visit_id',
        'visit_unit_id',
        'admission_id',
        'admission_unit_id',
        'is_against_donor',
        'patient_id',
        'patient_unit_id',
        'cash_counter_id',
        'company_id',
        'patient_source_id',
        'patient_category_id',
        'tariff_id',
        'comp_ref_no',
        'expirydate',
        'camp_id',
        'bill_no',
        'inter_or_final',
        'total_bill_amount',
        'total_settle_disc_amount',
        'total_concession_amount',
        'net_bill_amount',
        'self_amount',
        'non_self_amount',
        'balance_amount_self',
        'balance_amount_non_self',
        'cr_amount',
        'is_free',
        'is_settled',
        'is_cancelled',
        'is_printed',
        'cancellation_date',
        'cancellation_time',
        'cancellation_reason',
        'concession_authorized_by',
        'sponser_type',
        'bill_cancellation_remark',
        'remark',
        'claim_no',
        'bill_remark',
        'status',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_windows_login_name',
        'is_freezed',
        'synchronized',
        'company_bill_cancel_date',
        'company_bill_cancel_reason',
        'isinvoice_generated',
        'calculated_net_bill_amount',
        'concession_reason_id',
        'concession_remark',
        'against_donor',
    ];

    protected $casts = [
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function patient_list(){
        return $this->belongsTo(Registration::class, 'patient_id', 'id');
    }

    public function visit_list(){
        return $this->belongsTo(Visit::class, 'patient_id', 'patient_id');
    }

}
