<?php

namespace App\Models\API\V1\Master;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Unit extends Model
{
    use HasApiTokens, HasFactory, Notifiable;//, UsesTenantConnection;

    protected $table = "units";
    protected $fillable = [
        'status',
        'c_id',
        'clinic_name',
        'code',
        'description',
        'cluster_id',
        'server_name',
        'database_name',
        'pharmacy_license_no',
        'tin_no',
        'clinic_reg_no',
        'trade_no',
        'country_id',
        'state_id',
        'city_id',
        'address_line1',
        'address_line2',
        'sub_domain',
        'address_line3',
        'pincode',
        'contact_no',
        'contact_no1',
        'mobile_country_code',
        'mobile_no',
        'resi_no_country_code',
        'resi_std_code',
        'fax_no',
        'email',
        'password',
        'is_processing_unit',
        'is_collection_unit',
        'synchronized',
        'logo',
        'website',
        'is_date_validation',
        'term',
        'department',
        'store',
        'is_unit_with_print',
        'dis_img',
        'gstn_no',
        'area',
        'cin_no',
        'pan_no',
        'reason_for_ad',
        'insta_center_id',
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'added_utc_date_time',
        'added_windows_login_name',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'updated_windows_login_name'.
        'created_at',
        'updated_at',
        'dept_id',
        'store_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_unit_id',
        'updated_unit_id',
        'added_by',
        'added_on',
        'added_date_time',
        'updated_by',
        'updated_on',
        'updated_date_time',
        'updated_utc_date_time',
        'update_windows_login_name',
        'added_windows_login_name',
        'updated_windows_login_name'.
        'created_at',
        'updated_at',
        'permission'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permission' => 'array',
        'added_date_time' => 'datetime',
        'updated_date_time' => 'datetime',
        'updated_utc_date_time' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function unit_department_details()
    {
        return $this->hasMany(UnitDepartmentDetails::class, 'unit_id', 'id');
    }
}
