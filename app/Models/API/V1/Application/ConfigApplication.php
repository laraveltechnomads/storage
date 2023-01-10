<?php

namespace App\Models\API\V1\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit_id',	 // front
        'is_configured',	
        'doctor_id',	 //clinic     ----
        'department_id',	//clinic     ----
        'patient_category_id',	  //patient    -----
        'country',    //	
        'state',    //	
        'district',	
        'pincode',   //application	  ----
        'city',    //	
        'area',    //application	 ---
        'visit_type_id',    //clinic    ----
        'patient_source_id',   //patient     -----
        'appointment_slot',	    //clinic   ----
        'is_ho',	
        'database_name',	
        'email',	 //application   ---                 1
        'nurse_role_id',   //application    ---	
        'admin_role_id',   //application    ---
        'doctor_role_id',   //application    ---

        'conftn_msg_for_add',	
        'search_patients_interval',	  //patient    ----
        'payment_mode_id',	   //application   ---
        'patho_specialization_id',	  //clinic    -----
        'pharmacy_specialization_id',	   //clinic     ----

        'embryologist_id',   //doctor     -----------	
        'anesthetist_id',   //doctor     -----------	
        'radiologist_id',   //doctor	 --------
        'gynecologist_id',   //doctor     -----------	
        'physician_id',	   
        'andriologist_id',   //doctor     -----------	
        'biologist_id',   //doctor     -----------
        'consultation_id',   //clinic     ----
        'self_company_id',   //application    ---
        'self_tariff_id',   //application    ---
        'free_followup_days',	  //clinic    ----
        'free_followup_visit_type_id',   //clinic    ----
        'pharmacy_visit_type_id',   //clinic    -----
        'radiology_specialization_id',   //clinic    ---
        'company_patient_source_id',	  //patient      -----
        'local_language_file_name',	
        'local_language_file_path',
        'self_relation_id',	     	  //patient     ------
        'apply_concession_to_staff',  //application	   ----
        'allow_clinical_transaction',	  //  ---- not define
        'radiology_store_id',    //application    ----
        'pathology_store_id',    //application    ----
        'ot_store_id',	
        'auto_deduct_stock_from_radiology',	
        'auto_deduct_stock_from_pathology',	
        'auto_generate_sample_no',	
        'date_format_id',	 //application
        'synchronized',	
        'attachment',	
        'attachment_file_name',	
        'add_logo_to_all_reports',	
        'pharmacy_patient_category_id',	  //patient	    -----
        'enable_ssl',    //application	  ----                   6
        'host',	    //application    ---                         2
        'password',	//application   ---                          3
        'port',	    //application   ----                         4
        'user_name',    //application   ----                     5	
        'sms_url',	  //application   ---                        7
        'sms_user_name',   //application   ---                   8	
        'sms_password',	   //application   ---
        'print_format_id',   //application	   ---
        'pharmacy_store_id',	 //application    ---
        'radiology_counter_id',	   //clinic     -----
        'pharmacy_counter_id',    //clinic	   -----
        'is_allow_discharge_request',	  //application    ----
        'pathology_department_id',	  //application    ---
        'radiology_department_id',	  //application    ---
        'oocyte_donation_id',	  //patient	 -------
        'embryo_receipent_id',	  //patient	 -------
        'oocyte_receipent_id',	  //patient	 -------
        'inhouse_lab_id',	 //application    ---
        'refund_amount',	 //application   --- 
        'refund_mode',	  //application   --- 
        'store_id_for_mark_up_service_item',	
        'company_category',	
        'is_ipd',	 //clinic    -----
        'ipd_credit_limit',	    //clinic     ------
        'opd_credit_limit',	   //clinic     -------
        'item_expired_indays',	   //application    ---
        'default_country_code',	   //application    ---
        'is_opd',	 //clinic    -----
        'is_counter_login',	
        'opd_counter_id',	  //clinic     ----
        'ipd_counter_id',	  //clinic     ----
        'lab_counter_id',	  //clinic     ----
        'doctor_type_for_referral',	  //doctor    ----
        'identity_for_international_patient',	  //patient    -------
        'authorization_level_for_refund_id',	  //clinic    ------
        'authorization_level_for_concession_id',	  //clinic    ------
        'address_type_id',	
        'country_id',   //application   ---	
        'state_id',   //application	   ---
        'city_id',   //application	 ----
        'region_id',	
        'category_id',	
        'marital_status',	
        'web_site',   //application    ---
        'is_sell_by_selling_unit',	
        'is_central_purchase_store',	 //clinic      ------
        'indent_store_id',	  //----
        'password_to_modify_radiology_report',	
        'pathology_visit_type_id',	    //clinic    -----
        'pathology_company_type_id',	 //clinic    -----
        'pathologist_id',	 //doctor   ----
        'is_photo_move_to_server',	
        'disclaimer',	   //clinic     ----
        'is_pharmacy_ipd',	
        'ipd_pharmacy_credit_limit',	
        'is_pharmacy_opd',	
        'opd_pharmacy_credit_limit',
        'close_visit_minute',
        'patient_cash_limit',          //patient  ----
        'billing_exceed_limit',    //clinic   ----
        'patient_reg_type',     ///patient  ----
    ];
}
  

//billing exceeds limit
//default patient registration type   --patient  
//patient daily cash limit   --patient