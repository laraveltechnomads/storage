<?php

namespace App\Http\Controllers\API\V1\Administration;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Application\ConfigApplication;
use App\Models\API\V1\Application\ConfigAutoEmailNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicationConfigrationController extends Controller
{
    public function listApplicationConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'unit_id' => 'sometimes|required',
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }
        $response = ConfigApplication::join('config_auto_email_news','config_auto_email_news.app_config_id','=','config_applications.id')
        ->where('config_applications.unit_id',$request['unit_id'])
        ->select('config_applications.id',
            'config_applications.email',
            'config_applications.unit_id',
            'config_applications.host',
            'config_applications.password',
            'config_applications.port',
            'config_applications.user_name',
            'config_applications.enable_ssl',
            'config_applications.sms_url',
            'config_applications.sms_user_name',
            'config_applications.sms_password',
            'config_applications.country_id',
            'config_applications.state_id',
            'config_applications.web_site',
            'config_applications.city_id',
            'config_applications.area',
            'config_applications.pincode',
            'config_applications.nurse_role_id',
            'config_applications.admin_role_id',
            'config_applications.doctor_role_id',
            'config_applications.self_company_id',
            'config_applications.self_tariff_id',
            'config_applications.payment_mode_id',
            'config_applications.radiology_store_id',
            'config_applications.pathology_store_id',
            'config_applications.inhouse_lab_id',
            'config_applications.date_format_id',
            'config_applications.print_format_id',
            'config_applications.pharmacy_store_id',
            'config_applications.pathology_department_id',
            'config_applications.radiology_department_id',
            'config_applications.refund_amount',
            'config_applications.refund_mode',
            'config_applications.default_country_code',
            'config_applications.item_expired_indays',
            'config_applications.apply_concession_to_staff',
            'config_applications.is_allow_discharge_request',
            'config_applications.visit_type_id',
            'config_applications.doctor_id',
            'config_applications.department_id',
            'config_applications.appointment_slot',
            'config_applications.free_followup_visit_type_id',
            'config_applications.pharmacy_visit_type_id',
            'config_applications.free_followup_days',
            'config_applications.consultation_id',
            'config_applications.lab_counter_id',
            'config_applications.pharmacy_specialization_id',
            'config_applications.opd_counter_id',
            'config_applications.ipd_counter_id',
            'config_applications.patho_specialization_id',
            'config_applications.radiology_specialization_id',
            'config_applications.pharmacy_counter_id',
            'config_applications.is_ipd',
            'config_applications.ipd_credit_limit',
            'config_applications.is_opd',
            'config_applications.opd_credit_limit',
            'config_applications.radiology_counter_id',
            'config_applications.indent_store_id',
            'config_applications.is_central_purchase_store',
            'config_applications.pathology_visit_type_id',
            'config_applications.pathology_company_type_id',
            'config_applications.billing_exceed_limit',
            'config_applications.disclaimer',
            'config_applications.authorization_level_for_refund_id',
            'config_applications.authorization_level_for_concession_id',
            'config_applications.embryologist_id',
            'config_applications.anesthetist_id',
            'config_applications.andriologist_id',
            'config_applications.gynecologist_id',
            'config_applications.biologist_id',
            'config_applications.pathologist_id',
            'config_applications.doctor_type_for_referral',
            'config_applications.radiologist_id',
            'config_applications.search_patients_interval',
            'config_applications.patient_reg_type',
            'config_applications.self_relation_id',
            'config_applications.patient_source_id',
            'config_applications.company_patient_source_id',
            'config_applications.pharmacy_patient_category_id',
            'config_applications.identity_for_international_patient',
            'config_applications.patient_category_id',
            'config_applications.patient_cash_limit',
            'config_applications.oocyte_donation_id',
            'config_applications.embryo_receipent_id',
            'config_applications.oocyte_receipent_id',
            'config_auto_email_news.ce_sms_event_type_id',
            'config_auto_email_news.email_template_id',
            'config_auto_email_news.sms_template_id',
            'config_auto_email_news.email_id')
        ->first();
        if($response)	
         {	
            return sendDataHelper('Application Configration list.', $response, $code = 200);	
         }else{	
            return sendDataHelper('No content.', $response, $code = 204);	
         }
    }
    public function addUpdateApplicationConfig(Request $request){
        if(respValid($request)) { return respValid($request); } 

        $request = decryptData($request['response']);
        $validator = Validator::make((array)$request,[
            'unit_id' => 'sometimes|required',
            // 'password' => 'sometimes|required|confirmed',
            // 'sms_password' => 'sometimes|required|p_confirmed'
        ]);
        if($validator->fails()){
            return sendErrorHelper($validator->errors()->first(), [], 422);
        }else{

            try{
                if(@$request['email']){
                   $input['email'] =  @$request['email'];
                }
                if(@$request['unit_id']){
                   $input['unit_id'] =  @$request['unit_id'];
                }
                if(@$request['host']){
                   $input['host'] =  @$request['host'];
                }
                if(@$request['password']){
                   $input['password'] =  @$request['password'];
                }
                if(@$request['port']){
                   $input['port'] =  @$request['port'];
                }
                if(@$request['user_name']){
                   $input['user_name'] =  @$request['user_name'];
                }
                if(@$request['enable_ssl']){
                   $input['enable_ssl'] =  @$request['enable_ssl'];
                }
                if(@$request['sms_url']){
                   $input['sms_url'] =  @$request['sms_url'];
                }
                if(@$request['sms_user_name']){
                   $input['sms_user_name'] =  @$request['sms_user_name'];
                }
                if(@$request['sms_password']){
                   $input['sms_password'] =  @$request['sms_password'];
                }
                if(@$request['country_id']){
                   $input['country_id'] =  @$request['country_id'];
                }
                if(@$request['state_id']){
                   $input['state_id'] =  @$request['state_id'];
                }
                if(@$request['web_site']){
                   $input['web_site'] =  @$request['web_site'];
                }
                if(@$request['city_id']){
                   $input['city_id'] =  @$request['city_id'];
                }
                if(@$request['area']){
                   $input['area'] =  @$request['area'];
                }
                if(@$request['pincode']){
                   $input['pincode'] =  @$request['pincode'];
                }
                if(@$request['nurse_role_id']){
                   $input['nurse_role_id'] =  @$request['nurse_role_id'];
                }
                if(@$request['admin_role_id']){
                   $input['admin_role_id'] =  @$request['admin_role_id'];
                }
                if(@$request['doctor_role_id']){
                   $input['doctor_role_id'] =  @$request['doctor_role_id'];
                }
                if(@$request['self_company_id']){
                   $input['self_company_id'] =  @$request['self_company_id'];
                }
                if(@$request['self_tariff_id']){
                   $input['self_tariff_id'] =  @$request['self_tariff_id'];
                }
                if(@$request['payment_mode_id']){
                   $input['payment_mode_id'] =  @$request['payment_mode_id'];
                }
                if(@$request['radiology_store_id']){
                   $input['radiology_store_id'] =  @$request['radiology_store_id'];
                }
                if(@$request['pathology_store_id']){
                   $input['pathology_store_id'] =  @$request['pathology_store_id'];
                }
                if(@$request['inhouse_lab_id']){
                   $input['inhouse_lab_id'] =  @$request['inhouse_lab_id'];
                }
                if(@$request['date_format_id']){
                   $input['date_format_id'] =  @$request['date_format_id'];
                }
                if(@$request['print_format_id']){
                   $input['print_format_id'] =  @$request['print_format_id'];
                }
                if(@$request['pharmacy_store_id']){
                   $input['pharmacy_store_id'] =  @$request['pharmacy_store_id'];
                }
                if(@$request['pathology_department_id']){
                   $input['pathology_department_id'] =  @$request['pathology_department_id'];
                }
                if(@$request['radiology_department_id']){
                   $input['radiology_department_id'] =  @$request['radiology_department_id'];
                }
                if(@$request['refund_amount']){
                   $input['refund_amount'] =  @$request['refund_amount'];
                }
                if(@$request['refund_mode']){
                   $input['refund_mode'] =  @$request['refund_mode'];
                }
                if(@$request['default_country_code']){
                   $input['default_country_code'] =  @$request['default_country_code'];
                }
                if(@$request['item_expired_indays']){
                   $input['item_expired_indays'] =  @$request['item_expired_indays'];
                }
                if(@$request['apply_concession_to_staff']){
                   $input['apply_concession_to_staff'] =  @$request['apply_concession_to_staff'];
                }
                if(@$request['is_allow_discharge_request']){
                   $input['is_allow_discharge_request'] =  @$request['is_allow_discharge_request'];
                }
                if(@$request['visit_type_id']){
                   $input['visit_type_id'] =  @$request['visit_type_id'];
                }
                if(@$request['doctor_id']){
                   $input['doctor_id'] =  @$request['doctor_id'];
                }
                if(@$request['department_id']){
                   $input['department_id'] =  @$request['department_id'];
                }
                if(@$request['appointment_slot']){
                   $input['appointment_slot'] =  @$request['appointment_slot'];
                }
                if(@$request['free_followup_visit_type_id']){
                   $input['free_followup_visit_type_id'] =  @$request['free_followup_visit_type_id'];
                }
                if(@$request['pharmacy_visit_type_id']){
                   $input['pharmacy_visit_type_id'] =  @$request['pharmacy_visit_type_id'];
                }
                if(@$request['free_followup_days']){
                   $input['free_followup_days'] =  @$request['free_followup_days'];
                }
                if(@$request['consultation_id']){
                   $input['consultation_id'] =  @$request['consultation_id'];
                }
                if(@$request['lab_counter_id']){
                   $input['lab_counter_id'] =  @$request['lab_counter_id'];
                }
                if(@$request['pharmacy_specialization_id']){
                   $input['pharmacy_specialization_id'] =  @$request['pharmacy_specialization_id'];
                }
                if(@$request['opd_counter_id']){
                   $input['opd_counter_id'] =  @$request['opd_counter_id'];
                }
                if(@$request['ipd_counter_id']){
                   $input['ipd_counter_id'] =  @$request['ipd_counter_id'];
                }
                if(@$request['patho_specialization_id']){
                   $input['patho_specialization_id'] =  @$request['patho_specialization_id'];
                }
                if(@$request['radiology_specialization_id']){
                   $input['radiology_specialization_id'] =  @$request['radiology_specialization_id'];
                }
                if(@$request['pharmacy_counter_id']){
                   $input['pharmacy_counter_id'] =  @$request['pharmacy_counter_id'];
                }
                if(@$request['is_ipd']){
                   $input['is_ipd'] =  @$request['is_ipd'];
                }
                if(@$request['ipd_credit_limit']){
                   $input['ipd_credit_limit'] =  @$request['ipd_credit_limit'];
                }
                if(@$request['is_opd']){
                   $input['is_opd'] =  @$request['is_opd'];
                }
                if(@$request['opd_credit_limit']){
                   $input['opd_credit_limit'] =  @$request['opd_credit_limit'];
                }
                if(@$request['radiology_counter_id']){
                   $input['radiology_counter_id'] =  @$request['radiology_counter_id'];
                }
                if(@$request['indent_store_id']){
                   $input['indent_store_id'] =  @$request['indent_store_id'];
                }
                if(@$request['is_central_purchase_store']){
                   $input['is_central_purchase_store'] =  @$request['is_central_purchase_store'];
                }
                if(@$request['pathology_visit_type_id']){
                   $input['pathology_visit_type_id'] =  @$request['pathology_visit_type_id'];
                }
                if(@$request['pathology_company_type_id']){
                   $input['pathology_company_type_id'] =  @$request['pathology_company_type_id'];
                }
                if(@$request['billing_exceed_limit']){
                   $input['billing_exceed_limit'] =  @$request['billing_exceed_limit'];
                }
                if(@$request['disclaimer']){
                   $input['disclaimer'] =  @$request['disclaimer'];
                }
                if(@$request['authorization_level_for_refund_id']){
                   $input['authorization_level_for_refund_id'] =  @$request['authorization_level_for_refund_id'];
                }
                if(@$request['authorization_level_for_concession_id']){
                   $input['authorization_level_for_concession_id'] =  @$request['authorization_level_for_concession_id'];
                }
                if(@$request['embryologist_id']){
                   $input['embryologist_id'] =  @$request['embryologist_id'];
                }
                if(@$request['anesthetist_id']){
                   $input['anesthetist_id'] =  @$request['anesthetist_id'];
                }
                if(@$request['andriologist_id']){
                   $input['andriologist_id'] =  @$request['andriologist_id'];
                }
                if(@$request['gynecologist_id']){
                   $input['gynecologist_id'] =  @$request['gynecologist_id'];
                }
                if(@$request['biologist_id']){
                   $input['biologist_id'] =  @$request['biologist_id'];
                }
                if(@$request['pathologist_id']){
                   $input['pathologist_id'] =  @$request['pathologist_id'];
                }
                if(@$request['doctor_type_for_referral']){
                   $input['doctor_type_for_referral'] =  @$request['doctor_type_for_referral'];
                }
                if(@$request['radiologist_id']){
                   $input['radiologist_id'] =  @$request['radiologist_id'];
                }
                if(@$request['search_patients_interval']){
                   $input['search_patients_interval'] =  @$request['search_patients_interval'];
                }
                if(@$request['patient_reg_type']){
                   $input['patient_reg_type'] =  @$request['patient_reg_type'];
                }
                if(@$request['self_relation_id']){
                   $input['self_relation_id'] =  @$request['self_relation_id'];
                }
                if(@$request['patient_source_id']){
                   $input['patient_source_id'] =  @$request['patient_source_id'];
                }
                if(@$request['company_patient_source_id']){
                   $input['company_patient_source_id'] =  @$request['company_patient_source_id'];
                }
                if(@$request['pharmacy_patient_category_id']){
                   $input['pharmacy_patient_category_id'] =  @$request['pharmacy_patient_category_id'];
                }
                if(@$request['identity_for_international_patient']){
                   $input['identity_for_international_patient'] =  @$request['identity_for_international_patient'];
                }
                if(@$request['patient_category_id']){
                   $input['patient_category_id'] =  @$request['patient_category_id'];
                }
                if(@$request['patient_cash_limit']){
                   $input['patient_cash_limit'] =  @$request['patient_cash_limit'];
                }
                if(@$request['oocyte_donation_id']){
                   $input['oocyte_donation_id'] =  @$request['oocyte_donation_id'];
                }
                if(@$request['embryo_receipent_id']){
                   $input['embryo_receipent_id'] =  @$request['embryo_receipent_id'];
                }
                if(@$request['oocyte_receipent_id']){
                   $input['oocyte_receipent_id'] =  @$request['oocyte_receipent_id'];
                }
                if(@$request['ce_sms_event_type_id']){
                   $add['ce_sms_event_type_id'] =  @$request['ce_sms_event_type_id'];
                }
                if(@$request['email_template_id']){
                   $add['email_template_id'] =  @$request['email_template_id'];
                }
                if(@$request['sms_template_id']){
                   $add['sms_template_id'] =  @$request['sms_template_id'];
                }
                if(@$request['email_id']){
                   $add['email_id'] =  @$request['email_id'];
                }
                if(@$request['unit_id']){
                    $find_config = ConfigApplication::where('unit_id',@$request['unit_id'])->first();
                    $find_auto_config = ConfigAutoEmailNew::where('unit_id',@$request['unit_id'])->first();
                }else{
                    $find_config = ConfigApplication::where('unit_id',NULL)->first();
                    $find_auto_config = ConfigAutoEmailNew::where('unit_id',NULL)->first();
                }
                $add['unit_id'] =  @$find_config->unit_id ? @$find_config->unit_id : @$request['unit_id'];
                if($find_config && $find_auto_config){
                    $config = $find_config->update($input);
                    $add['app_config_id'] =  @$find_config->id;
                    $config_find = $find_auto_config->update($add);
                }else{
                    $config = ConfigApplication::create($input);
                    $add['app_config_id'] =  @$config->id;
                    $config_find = ConfigAutoEmailNew::create($add); 
                }
                if($request){
                    return sendDataHelper('Application Configration Add Successfully.', [], 200);
                }else{
                    return sendError('please provide valid id.', [], 400);
                }
            }catch(\Throwable $e){
                DB::rollBack();
                $bug = $e->getMessage();
                return sendErrorHelper('Error', $bug, 400);
            }
        }
    }
}
