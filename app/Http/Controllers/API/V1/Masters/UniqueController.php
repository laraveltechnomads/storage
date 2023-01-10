<?php

namespace App\Http\Controllers\API\V1\Masters;

use App\Http\Controllers\Controller;
use App\Models\Admin\PatientCategory;
use App\Models\API\V1\Application\Classification;
use App\Models\API\V1\Application\RelationMaster;
use App\Models\API\V1\Billing\ServiceMaster;
use App\Models\API\V1\Client\CompanyTypeMaster;
use App\Models\API\V1\Client\DoctorShare;
use App\Models\API\V1\Client\DoctorShareSpecialization;
use App\Models\API\V1\Client\ExpenseMaster;
use App\Models\API\V1\Client\ModeOfPayment;
use App\Models\API\V1\Clinic\Store;
use App\Models\API\V1\Clinic\VisitType;
use App\Models\API\V1\Inventory\CostCenterCode;
use App\Models\API\V1\Inventory\Item;
use App\Models\API\V1\Master\BloodGroup;
use App\Models\API\V1\Master\City;
use App\Models\API\V1\Master\Country;
use App\Models\API\V1\Master\CoupleLink;
use App\Models\API\V1\Master\Department;
use App\Models\API\V1\Master\Doctor;
use App\Models\API\V1\Master\DoctorCategory;
use App\Models\API\V1\Master\DoctorScheduleDetail;
use App\Models\API\V1\Master\DoctorType;
use App\Models\API\V1\Master\Gender;
use App\Models\API\V1\Master\IdProof;
use App\Models\API\V1\Master\MaritalStatus;
use App\Models\API\V1\Master\RoleMaster;
use App\Models\API\V1\Master\SourceOfReference;
use App\Models\API\V1\Master\Specialization;
use App\Models\API\V1\Master\State;
use App\Models\API\V1\Master\TimeSlot;
use App\Models\API\V1\Master\Unit;
use App\Models\API\V1\Register\BabyRegistration;
use App\Models\API\V1\Register\CoupleRegistration;
use App\Models\API\V1\Register\Registration;
use App\Models\API\V1\Inventory\ItemGroup;
use App\Models\API\V1\Inventory\ItemCategory;
use App\Models\API\V1\Inventory\Molecule;
use App\Models\API\V1\Inventory\PregnancyClass;
use App\Models\API\V1\Inventory\ShelfMaster;
use App\Models\API\V1\Inventory\StorageType;
use App\Models\API\V1\Inventory\Therapeutic;
use App\Models\API\V1\IPD\BedAmenityMaster;
use App\Models\API\V1\IPD\BlockMaster;
use App\Models\API\V1\IPD\ClassMaster;
use App\Models\API\V1\IPD\FloorMaster;
use App\Models\API\V1\IPD\IdentityMaster;
use App\Models\API\V1\IPD\RoomAmenityMaster;
use App\Models\API\V1\IPD\RoomMaster;
use App\Models\API\V1\IPD\WardType;
use App\Models\API\V1\Master\EmailTemplate;
use App\Models\API\V1\Master\Events;
use App\Models\API\V1\Master\Ledger;
use App\Models\API\V1\Master\SmsTemplate;
use App\Models\API\V1\Master\SubSpecialization;
use App\Models\API\V1\Master\Supplier;
use App\Models\API\V1\Master\SupplierCategory;
use App\Models\API\V1\Patients\CompanyMaster;
use App\Models\API\V1\Patients\PatientSource;
use App\Models\API\V1\Patients\TariffMaster;
use App\Models\API\V1\Patients\Appointment;
use App\Utils\Apppointment\ReasonUtil;
use Illuminate\Http\Request;
use App\Utils\Clinic\DoctorUtil;
use App\Utils\Master\UniqueUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UniqueController extends Controller
{
    protected $unique_util;
    protected $doctor_util;
    protected $reason_util;

    public function __construct(UniqueUtil $unique_util, DoctorUtil $doctor_util, ReasonUtil $reason_util)
    {
        $this->unique_util = $unique_util;
        $this->doctor_util = $doctor_util;
        $this->reason_util = $reason_util;
    }

    /* Clinic details */
    public function unitClinicDetails(Request $request)
    {
        try {
            $units = Unit::select('id','clinic_name')->whereStatus(1)->get();
            $class_list = ClassMaster::select('id','description as name')->whereStatus(1)->get();
            $blood_group = BloodGroup::select('id', 'blood_code','description')->whereStatus(1)->get();
            $gender = Gender::select('id', 'gender_code','description')->whereStatus(1)->get();
            $marital_status = MaritalStatus::get();
            $service = ServiceMaster::where('status',1)->get(['id','description as service_name','service_code','base_service_rate as rate']);
            $patient_categories = PatientCategory::whereNotIn('reg_code', [config('constants.patientType')[1] ])->select('reg_code', 'description', 'status')->whereStatus(1)->get();
            $id_proofs = IdProof::select('proof_code', 'description', 'status')->whereStatus(1)->get();
            $time_slot = TimeSlot::select('id as time_slot_id', 'time', 'type', 'description', 'time_of_day')->get();
            $department = Department::select('id as department_id', 'code', 'description', 'is_clinical')->whereStatus(1)->get();
            $doctor_category = DoctorCategory::select('id as doc_cat_id', 'code as doc_cat_code', 'description')->whereStatus(1)->get();
            $doctor_type = DoctorType::select('id as doc_type_id', 'code as doc_type_code', 'description', 'synchronized')->whereStatus(1)->get();
            $country = Country::where('status', 1)->select('id as country_id', 'country_code', 'country_name', 'default_country', 'order_by')->get();
            $source_of_reference = SourceOfReference::where('status',1)->select('id','description as name')->get();
            $sub_specialization = SubSpecialization::where('status',1)->select('id','description as name')->get();
            $specialization = Specialization::where('status',1)->select('id','description as name')->get();
            $company_type = CompanyTypeMaster::where('status',1)->select('id','comp_type_code as code','description as name')->get();
            $cost_center = CostCenterCode::where('status',1)->select('id','code','description as name')->get();
            $get_doc_share = DoctorShare::where('status',1)->get()->pluck('doc_id');
            $pending_doc_list = Doctor::where('status',1)
            ->whereNotIn('id',$get_doc_share)
            ->select('id','id as doctor_id',DB::raw("CONCAT(`first_name`, ' ', `last_name`) AS name"))
            ->get(); 
            $doctor_list = Doctor::where('status',1)
            ->select('id','id as doctor_id',DB::raw("CONCAT(`first_name`, ' ', `last_name`) AS name"))
            ->get();
            $expenses_list = ExpenseMaster::where('status',1)->get(['id','description as name']);
            $block_list = BlockMaster::where('status',1)->get(['id','description as name']);
            $floor_list = FloorMaster::where('status',1)->get(['id','description as name']);
            $word_type = WardType::where('status',1)->get(['id','description as name']);
            $amenity_type = RoomAmenityMaster::where('status',1)->get(['id','description as name']);
            $room_list = RoomMaster::where('status',1)->get(['id','description as name']);
            $role_master = RoleMaster::where('status',1)->get(['id','description as name']);
            $bed_amenity_type = BedAmenityMaster::where('status',1)->get(['id','description as name']);
            $company = CompanyMaster::where('status',1)->get(['id','comp_code as code','description as name']);
            $payment_mode = ModeOfPayment::where('status',1)->get(['id','description as name']);
            $patient_reg_type = PatientCategory::where('status',1)->get(['id','description as name']);
            $self_relation = RelationMaster::where('status',1)->get(['id','description as name']);
            $visit_type = VisitType::where('status',1)->get(['id','description']);
            $classification = Classification::where('status',1)->get(['id','description']);
            $patient_source = PatientSource::where('status',1)->get(['id','description']);
            $identity_master = IdentityMaster::where('status',1)->get(['id','description']);
            $sms_template = SmsTemplate::where('status',1)->get(['id','code','template_name as name','subject','text']);
            $email_template = EmailTemplate::where('status',1)->get(['id','code','template_name as name','subject','text']);
            $event = Events::where('status',1)->get(['id','code','description as name']);

            $tarrif_lists = TariffMaster::groupBy('description')->whereStatus(1)->get(['id','description']);
            $weight_type = [
                [
                    "id" => 1,
                    "code" => "kg",
                    "description" => "KG"
                ],
                [
                    "id" => 2,
                    "code" => "gm",
                    "description" => "GM"
                ],
            ];
            $donotion_type = [
                [
                    "id" => 1,
                    "description" => "FET"
                ],
                [
                    "id" => 2,
                    "description" => "ICSI"
                ],
                [
                    "id" => 3,
                    "description" => "IUI-D"
                ],
                [
                    "id" => 4,
                    "description" => "IUI-H"
                ],
                [
                    "id" => 5,
                    "description" => "IVF"
                ],
                [
                    "id" => 6,
                    "description" => "IVF - ICSI"
                ],
                [
                    "id" => 7,
                    "description" => "Oocyte / Embryo Donation"
                ],
                [
                    "id" => 7,
                    "description" => "Oocyte / Embryo Recepient"
                ],
            ];
            $store = Store::where('status',1)->get(['id','description']);
            $itemGroup = ItemGroup::where('status',1)->get(['id', 'description']);
            $itemCategory = ItemCategory::where('status', 1)->get(['id', 'description']);
            $pregnancy_class = PregnancyClass::where('status', 1)->get(['id', 'description']);
            $therapeutic = Therapeutic::where('status', 1)->get(['id', 'description']);
            $molecule = Molecule::where('status',1)->get(['id', 'description']);
            $supplierCategory = SupplierCategory::where('status',1)->get(['id','description']);
            $supplier = Supplier::where('status',1)->get(['id','description']);
            $storage_types = StorageType::where('status',1)->get(['id','description']);
            $shelf_master = ShelfMaster::where('status',1)->get(['id','description']);
            $generalLedger = Ledger::get('general_ledger');

            $data  = [
                'clinics' => $units,
                'weight_type' => $weight_type,
                'blood_groups' => $blood_group,
                'genders' => $gender,
                'service_list' =>  $service,
                'marital_status' => $marital_status,
                'patient_categories' => $patient_categories,
                'id_proofs' => $id_proofs,
                'source_of_reference' => $source_of_reference,
                'reference_details' => $this->unique_util->reference_details(),
                'referral_doctor' => $this->doctor_util->doctors_details(auth_unit_id()),
                'ethnicity' => $this->unique_util->ethnicity(),
                'education' => $this->unique_util->education(),
                'occuption' => $this->unique_util->occuption(),
                'married_since' => $this->unique_util->married_since(),
                'existing_children' => $this->unique_util->existing_children(),
                'family' => $this->unique_util->family(),
                'patient_source' => $patient_source,
                'company_name' => $this->unique_util->company_name(),
                'associate_company_name' => $this->unique_util->associate_company_name(),
                'tarrif_list' => $tarrif_lists,
                'visit_type' => $visit_type,
                'religion' => $this->unique_util->religion(),
                'time_slot' => $time_slot,
                'self_relation' => $self_relation,
                'department' => $department,
                'doctor_category' => $doctor_category,
                'identity_master' => $identity_master,
                'doctor_type' => $doctor_type,
                'doctors' => $this->doctor_util->doctors_details(auth_unit_id()),
                'pending_doc_list' => $pending_doc_list,
                'doctor_list' => $doctor_list,
                'app_reasons' => $this->reason_util->reason_appointment(auth_unit_id()),
                'countries' => $country,
                'sub_specialization' => $sub_specialization,
                'patient_reg_type' => $patient_reg_type,
                'donotion_type' => $donotion_type,
                'specialization' => $specialization,
                'company_type' => $company_type,
                'cost_center_code_list' => $cost_center,
                'store' => $store,
                'building_list' => $block_list,
                'word_type' => $word_type,
                'sms_template' => $sms_template,
                'event' => $event,
                'email_template' => $email_template,
                'role_master' => $role_master,
                'classification' => $classification,
                'payment_mode' => $payment_mode,
                'company' => $company,
                'bed_amenity_type' => $bed_amenity_type,
                'room_amenities' => $amenity_type,
                'room_list' => $room_list,
                'room_class_list' => $class_list,
                'floor_list' => $floor_list,
                'expenses_list' => $expenses_list,
                'item_group' => $itemGroup,
                'item_category' => $itemCategory,
                'molecule' => $molecule,
                'pregnancy_class' => $pregnancy_class,
                'therapeutic_class' => $therapeutic,
                'storage_types' => $storage_types,
                'shelf_master' => $shelf_master,
                'supplier' => $supplier,
                'supplier_category' => $supplierCategory,
                'general_ledger' => $generalLedger
            ];
            return sendDataHelper('Master table details.', $data, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

     /* Patieny categories list*/
    public function patientCategoriesList(Request $request)
    {
        try {
            $patient_categores = PatientCategory::select('reg_code', 'description', 'status')->whereStatus(1)->get();
            return sendDataHelper('Patients categories list.', $patient_categores->toArray(), $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Selected country details*/
    public function countryDetail(Country $country)
    {
        try {
            return sendDataHelper('Details.', $country->toArray(), $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    /* Selected country to state details*/
    public function stateDetails(Country $country)
    {
        try {
            $states = State::where('country_id', $country->id)->where('status', 1)->get();
            return sendDataHelper('Details.', $states->toArray(), $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Selected state to  city details*/
    public function cityDetails(State $state)
    {
        try {
            $cities = City::where('state_id', $state->id)->get();
            return sendDataHelper('Details.', $cities->toArray(), $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Selected details*/
    public function selectedDetails(Request $request, $category, $selected_id)
    {
        try {
            if($category)
            {
                if($category == 'country'){
                    $details = Country::where('id', $selected_id)->where('status', 1)->first();
                }elseif($category == 'state'){
                    $details = State::where('id', $selected_id)->where('status', 1)->first();
                }elseif($category == 'city'){
                    $details = City::where('id', $selected_id)->where('status', 1)->first();
                }else{
                    return sendError('Record not found', [], 422);
                }
                return sendDataHelper('Details.', $details->toArray(), $code = 200);
            }else{
                return sendError('Record not found', [], 422);
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* File pathDetails */
    public function filePathDetails(Request $request)
    {   
        try {
            $data = [
                'patients' => get_patients_path(),
                'patients_profile_path' => get_patients_profile__path(),
                'patients_file_path' => get_patients_file__path()
            ];
            return sendDataHelper('File path details.', $data, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Patient file download */
    public function patientFileDownload(Request $request)
    {
        try {
            $dataNull = [];
            /* Partner */
            if($request->registration_type == config('constants.patientType')[1])
            {
                $partner = Registration::where('id', $request->registration_number)->first();
                if($partner && $partner->identity_file)
                {
                    $imgData = convertBase64($partner->identity_file);
                    return sendDataHelper('File path details.', $imgData, $code = 200);
                }
            }
            return sendDataHelper('File download.', $dataNull, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Baby parents search **/
    public function babyParentsSearch(Request $request)
    {
        try {
            $search = null;
            $unit_id = auth()->user()->unit_id;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search'];  /* Not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            if(isset($search))
            {
                $female_ids = [];
                $female = Registration::query();
                $female->where('registration_type', config('constants.patientType')[0]);
                $female->where('patientUnitId', auth()->user()->unit_id);
                $female->where('gender', 2);
                $female->where('first_name', 'like', "%{$search}%");
                $female->orWhere('middle_name', 'like', "%{$search}%");
                $female->orWhere('last_name', 'like', "%{$search}%");
                $female->orWhere('contact_no', 'like', "%{$search}%");
                $female->orWhere('mrn_number', 'like', "%{$search}%");
                $female = $female->get();

                if( count($female) > 0)
                {
                    $female_ids = $female->pluck('id');
                }

                if( count($female_ids) > 0)
                {
                    $couple_registration = CoupleRegistration::where('female_patient_unit_id', auth()->user()->unit_id)->whereIn('female_patient_id', $female_ids)->whereStatus(1)->get();
                    
                    foreach ($couple_registration as $key => $cpl) {
                        $mother = Registration::where('patientUnitId', $unit_id)->where('id', $cpl->female_patient_id)->first();
                        $father = Registration::where('patientUnitId', $unit_id)->where('id', $cpl->male_patient_id)->first();
                        $coupleArr = [
                            'couple_registration_number' => $cpl->id,
                            'mrn_number' => $mother->mrn_number,
                            'mother_name' => $mother->first_name.' '.$mother->last_name,
                            'father_name' => ($father ?  $father->first_name.' '.$father->last_name : null)
                        ];
                        array_push($response, $coupleArr);
                    }
                }
            }
            if($response == [])
            {
                return sendDataHelper('Parents details.', $response, $code = 204);
            }
            return sendDataHelper('Parents details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }     
    }

    /* patients details */
    public function patientsDetails(Request $request)
    {
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }

            $response = [];
            $data_store = Registration::query();
            $data_store->where('patientUnitId', auth()->user()->unit_id);
            $data_store->orderBy('registration_type', 'asc');

            if(isset($search))
            {
                $data_store->orWhere('first_name', 'like', "%{$search}%");
                $data_store->orWhere('middle_name', 'like', "%{$search}%");
                $data_store->orWhere('last_name', 'like', "%{$search}%");
                $data_store->orWhere('contact_no', 'like', "%{$search}%");
                $data_store->orWhere('mrn_number', 'like', "%{$search}%");
            }
            
            $data_store = $data_store->latest()->get();
            
            $response = [];
            if(count($data_store) > 0)
            {
                foreach ($data_store as $key => $value) {
                    
                    $registration_number = $value->id;
                    $value['registration_number'] = $value->id;
                    $value['gender_name'] = ( $value->gender == 2 ? 'Female' : 'Male' );
                    $value['clinic_name'] = Unit::where('id', $value->patientUnitId)->value('clinic_name');

                    $part_reg = 0;
                    $couple = CoupleRegistration::where('female_patient_id', $value->id)->first();
                    if($couple)
                    {
                        $part_reg_id = $couple->male_patient_id;
                    }
                    $partner = Registration::query();
                    $partner->where('id', $part_reg_id);
                    if(isset($search))
                    {
                        $partner->where('first_name', 'like', "%{$search}%");
                        $partner->orWhere('middle_name', 'like', "%{$search}%");
                        $partner->orWhere('last_name', 'like', "%{$search}%");
                        $partner->orWhere('contact_no', 'like', "%{$search}%");
                        $partner->orWhere('mrn_number', 'like', "%{$search}%");
                    }
                    $partner_details = $partner->get();

                    $partner_response = [];
                    if(count($partner_details) > 0)
                    {
                        foreach ($partner_details as $key => $part) {
                            $partArr = [
                                'couple_registration_number' => $part_reg_id,
                                'registration_type' => $part->registration_type,
                                'mrn_number' => $part->mrn_number,
                                'first_name' => $part->first_name,
                                'last_name' => $part->last_name,
                                'gender' => Gender::where('id', $part->gender)->value('description')
                            ];
                            array_push($partner_response, $partArr);
                        }
                    }
                    $value['partner_details'] = $partner_response;

                    $couple_id = 0;
                    $couple = CoupleRegistration::where('female_patient_id', $registration_number)->first();
                    if($couple)
                    {
                        $couple_id = $couple->id;
                    }
                    $baby_reg = BabyRegistration::query();
                    $baby_reg->where('couple_registration_number', $couple_id);           
                    $baby_details = $baby_reg->get();

                    $baby_response = [];
                    if(count($baby_details) > 0)
                    {
                        foreach ($baby_details as $key => $baby) {
                            $partArr = [
                                'couple_registration_number' => $baby->couple_registration_number,
                                'registration_type' => $baby->registration_type,
                                'mrn_number' => $baby->mrn_number,
                                'first_name' => $baby->first_name,
                                'last_name' => $baby->last_name,
                                'gender' => Gender::where('id', $baby->gender)->value('description')
                            ];
                            array_push($baby_response, $partArr);
                        }
                    }
                    $value['baby_details'] = $baby_response;

                    $dataArr = [
                        'registration_number' => $registration_number,
                        'registration_type' => $value->registration_type,
                        'mrn_number' => $value->mrn_number,
                        'first_name' => $value->first_name,
                        // 'middle_name' => $value->middle_name,
                        'last_name' => $value->last_name,
                        // 'profile_image' => $value->profile_image,
                        'gender' => Gender::where('id', $value->gender)->value('description'),
                        // 'contact_no' => $value->contact_no,
                        // 'email_address' => $value->email_address,
                        // 'date_of_birth' => $value->date_of_birth,
                        // 'age' => $value->age,
                        // 'identity_proof' => $value->identity_proof,
                        // 'identity_proof_no' => $value->identity_proof_no,
                        // 'reference_details' => $value->reference_details,
                        // 'referral_doctor' => $value->referral_doctor,
                        // 'registration_date' => $value->registration_date,
                        // 'patientUnitId' => $value->patientUnitId,
                        'partner_details' => $value['partner_details'],
                        'baby_details' => $value['baby_details']
                    ];
                    array_push($response, $dataArr);
                }
            }
            return sendDataHelper('Patient details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function patientDetailText(Request $request){
        $validation = Validator::make($request->all(),[
            'response'=>'required',
        ]);
        if($validation->fails()){
            return sendErrorHelper("Validation Error", $validation->errors()->first(),422);
        }
        $data = decryptData($request['response']);
        $validation = Validator::make((array)$data,[
            'id'=>'required',
            'type'=>'required',
        ]);
        if($validation->fails()){
            return sendErrorHelper("Validation Error", $validation->errors()->first(),422);
        }else{
            $patient_data = Registration::where(['id' => $data['id'],'status'=>1])->first();
            
            $response = [
                'id' => $patient_data->id,
                'full_name' => $patient_data->first_name.' '.$patient_data->middle_name.' '.$patient_data->last_name,
                'email' => $patient_data->email_address,
                'age' => $patient_data->age.' Years',
                'contact' => $patient_data->contact_no,
                'profile_image' => ($patient_data->profile_image != "") ? $patient_data->profile_image : "",
                'mrn_no' => $patient_data->mrn_number,
                'dob' => date('d/m/Y', strtotime($patient_data->date_of_birth) ),
                'type' => $data['type'],
                'doctor' => "Dr. Marian",
            ];
            return sendDataHelper('Couple Details text.', $response, $code = 200);
        }
    }
    public function bodyParameterEncrypt(Request $request)
    {
        try {
            $data = $request->all();
            return sendDataHelper('Body encrypted.', $data, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function searchDoctor(Request $request)
    {
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            if(isset($search))
            {   
                $doc_sched_dtl = DoctorScheduleDetail::get();
                $doctors = Doctor::query();
                // $doctors->where('patientUnitId', auth()->user()->unit_id);
                $doctors->where('first_name', 'like', "%{$search}%");
                $doctors->orWhere('middle_name', 'like', "%{$search}%");
                $doctors->orWhere('last_name', 'like', "%{$search}%");
                // $doctors->orWhere('contact_no', 'like', "%{$search}%");
                // $doctors->orWhere('mrn_number', 'like', "%{$search}%");
                $doctors = $doctors->get();
                if( count($doctors) > 0)
                {
                    foreach ($doctors as $key => $doc) {
                        $doctorArr = [
                            'first_name' => $doc->first_name,
                            'middle_name' => $doc->middle_name,
                            'last_name' => $doc->last_name,
                            'gender' => Gender::where('id', $doc->gender_id)->value('description')
                        ];
                        array_push($response, $doctorArr);
                    }
                }
            }
            return sendDataHelper('Doctor details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
    public function searchCoupleList(Request $request){
        try {
            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search'];  /* not search developer search data is null passed.(ex: search: null ) */ 
                }
            }
            $response = [];
            if(isset($search))
            {
                $female_ids = [];
                $female = Registration::query();
                // $female->where('registration_type', config('constants.patientType')[0]);
                // $female->where('patientUnitId', auth()->user()->unit_id);
                $female->where('first_name', 'like', "%{$search}%");
                $female->orWhere('middle_name', 'like', "%{$search}%");
                $female->orWhere('last_name', 'like', "%{$search}%");
                $female->orWhere('contact_no', 'like', "%{$search}%");
                $female->orWhere('mrn_number', 'like', "%{$search}%");
                $female = $female->get();

                if( count($female) > 0)
                {
                    $female_ids = $female->pluck('id');
                }

                $ids = $female_ids;

                if( count($ids) > 0)
                {
                    if(@$request['id']){
                        $couple_data = Registration::whereIn('id', $ids)->where('id','!=',$request['id'])->get();
                    }else{
                        $couple_data = Registration::whereIn('id', $ids)->get();
                    }
                    
                    foreach ($couple_data as $key => $cpl) {
                        $coupleArr = [
                            'id' => $cpl->id,
                            'full_name' => $cpl->first_name.' '.$cpl->middle_name.' '.$cpl->last_name,
                            'mrn_number' => $cpl->mrn_number,
                            'contact_no' => $cpl->contact_no,
                            'type' => $request['type'],
                        ];
                        array_push($response, $coupleArr);
                    }
                }
            }

            if($response == [])	
            {	
                return sendDataHelper('No content.', $response, $code = 204);	
            }else{	
                return sendDataHelper('Couple link details.', $response, $code = 200);	
            }
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }   
    }
    
    public function patientCoupleLink(Request $request){
        $validation = Validator::make($request->all(),[
            'response'=>'required',
        ]);
        if($validation->fails()){
            return sendErrorHelper("Validation Error", $validation->errors()->first(),422);
        }
        $data = decryptData($request['response']);
        $validation = Validator::make((array)$data,[
            'parent_id'=>'required',
            'spouse_id'=>'required',
        ]);
        if($validation->fails()){
            return sendErrorHelper("Validation Error", $validation->errors()->first(),422);
        }else{
            $parent_id = Registration::where(['id' => $data['parent_id'],'status'=>1])->first();
            $spouse_id = Registration::where(['id' => $data['spouse_id'],'status'=>1])->first();
            $find_same_couple = CoupleLink::where(['patient_id' => $parent_id->id,'spouse_id' => $spouse_id->id ,'status'=>1])->first();
            if($find_same_couple){
                return sendErrorHelper(false, "This couple is already exist!.",422);
            }else{
                $couple_id = CoupleLink::create([
                    'patient_id' => $parent_id->id,
                    'patient_unit_id' => $parent_id->patientUnitId,
                    'created_unit_id' => $parent_id->patientUnitId,
                    'spouse_id' => $spouse_id->id,
                    'spouse_unit_id' => $spouse_id->patientUnitId,
                    'updated_unit_id' => $spouse_id->patientUnitId,
                    'status' => 1
                ])->id;
                $response = [
                    'patient_id' => $parent_id->id,
                    'patient_unit_id' => $parent_id->patientUnitId,
                    'created_unit_id' => $parent_id->patientUnitId,
                    'spouse_id' => $spouse_id->id,
                    'spouse_unit_id' => $spouse_id->patientUnitId,
                    'updated_unit_id' => $spouse_id->patientUnitId,
                    'status' => 1
                ];
                return sendDataHelper('Couple Link Details.', $response, $code = 200);
            }
        }
    }

    /* Search patient details - name, mrn_number & contact_no */
    public function searchPatients(Request $request)
    {
        try {

            $search = null;
            if($request['response'])
            {
                $request = decryptData($request['response']); /* Dectrypt  **/
                if($request)
                {
                   $search = @$request['search'];  /* Not search developer search data is null passed.(ex: search: null ) */ 
                }
            }

            $response = [];

            // DB::enableQueryLog();
            $reg = Registration::query();
            $reg->where('patientUnitId', auth_unit_id());
            $reg->orderBy('registration_type', 'asc');

            if($search)
            {
                $reg->where('first_name', 'like', "%$search%");
                $reg->orWhere('middle_name', 'like', "%$search%");
                $reg->orWhere('last_name', 'like', "%$search%");
                $reg->orWhere('contact_no', 'like', "%$search%");
                $reg->orWhere('mrn_number', 'like', "%$search%");

               $register = $reg->latest()->get();
            //    return DB::getQueryLog();
            
                $response = [];
                if(count($register) > 0)
                {
                    foreach ($register as $key => $value) {
                        $doctor_name = null;
                        $referred_by_doctor_name = null;
                        $detail = Appointment::where('reg_type_patient_id', $value->id)->with('doctor_detail', 'refer_by_detail')->latest()->first();
                        if($detail)
                        {
                            $doctor_name = $detail->doctor_detail ? $detail->doctor_detail->first_name.' '.$detail->doctor_detail->last_name : "-";
                            $referred_by_doctor_name = $detail->refer_by_detail ? $detail->refer_by_detail->first_name.' '.$detail->refer_by_detail->last_name : "-";
                            
                        }
                        $dataArr = [
                            'table_name' => 'registrations',
                            'patient_id' => $value->id,
                            'registration_type' => $value->registration_type,
                            'mrn_number' => $value->mrn_number,
                            'first_name' => $value->first_name,
                            'middle_name' => $value->middle_name,
                            'last_name' => $value->last_name,
                            'profile_image' => $value->profile_image,
                            'gender' => Gender::where('id', $value->gender)->value('description'),
                            'contact_no' => $value->contact_no,
                            'email_address' => $value->email_address,
                            'date_of_birth' => $value->date_of_birth,
                            'age' => $value->age,
                            'identity_proof' => $value->identity_proof,
                            'identity_proof_no' => $value->identity_proof_no,
                            'reference_details' => $value->reference_details,
                            'referral_doctor' => $value->referral_doctor,
                            'registration_date' => $value->registration_date,
                            'patientUnitId' => $value->patientUnitId,
                            'gender_name' => ( $value->gender == 2 ? 'Female' : 'Male' ),
                            'clinic_name' => Unit::where('id', $value->patientUnitId)->value('clinic_name'),
                            'doctor_name' => $doctor_name,
                            'referred_by_doctor_name' => $referred_by_doctor_name
                        ];
                        array_push($response, $dataArr);
                    }
                }
            }
            return sendDataHelper('Patient details.', $response, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Roles create  */
    public function rolesCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            /* Step zero */
            $data = Validator::make($request,[
                'code' => 'required',
                'description' => 'required',
                'status' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            // return RoleMaster::get();
            $roles =  new RoleMaster;
            $roles->code = @$request['code'];
            $roles->description = @$request['description'];
            $roles->status = @$request['status'] ? true : false;
            $roles->added_date_time = date('Y-m-d H:s:i');
            $roles->updated_date_time = date('Y-m-d H:s:i');
            $roles->added_by = auth()->user()->id;
            $roles->save();
           
            DB::commit();
            return sendDataHelper('Record updated successfully!', $roles->toArray(), $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Roles create  */
    public function rolesUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if(respValid($request)) { return respValid($request); }  /* response required validation */
            $request = decryptData($request['response']); /* Dectrypt  **/
            /* Step zero */
            $data = Validator::make($request,[
                'code' => 'required',
                'description' => 'required',
                'status' => 'required'
            ]);

            if($data->fails()){
                return sendError($data->errors()->first(), [], 422);
            }

            // return RoleMaster::get();
            $roles =  new RoleMaster;
            $roles->code = @$request['code'];
            $roles->description = @$request['description'];
            $roles->status = @$request['status'] ? true : false;
            $roles->added_date_time = date('Y-m-d H:s:i');
            $roles->updated_date_time = date('Y-m-d H:s:i');
            $roles->added_by = auth()->user()->id;
            $roles->save();
           
            DB::commit();
            return sendDataHelper('Record updated successfully!', $roles->toArray(), $code = 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }
}  


