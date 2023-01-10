<?php

use App\Http\Controllers\API\V1\AuthController;

use App\Http\Controllers\API\V1\Billing\BillingListController;
use App\Http\Controllers\API\V1\Masters\UniqueController;
use App\Http\Controllers\API\V1\Patients\AppointmentController;
use App\Http\Controllers\API\V1\Patients\RegisterController;
use App\Http\Controllers\API\V1\Patients\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CoupleController;
use App\Http\Controllers\API\V1\Inventory\IssueManageController;
use App\Http\Controllers\API\V1\Inventory\StoreItemController;

// Route::middleware('auth:sanctum', 'client.sanctum')->get('/user', function (Request $request) {
//     if (auth()->user()->tokenCan('server:update')) {
//         return  $request->user();
//     }
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum', 'user.sanctum'], 'prefix' => 'user', 'as'=>'user.', 'guard' => 'user'], function(){
    Route::post('/details', [AuthController::class, 'details']);

    Route::post('search-couplelist', [UniqueController::class, 'searchCoupleList']);
    Route::post('patient-detail-text', [UniqueController::class, 'patientDetailText']);
    Route::post('couple-link', [UniqueController::class, 'patientCoupleLink']);
    Route::post('search/patient/details', [SearchController::class, 'searchPatientDetails']);

    Route::group(['prefix' => 'patient'], function(){
        Route::get('categories/list', [UniqueController::class, 'patientCategoriesList']);
    });

    Route::group(['prefix' => 'patient'], function(){
        Route::post('{reg_code}/registrations', [RegisterController::class, 'patientsRegister']);
        Route::post('registrations/details', [UniqueController::class, 'patientsDetails']);
        Route::post('search/list', [UniqueController::class, 'searchPatients']);

        Route::get('registrations/details/{registration}', [RegisterController::class, 'patientsDetailsSelected']);
        Route::post('parents/detail', [CoupleController::class, 'coupleDetails']);
        Route::post('file/download', [UniqueController::class, 'patientFileDownload']);  // patient file download
        Route::post('baby/parents/search', [UniqueController::class, 'babyParentsSearch']);  // parents search list

        Route::get('appointment/list', [AppointmentController::class, 'appointmentList']); //patient appointment list
        Route::post('appointment/search/list', [AppointmentController::class, 'appointmentListSearch']); //patient appointment list

    });

    Route::group(['prefix' => 'doctor'], function(){
        Route::post('list', [UniqueController::class, 'doctorsList']);  // Doctors List
        Route::post('search', [UniqueController::class, 'searchDoctor']);  // Doctor search time wise
        Route::post('doctorSlotScheduleAdd', [AppointmentController::class, 'doctorSlotScheduleAdd']);
    });

    /** Billing list module*/
    Route::group(['prefix' => 'billing'],function(){
        Route::group(['prefix' =>'{prefix}'],function(){
            $billTables = 'ipd_billing';
            $billTables2 = 'ipd_medicine_billing';
            $billTables3 = 'ipd_service_billing';
           Route::post('list', [BillingListController::class, 'billFilterPageList'])->where('prefix',  $billTables);
           Route::post('medicine/list', [BillingListController::class, 'billMedicineFilterPageList'])->where('prefix',  $billTables2);
           Route::post('service/list', [BillingListController::class, 'billServiceFilterPageList'])->where('prefix',  $billTables2);
        });
        Route::group(['prefix' =>'{prefix}'],function(){
            $opdBillTables = 'opd_billing';
            $opdBillTables2 = 'opd_medicine_billing';
            $opdBillTables3 = 'opd_service_billing';
           Route::post('list', [BillingListController::class, 'billFilterPageList'])->where('prefix',  $opdBillTables);
           Route::post('medicine/list', [BillingListController::class, 'billMedicineFilterPageList'])->where('prefix',  $opdBillTables2);
           Route::post('service/list', [BillingListController::class, 'billServiceFilterPageList'])->where('prefix',  $opdBillTables2);
        });
        Route::group(['prefix' =>'{prefix}'],function(){
            $doctor_bill = 'doctor';
           Route::post('list', [BillingListController::class, 'doctorBillFilterPageList'])->where('prefix',  $doctor_bill);
        });
    });
});



Route::group(['middleware' => ['auth:sanctum', 'user.sanctum'], 'guard' => 'user'], function(){
    Route::group(['prefix' => 'appointment'], function(){
        Route::post('list/total', [AppointmentController::class, 'appListTotal']); //appointment list total
        Route::post('doctor/schedule/search', [SearchController::class, 'doctorScheduleSearch']);  // Doctors Selection Slot Schedule
        Route::post('booking/patient', [AppointmentController::class, 'appointmentBooking']); //patient appointment list
        Route::post('booking/patient/new', [AppointmentController::class, 'appointmentBookingNew']); //patient appointment list
        Route::post('view/list', [AppointmentController::class, 'appointmentPatientBookingList']); //patient appointment list
        
        Route::post('view/list/pagination', [AppointmentController::class, 'appPatientBookPaginationList']); //patient appointment list
        Route::post('view/listwait/pagination', [AppointmentController::class, 'appPatientWaitBookPagList']); //patient appointment list
        
        Route::post('view/pagination', [SearchController::class, 'appBookingListPagination']); //patient appointment list
        Route::post('search/patient/list', [AppointmentController::class, 'appointmentSearchList']);
        Route::post('patient/visit/wait', [AppointmentController::class, 'patientVisitWait']); //patient check in
        Route::post('patient/check/in', [AppointmentController::class, 'patientCheckIn']); //patient check in
        Route::post('patient/check/visit/list', [AppointmentController::class, 'patientVisitList']); //patient visit list

        Route::post('single/patient/app/list', [AppointmentController::class, 'singlePatientAppList']); //single patient appointment list
        Route::post('single/patient/app/list/new', [AppointmentController::class, 'singlePatientAppList_new']); //single patient appointment list New
    });
    Route::post('cancel/appointment/booking/patient', [AppointmentController::class, 'cancelAppBooking']); //patient appointment list
    Route::post('reschedule/appointment/booking/patient', [AppointmentController::class, 'rescheduleAppBooking']); //patient appointment list

    /* All issue list */
    Route::post('all/issue/management/pagination', [IssueManageController::class, 'issuePaginationList']);
    Route::post('issue/management/single/list', [IssueManageController::class, 'selectedIssueList']);
    Route::post('issue/management/store', [IssueManageController::class, 'issueListStore']);
    Route::post('issue/management/update', [IssueManageController::class, 'issueListUpdate']);
    Route::post('issue/management/destroy', [IssueManageController::class, 'issueListDelete']);
    Route::post('issue/management/filter/list', [IssueManageController::class, 'issueFilterList']);

    
    Route::post('all/store/item//pagination', [StoreItemController::class, 'issuePaginationList']);
    Route::post('store/items/single/list', [StoreItemController::class, 'selectedIssueList']);
    Route::post('store/items/insert', [StoreItemController::class, 'itemStoreListInsert']);
    Route::post('store/items/update', [StoreItemController::class, 'itemStoreListUpdate']);
    Route::post('store/items/destroy', [StoreItemController::class, 'storeItemListDelete']);
    Route::post('store/items/filter/list', [StoreItemController::class, 'storeItemFilterList']);   //Store items list filter (all store items types items)  

});