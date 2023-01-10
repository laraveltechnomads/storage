<?php

namespace App\Models\API\V1\Agency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciesMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'client_id',
        'description',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'pincode',
        'code',
        'description',	
        'status',	
        'created_unit_id',	
        'updated_unit_id',	
        'added_by',	
        'added_on',	
        'added_date_time',
        'updated_by',	
        'updated_on',	
        'updated_date_time',	
        'added_windows_login_name',	
        'update_windows_login_name',	
        'synchronized',
    ];

    public function agency_unit_list()
    {
        return $this->belongsTo(AgenciesClinicLinking::class, 'agency_id', 'id');
    } 
}
