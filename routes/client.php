<?php

use App\Http\Controllers\API\V1\Administration\ANCConfigController;
use App\Http\Controllers\API\V1\Administration\InventoryConfigController;
use App\Http\Controllers\API\V1\Administration\BillingConfigController;
use App\Http\Controllers\API\V1\Administration\ClinicConfigController;
use App\Http\Controllers\API\V1\Administration\IPDConfigController;
use App\Http\Controllers\API\V1\Administration\IVFConfigController;
use App\Http\Controllers\API\V1\Administration\PatientConfigController;
use App\Http\Controllers\API\V1\Inventory\OpeningBalanceController;
use App\Http\Controllers\API\V1\Inventory\CurrentItemStock;
use App\Http\Controllers\API\V1\Administration\ApplicationConfigrationController;
use App\Http\Controllers\API\V1\Inventory\ItemEnquiryController;
use App\Http\Controllers\API\V1\Administration\PackageConfigController;
use App\Http\Controllers\API\V1\Administration\OTScheduleController;
use App\Http\Controllers\API\V1\Administration\AgenciesConfigController;
use App\Http\Controllers\API\V1\Administration\AlertConfigController;
use App\Http\Controllers\API\V1\Administration\AutoNumberFormatController;
use App\Http\Controllers\API\V1\Administration\MasterController;
use App\Http\Controllers\API\V1\Administration\OTConfigController;
use App\Http\Controllers\API\V1\Inventory\QuotationController;
use App\Http\Controllers\API\V1\Inventory\StoreIndentController;
use App\Http\Controllers\API\V1\Billing\BillingController;
use App\Http\Controllers\API\V1\Alert\TemplateController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ClientController;
use App\Http\Controllers\API\V1\Clinic\DoctorController;
use App\Http\Controllers\API\V1\Clinic\DoctorScheduleController;
use App\Http\Controllers\API\V1\Masters\SendSMSController;
use App\Http\Controllers\API\V1\Masters\UniqueController;
use App\Http\Controllers\API\V1\Patients\RegisterController;
use App\Http\Controllers\API\V1\Plans\SubscribeController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum', 'client.sanctum')->get('/user', function (Request $request) {
//     if (auth()->user()->tokenCan('server:update')) {
//         return  $request->user();    
//     }
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum', 'client.sanctum'], 'prefix' => 'client', 'as'=>'client.', 'guard' => 'client'], function(){
    Route::get('details', [ClientController::class, 'details']);
    Route::get('login/history', [ClientController::class, 'loginHistory']); 
    Route::post('master-edit', [ClientController::class, 'masterEdit']); 
    Route::get('getGenderCodeList', [PatientConfigController::class, 'getGenderCodeList']);
    Route::get('get-specialization-list', [AgenciesConfigController::class, 'getSpecializationList']);
    Route::get('get-clinic-list', [AgenciesConfigController::class, 'getClinicList']);

    Route::group(['prefix' => 'patient'], function(){
        Route::get('registrations/details', [RegisterController::class, 'patientsDetails']);
        Route::get('categories/list', [ClientController::class, 'patientCategoriesList']);
        Route::get('packege/list', [PatientConfigController::class, 'getPackegeList']);
    });

    Route::group(['prefix' => 'plans'], function(){
        Route::get('list', [SubscribeController::class, 'plansList']);
    });

    Route::group(['prefix' => 'plan'], function(){
        Route::post('subscribe', [SubscribeController::class, 'subscribe']);
    });

    /* user create */
    Route::group(['prefix' => 'users'], function(){
        Route::post('register', [AuthController::class, 'userRegister']);
        Route::post('details', [ClientController::class, 'userDetails']);
    });

    Route::group(['prefix' => 'master'], function(){
        Route::post('roles/create', [UniqueController::class, 'rolesCreate']);
    });

    //----------- Inventory ---------------
    Route::group(['prefix' => 'inventory'], function(){
        /* Item enquiry */
        Route::group(['prefix' => 'item-inquiry'], function(){
            Route::post('add', [ItemEnquiryController::class, 'addItemEnquiry']);
            Route::post('list', [ItemEnquiryController::class, 'itemList']);
        });
        Route::group(['prefix' => 'quotation'], function(){
            Route::post('list', [QuotationController::class, 'quotationList']);
        });
        Route::group(['prefix' => 'current_item_stock'], function(){
            Route::post('list', [CurrentItemStock::class, 'list']);
        });
        Route::group(['prefix' => 'opening_balance'], function(){
            Route::post('list', [OpeningBalanceController::class, 'list']);
            Route::post('search_item', [OpeningBalanceController::class, 'searchItem']);
            Route::post('add', [OpeningBalanceController::class, 'add']);
        });
        Route::group(['prefix' => 'store_indent'], function(){
            Route::post('list', [StoreIndentController::class, 'list']);
            Route::post('add', [StoreIndentController::class, 'add']);
            Route::post('search_item', [StoreIndentController::class, 'searchItem']);
            Route::post('list', [StoreIndentController::class, 'list']);
        });
    });
    Route::post('template/fields/show', [TemplateController::class, 'templateFiledsStore']);

    // Administration
    Route::group(['prefix' => 'administration'],function(){
        Route::group(['prefix' => 'inventory_config'],function(){
            Route::group(['prefix' => 'item_categories'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'item_groups'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'storage_types'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'molecules'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'dispensings'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'pregnancy_classes'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'item_companies'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'therapeutics'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'unit_of_measurements'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'terms_and_conditions'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'supplier_categories'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'supplier'],function(){
                Route::post('search-list', [InventoryConfigController::class, 'inventorySupplierSearchListConfig']);
                Route::post('add', [InventoryConfigController::class, 'inventorySupplierAddConfig']);
            });
            Route::group(['prefix' => 'store'],function(){
                Route::post('search-list', [InventoryConfigController::class, 'inventoryStoreSearchListConfig']);
                Route::post('add_update', [InventoryConfigController::class, 'inventoryStoreAddConfig']);
            });
            Route::group(['prefix' => 'tax_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'item_movement_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'currencies'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'rack_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'bin_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'shelf_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'item'],function(){
                Route::post('search_list', [InventoryConfigController::class, 'inventorySearchListItem']);
                Route::post('search_suppliers', [InventoryConfigController::class, 'inventorySearchSuppliersConfig']);
                Route::post('add_update', [InventoryConfigController::class, 'inventoryAddUpdateItem']);
            });
            Route::group(['prefix' => 'strength_unit_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'work_order_items'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'cost_center_codes'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'hsn_code_masters'],function(){
                Route::post('add', [InventoryConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [InventoryConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            
        });
        Route::group(['prefix' => 'billing_config'],function(){
            Route::group(['prefix' => 'advance_against'],function(){
                Route::post('list',[BillingConfigController::class,'advanceAgainstList']);
                Route::post('add',[BillingConfigController::class,'advanceAgainstAdd']);
            });
            Route::group(['prefix' => 'tariff_service'],function(){
                Route::post('list',[BillingConfigController::class,'tariffServiceList']);
                Route::post('add',[BillingConfigController::class,'tariffServiceAdd']);
            });
            Route::group(['prefix' => 'tariff_master'],function(){             
                Route::post('list',[BillingConfigController::class,'tariffMasterList']);
                Route::post('add',[BillingConfigController::class,'tariffMasterAdd']);
                //add services in tariff
                Route::post('add/servicelist',[BillingConfigController::class,'tariffMasterListAdd']);
                //find tariff add service
                Route::post('find/service/list',[BillingConfigController::class,'findTariffMasterList']);  
            });
            Route::group(['prefix' => 'service_master'],function(){
                Route::post('list',[BillingConfigController::class,'serviceMasterList']);
                Route::post('add',[BillingConfigController::class,'serviceMasterAdd']);
            });
            Route::group(['prefix' => 'company_type'],function(){
                Route::post('list',[BillingConfigController::class,'companyTypeList']);
                Route::post('add',[BillingConfigController::class,'companyTypeAdd']);
            });
            Route::group(['prefix' => 'company_detail'],function(){
                Route::post('list',[BillingConfigController::class,'companyDetailList']);
                Route::post('tariff_search',[BillingConfigController::class,'companyDetailTariffSearch']);
                Route::post('add',[BillingConfigController::class,'companyDetailAdd']);
            });
            Route::group(['prefix' => 'associated_company'],function(){
                Route::post('list',[BillingConfigController::class,'associatedCompanyList']);
                Route::post('add',[BillingConfigController::class,'associatedCompanyAdd']);
            });
            Route::group(['prefix' => 'expense_master'],function(){
                Route::post('list',[BillingConfigController::class,'expenseMasterList']);
                Route::post('add',[BillingConfigController::class,'expenseMasterAdd']);
            });
            Route::group(['prefix' => 'service_rate/doc_cat'],function(){
                Route::post('list',[BillingConfigController::class,'serRateDocCatList']);
                Route::post('add',[BillingConfigController::class,'serRateDocCatAdd']);
            });
            Route::group(['prefix' => 'doctor_share'],function(){
                Route::post('list',[BillingConfigController::class,'doctorShareList']);
                Route::post('add',[BillingConfigController::class,'doctorShareAdd']);
            });
            Route::group(['prefix' => 'bulk/rate_change'],function(){
                Route::post('list',[BillingConfigController::class,'bulkRateChangeList']);
                Route::post('add',[BillingConfigController::class,'bulkRateChangeAdd']);
            });
            Route::group(['prefix' => 'concession/reason_master'],function(){
                Route::post('list',[BillingConfigController::class,'conReasonMasterList']);
                Route::post('add',[BillingConfigController::class,'conReasonMasterAdd']);
            });
            Route::group(['prefix' => 'reason/refund_master'],function(){
                Route::post('list',[BillingConfigController::class,'reasonRefundMasterList']);
                Route::post('add',[BillingConfigController::class,'reasonRefundMasterAdd']);
            });
            Route::group(['prefix' => 'sac_code'],function(){
                Route::post('list',[BillingConfigController::class,'sacCodeList']);
                Route::post('add',[BillingConfigController::class,'sacCodeAdd']);
            });
            Route::group(['prefix' => 'specialization'],function(){
                Route::post('list',[BillingConfigController::class,'specializationList']);
                Route::post('add',[BillingConfigController::class,'specializationAdd']);
            });
            Route::group(['prefix' => 'sub_specialization'],function(){
                Route::post('list',[BillingConfigController::class,'subSpecializationList']);
                Route::post('add',[BillingConfigController::class,'subSpecializationAdd']);
            });
            Route::group(['prefix' => 'mode_payment'],function(){
                Route::post('list',[BillingConfigController::class,'modePaymentList']);
                Route::post('add',[BillingConfigController::class,'modePaymentAdd']);
            });
            Route::group(['prefix' => 'package'],function(){
                Route::get('adjust_against',[PackageConfigController::class,'adjustAgainst']);
                Route::post('list_package',[PackageConfigController::class,'listPackageConfig']);
                Route::post('add_package',[PackageConfigController::class,'addPackageConfig']);
                Route::post('list_service',[PackageConfigController::class,'listServiceConfig']);
                Route::post('add_service',[PackageConfigController::class,'addServiceConfig']);
                Route::post('list_item',[PackageConfigController::class,'listItemConfig']);
                Route::post('add_item',[PackageConfigController::class,'addItemConfig']);
                Route::post('list_tariff',[PackageConfigController::class,'listTariffConfig']);
                Route::post('add_tariff',[PackageConfigController::class,'addTariffConfig']);
            });
        });
        Route::group(['prefix' => 'ipd_config'],function(){
            Route::group(['prefix' => 'building_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListBuildingMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateBuildingMaster']);
            });
            Route::group(['prefix' => 'floor_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListFloorMaster']);
                Route::post('find_room',[IPDConfigController::class,'findRoomBedMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateFloorMaster']);
            });
            Route::group(['prefix' => 'ward_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListWardMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateWardMaster']);
            });
            Route::group(['prefix' => 'room_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListRoomMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateRoomMaster']);
            });
            Route::group(['prefix' => 'room_amenities_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListAmenitiesMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateAmenitiesMaster']);
            });
            Route::group(['prefix' => 'class_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListClassMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateClassMaster']);
            });
            Route::group(['prefix' => 'bed_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListBedMaster']);
                Route::post('find_ward',[IPDConfigController::class,'findWardBedMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateBedMaster']);
            });
            Route::group(['prefix' => 'bed_amenities_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListBedAmenitiesMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateBedAmenitiesMaster']);
            });
            Route::group(['prefix' => 'discharge_type'],function(){
                Route::post('list',[IPDConfigController::class,'searchListDischargeType']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateDischargeType']);
            });
            Route::group(['prefix' => 'discharge_destination_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListDischargeDestiMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateDischargeDestiMaster']);
            });
            Route::group(['prefix' => 'discharge_template_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListDischargeTemplateMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateDischargeTemplateMaster']);
            });
            Route::group(['prefix' => 'admission_type_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListAdmissionTypeMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateAdmissionTypeMaster']);
                Route::post('search',[IPDConfigController::class,'searchAdmissionTypeMaster']);
                Route::post('link_service',[IPDConfigController::class,'linkServiceAdmissionTypeMaster']);
            });
            Route::group(['prefix' => 'bed_release_check'],function(){
                Route::post('list',[IPDConfigController::class,'searchListbedReleaseCheckList']);
                Route::post('add_update',[IPDConfigController::class,'addUpdatebedReleaseCheckList']);
            });
            Route::group(['prefix' => 'patient_vital'],function(){
                Route::post('list',[IPDConfigController::class,'searchListPatientVital']);
                Route::post('add_update',[IPDConfigController::class,'addUpdatePatientVital']);
            });
            Route::group(['prefix' => 'identity_master'],function(){
                Route::post('list',[IPDConfigController::class,'searchListIdentityMaster']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateIdentityMaster']);
            });
            Route::group(['prefix' => 'reference_entity'],function(){
                Route::post('list',[IPDConfigController::class,'searchListReferenceEntity']);
                Route::post('add_update',[IPDConfigController::class,'addUpdateReferenceEntity']);
            });
        });
        Route::group(['prefix' => 'anc_config'],function(){
            Route::group(['prefix' => 'consult_stages'],function(){
                Route::post('add', [ANCConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [ANCConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [InventoryConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [ANCConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'fhs'],function(){
                Route::post('add', [ANCConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [ANCConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [ANCConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [ANCConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'investigations'],function(){
                Route::post('add', [ANCConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [ANCConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [ANCConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [ANCConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
            Route::group(['prefix' => 'presentation_positions'],function(){
                Route::post('add', [ANCConfigController::class, 'inventoryCommonAddConfig']);
                Route::post('search-list', [ANCConfigController::class, 'inventoryCommonSearchListConfig']);
                Route::patch('update-status/{id}', [ANCConfigController::class, 'inventoryCommonUpdateStatusConfig']);
                Route::patch('update/{id}', [ANCConfigController::class, 'inventoryCommonUpdateItemConfig']);
            });
        });
        Route::group(['prefix' => 'ivf_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){ 
                $ivfConfigTables = 'needles|type_of_needles|sperm_preparations|tanks|canes|canisters|straw_or_vials|goblet_colors|et_pattern_masters|built_masters|eye_colors|skin_colors|hair_colors|catheter_types|difficulty_types|laboratory_masters|surrogate_agency_masters';
                Route::post('add', [IVFConfigController::class, 'ivfCommonAddConfig'])->where('prefix', $ivfConfigTables);
                Route::post('search-list', [IVFConfigController::class, 'ivfCommonSearchListConfig'])->where('prefix',  $ivfConfigTables);
                Route::patch('update-status/{id}', [IVFConfigController::class, 'ivfCommonUpdateStatusConfig'])->where('prefix',  $ivfConfigTables);
                Route::patch('update/{id}', [IVFConfigController::class, 'ivfCommonUpdateItemConfig'])->where('prefix',  $ivfConfigTables);
            });
        });
        Route::group(['prefix' => 'application_config'],function(){
            Route::post('list',[ApplicationConfigrationController::class,'listApplicationConfig']);
            Route::post('add_update',[ApplicationConfigrationController::class,'addUpdateApplicationConfig']);
        });
        Route::group(['prefix' => 'clinic_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){
                $clinicConfigTables = 'departments|designation_masters|primary_symptoms|bank_masters|bank_branch_masters|countries|states|cities|region_masters|adhesions|emr_field_values|cash_counters|emr_chief_complaints|employees|doctor_categories|doctor_types|classifications';

                Route::post('add', [ClinicConfigController::class, 'clinicCommonAddConfig'])->where('prefix', $clinicConfigTables);
                Route::post('search-list', [ClinicConfigController::class, 'clinicCommonSearchListConfig'])->where('prefix',  $clinicConfigTables);
                Route::patch('update-status/{id}', [ClinicConfigController::class, 'clinicCommonUpdateStatusConfig'])->where('prefix',  $clinicConfigTables);
                Route::patch('update/{id}', [ClinicConfigController::class, 'clinicCommonUpdateItemConfig'])->where('prefix',  $clinicConfigTables);
            });

            Route::resource('doctors', DoctorController::class); /* Doctor categories*/
            Route::post('doctors/update/status/{id}', [DoctorController::class, 'doctorUpdateStatus']);
            Route::get('doctor/list', [DoctorController::class, 'index']);
            Route::post('doctors/search-list', [DoctorController::class, 'index']);

            Route::get('list/doctor_schedule', [DoctorScheduleController::class, 'index']); /* Doctor Schedule list*/
            Route::post('doctor_schedule/store', [DoctorScheduleController::class, 'store']); /* Doctor Schedule list store*/
            Route::put('doctor_schedule/update/{id}', [DoctorScheduleController::class, 'update']); /* Doctor schedule list update*/
            Route::patch('doctor_schedule/update/status/{id}', [DoctorScheduleController::class, 'scheduleUpdateStatus']); /* Doctor schedule status change*/
            Route::get('doctor_schedule/show/pagination/{id}', [DoctorScheduleController::class, 'paginationIndex']); /* Doctor schedule list pagination*/
            
        });
        Route::group(['prefix' => 'patient_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){ 
                $patientConfigTables = 'patient_sources|patient_relation_masters|referral_name_masters|special_registrations|preffix_masters|nationality_masters|preferred_language_masters|treatment_required_masters|education_details_masters|camp_masters|blood_groups|visit_types|patient_consents';
                Route::post('add', [PatientConfigController::class, 'patientCommonAddConfig'])->where('prefix', $patientConfigTables);
                Route::match(array('GET', 'POST'),'search-list', [PatientConfigController::class, 'patientCommonSearchListConfig'])->where('prefix',  $patientConfigTables);
                Route::patch('update-status/{id}', [PatientConfigController::class, 'patientCommonUpdateStatusConfig'])->where('prefix',  $patientConfigTables);
                Route::patch('update/{id}', [PatientConfigController::class, 'patientCommonUpdateItemConfig'])->where('prefix',  $patientConfigTables);
            });
            Route::group(['prefix' =>'registration_charges'],function(){ 
                Route::post('add', [PatientConfigController::class, 'addPatientRegistrationCharges']);
                Route::post('search-list', [PatientConfigController::class, 'searchPatientRegistrationCharges']);
                Route::patch('update-status/{id}', [PatientConfigController::class, 'updatePatientRegistrationChargeStatus']);
                Route::patch('update/{id}', [PatientConfigController::class, 'updatePatientRegistrationCharges']);
            });
            Route::group(['prefix' =>'agent_master'],function(){ 
                Route::post('add', [PatientConfigController::class, 'addAgent']);
                Route::post('search-list', [PatientConfigController::class, 'searchAgent']);
                Route::patch('update-status/{id}', [PatientConfigController::class, 'updateAgnetStatus']);
                Route::patch('update/{id}', [PatientConfigController::class, 'updateAgent']);
            });
            Route::get('get-consultation-visit-type', [PatientConfigController::class, 'getConsultationVisitType']);
        });
        Route::group(['prefix' => 'ot_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){
                $otConfigTables = 'ot_masters|procedure_type_masters|operation_result_masters|ot_table_masters|pre_operative_instruction_masters|post_operative_instruction_masters|intra_operative_instruction_masters|surgery_notes_masters|anesthesia_masters|anesthesia_note_masters|anesthesia_type_masters|operation_status_masters|procedure_masters|procedure_category_masters|procedure_sub_category_masters|procedure_check_list_masters|doctor_note_masters';
                Route::post('add', [OTConfigController::class, 'oTCommonAddConfig'])->where('prefix', $otConfigTables);
                Route::post('search-list', [OTConfigController::class, 'oTCommonSearchListConfig'])->where('prefix',  $otConfigTables);
                Route::patch('update-status/{id}', [OTConfigController::class, 'oTCommonUpdateStatusConfig'])->where('prefix',  $otConfigTables);
                Route::patch('update/{id}', [OTConfigController::class, 'oTCommonUpdateItemConfig'])->where('prefix',  $otConfigTables);
            });

            Route::group(['prefix' =>'ot_scheduling_masters'],function(){
                Route::post('add', [OTScheduleController::class, 'otScheduleAdd']);
                Route::post('search-list', [OTScheduleController::class, 'otScheduleSearchList']);
                Route::post('pagination/filter/list', [OTScheduleController::class, 'otScheduleSearchPaginationList']);
                Route::patch('update-status/{id}', [OTScheduleController::class, 'otScheduleUpdateStatus']);
                Route::patch('update/{id}', [OTScheduleController::class, 'otScheduleUpdate']);
            });
        });
        Route::group(['prefix' => 'anf_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){
                $anfConfigTables = 'mrn_formats|opd_formats|ipd_formats|receipt_formats|inventory_formats';
                Route::post('add', [AutoNumberFormatController::class, 'anfCommonAddConfig'])->where('prefix', $anfConfigTables);
                Route::post('search-list', [AutoNumberFormatController::class, 'anfCommonSearchListConfig'])->where('prefix',  $anfConfigTables);
                Route::patch('update-status/{id}', [AutoNumberFormatController::class, 'anfCommonUpdateStatusConfig'])->where('prefix',  $anfConfigTables);
                Route::patch('update/{id}', [AutoNumberFormatController::class, 'anfCommonUpdateItemConfig'])->where('prefix',  $anfConfigTables);
            });
        });
        // otScheduleSearchList
        Route::group(['prefix' => 'agency_config'],function(){
            // Route::group(['prefix' =>'agency_master'],function(){ 
                Route::post('add', [AgenciesConfigController::class, 'addAgency']);
                Route::post('search-list', [AgenciesConfigController::class, 'searchAgency']);
                Route::patch('update-status/{id}', [AgenciesConfigController::class, 'updateAgencyStatus']);
                Route::patch('update/{id}', [AgenciesConfigController::class, 'updateAgency']);
                Route::get('get-clinic-agency/{id}', [AgenciesConfigController::class, 'getAgencyLinkWithClinic']);
                Route::post('link-with-clinic', [AgenciesConfigController::class, 'addAgencyLinkWithClinic']);
                Route::post('link-with-service', [AgenciesConfigController::class, 'addAgencyLinkWithService']);
                Route::get('get-service-agency', [AgenciesConfigController::class, 'getAgencyLinkWithService']);
                Route::post('get-linked-service', [AgenciesConfigController::class, 'getLinkedService']);
            // });
            
            // Route::group(['prefix' =>'agency_link_service'],function(){ 
            //     Route::post('add', [AgenciesConfigController::class, 'addAgencyLinkWithService']);
            //     Route::get('get-clinic-agency/{id}', [AgenciesConfigController::class, 'getAgencyLinkWithService']);
            //     // Route::patch('update-status/{id}', [AgenciesConfigController::class, 'updateAgencyStatus']);
            //     // Route::patch('update/{id}', [AgenciesConfigController::class, 'updateAgency']);
            // });
        });

        Route::group(['prefix' => 'alert_config'],function(){
            Route::group(['prefix' =>'{prefix}'],function(){
                $alertConfigTables = 'events|alert_event_types|email_templates|sms_templates';
                Route::post('add', [AlertConfigController::class, 'alertCommonAddConfig'])->where('prefix', $alertConfigTables);
                Route::post('search-list', [AlertConfigController::class, 'alertCommonSearchListConfig'])->where('prefix',  $alertConfigTables);
                Route::patch('update-status/{id}', [AlertConfigController::class, 'alertCommonUpdateStatusConfig'])->where('prefix',  $alertConfigTables);
                Route::patch('update/{id}', [AlertConfigController::class, 'alertCommonUpdateItemConfig'])->where('prefix',  $alertConfigTables);
            });
        });
    });
    /** Billing */
    Route::group(['prefix' => 'billing'],function(){
        Route::group(['prefix' => 'patient_advance'],function(){
            Route::post('list',[BillingController::class,'patientAdvanceList']);
        });
        Route::group(['prefix' => 'expenses'],function(){
            Route::post('list',[BillingController::class,'expensesList']);
            Route::post('add',[BillingController::class,'expensesAdd']);
        });
    });


    Route::group(['prefix' =>'{prefix}'],function(){
        $anfConfigTables = 'mrn_formats|opd_formats|ipd_formats|receipt_formats|inventory_formats';
        Route::post('add', [AutoNumberFormatController::class, 'anfCommonAddConfig'])->where('prefix', $anfConfigTables);
        Route::post('search-list', [AutoNumberFormatController::class, 'anfCommonSearchListConfig'])->where('prefix',  $anfConfigTables);
        Route::patch('update-status/{id}', [AutoNumberFormatController::class, 'anfCommonUpdateStatusConfig'])->where('prefix',  $anfConfigTables);
        Route::patch('update/{id}', [AutoNumberFormatController::class, 'anfCommonUpdateItemConfig'])->where('prefix',  $anfConfigTables);
    });
});
    

Route::get('testFunction',[BillingController::class,'testFunction']);
Route::post('bill-list',[BillingController::class,'billMasterList']);

Route::get('payment-type-list', [ClientController::class, 'paymentTypeList']); 
Route::get('specializations-list', [ClientController::class, 'specializationsList']); 
Route::get('payment-type-list', [ClientController::class, 'paymentTypeList']);

Route::group(['middleware' => ['auth:sanctum', 'client.sanctum'], 'prefix' => 'master', 'as'=>'master.', 'guard' => 'client'], function(){

    Route::get('all/clinic/details', [UniqueController::class, 'unitClinicDetails']); // Master select details
    /*
    - ot_masters
    - procedure_type_masters
    - operation_result_masters
    - ot_table_masters
    - pre_operative_instruction_masters
    - post_operative_instruction_masters
    - intra_operative_instruction_masters
    - surgery_notes_masters
    - anesthesia_masters
    - anesthesia_note_masters
    - anesthesia_type_masters
    - operation_status_masters
    - procedure_masters
    - procedure_category_masters
    - procedure_sub_category_masters
    - procedure_check_list_masters
    - doctor_note_masters
    */
    Route::group(['prefix' => 'all/table'],function(){
        Route::group(['prefix' =>'{prefix}'],function(){

            $clinic_config = 'doctors|departments|designation_masters|primary_symptoms|bank_masters|bank_branch_masters|countries|states|cities|region_masters|adhesions|emr_field_values|cash_counters|emr_chief_complaints|employees|doctor_categories|doctor_types|classifications|events';
            $billing_config = 'specializations|shelf_masters|tariff_masters|sub_specializations|identity_masters|class_masters|visit_types|relation_masters|company_masters|mode_of_payments|service_masters|source_of_references|doctor_shares|expense_masters|ward_types|room_amenity_masters|room_masters|bed_amenity_masters';
            $ipd_config = 'company_type_masters|ledgers|patient_sources|cost_center_codes|block_masters|floor_masters|therapeutics|molecules|supplier_categories';
            $ot_config = 'ot_masters|procedure_type_masters|operation_result_masters|ot_table_masters|pre_operative_instruction_masters|post_operative_instruction_masters|intra_operative_instruction_masters|surgery_notes_masters|anesthesia_masters|anesthesia_note_masters|anesthesia_type_masters|operation_status_masters|procedure_masters|procedure_category_masters|procedure_sub_category_masters|procedure_check_list_masters|doctor_note_masters';
            $tb1 = 'genders|blood_groups|marital_statuses|day_masters|occupations|schedules|month_masters|time_slots|patient_categories|id_proofs';
            $tb2 = 'units|unit_of_measurements|role_masters|sms_templates|email_templates|events|storage_types|stores|item_groups|item_categories|pregnancy_classes|suppliers';
            $tb3 = 'mrn_formats|opd_formats|ipd_formats|receipt_formats|inventory_formats';
            $tb4 = 'trans_types';
            $allTablesSelect = $clinic_config.'|'.$billing_config.'|'.$ipd_config.'|'.$ot_config.'|'.$tb1.'|'.$tb2.'|'.$tb3.'|'.$tb4;

            Route::get('list', [MasterController::class, 'allTablesList'])->where('prefix',  $allTablesSelect);
        });
    });

    Route::group(['prefix' => 'sub/table'],function(){
        Route::group(['prefix' =>'{prefix}'],function(){
            $clinic_config = 'bank_branch_masters|states|cities|region_masters|emr_field_values|emr_chief_complaints';
            $billing_config = 'sub_specializations';
            $ot_config = 'procedure_type_masters|operation_result_masters|ot_table_masters|pre_operative_instruction_masters|post_operative_instruction_masters|intra_operative_instruction_masters|surgery_notes_masters|anesthesia_masters|anesthesia_note_masters|anesthesia_type_masters|operation_status_masters|procedure_masters|procedure_category_masters|procedure_sub_category_masters|procedure_check_list_masters|doctor_note_masters';
            $allTablesSelect = $clinic_config.'|'.$billing_config.'|'.$ot_config.'|units';
            Route::get('list/{id}', [MasterController::class, 'allSubList'])->where('prefix',  $allTablesSelect);
        });
    });
    
    Route::get('sub/table/units/departments/list', [MasterController::class, 'allUnitDeptList']);

    Route::post('specialization/insert', [UniqueController::class, 'specializationInsert']); // Master select details

    Route::resource('alert-types', TemplateController::class);/* Alert events list*/
    Route::post('alert-types-update/{id}', [TemplateController::class, 'update']);/* Alert events list*/

    /* fields */
    Route::post('notification/fields/all/pagination', [TemplateController::class, 'notifyFieldPaginationList']);
    Route::post('notification/fields/single/list', [TemplateController::class, 'notifyFieldSingleList']);
    Route::post('notification/fields/store', [TemplateController::class, 'notifyFieldStore']);
    Route::post('notification/fields/update', [TemplateController::class, 'notifyFieldUpdate']);
    Route::post('notification/fields/destroy', [TemplateController::class, 'notifyFieldDelete']);

    /* all emails list type & search */
    Route::post('emails/all/template/pagination', [TemplateController::class, 'emailsPaginationList']);
    Route::post('emails/template/single/list', [TemplateController::class, 'emailTempView']);
    Route::post('email/template/store', [TemplateController::class, 'emailTempStore']);
    Route::post('email/template/update', [TemplateController::class, 'emailTempUpdate']);
    Route::post('email/template/destroy', [TemplateController::class, 'emailTempDelete']);

    /* all sms tempalte list type & search */
    Route::any('sms/all/template/pagination', [TemplateController::class, 'smsPaginationList']);
    Route::post('sms/template/single/list', [TemplateController::class, 'smsTempList']);
    Route::post('sms/template/store', [TemplateController::class, 'smsTempStore']);
    Route::post('sms/template/update', [TemplateController::class, 'smsTempUpdate']);
    Route::post('sms/template/destroy', [TemplateController::class, 'smsTempDelete']);

    Route::get('send-sms', [SendSMSController::class, 'index']);

    Route::post('send-mail', function () {

        $details = [
            'title' => 'Sample Title From Mail',
            'body' => 'This is sample content we have added for this test mail'
        ];
    
        Mail::to('123456789test@mailinator.com')->send(new \App\Mail\MyTestMail($details));
    
        dd("Email is Sent, please check your inbox.");
    });
    
});