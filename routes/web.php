<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\PathologyPatientController;
use App\Http\Controllers\PathologyReportSetupController;
use App\Http\Controllers\PathologyResultHeadingController;
use App\Http\Controllers\PathologyResultNameController;
use App\Http\Controllers\PathologyTestCategoryController;
use App\Http\Controllers\PathologyTestController;
use App\Http\Controllers\PathologyTestSetupController;
use App\Http\Controllers\PathologyTubeController;
use App\Http\Controllers\PathologyUnitController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SiteSettingController;
use App\Service\PathologyPatientReportSetupService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware'=>['auth']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'setting/role', 'as' => 'role.'], function () {
        Route::get('/',[RoleController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::get('/permission/{id}', [RoleController::class, 'permission'])->name('permission');
        Route::post('/permission/store/{id}', [RoleController::class, 'permission_store'])->name('permission.store');
    });
    Route::group(['prefix' => 'setting/user', 'as' => 'user.'], function () {
        Route::get('/',[UsersController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('/store', [UsersController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [UsersController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('update');
        Route::get('/assign_role/{id}',[UsersController::class, 'assign_role'])->name('role_assign');
        Route::post('/assign_role', [UsersController::class, 'assign_role_store'])->name('role_assign_store');
    });
    Route::group(['prefix' => 'setting/site_setting', 'as' => 'site_setting.'], function () {
        Route::get('/',[SiteSettingController::class, 'index'])->name('index');
        Route::post('/update/{id}', [SiteSettingController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'patient', 'as' => 'pathology.patient.'], function () {
        Route::get('/', [PathologyPatientController::class, 'index'])->name('index');
        Route::get('/create', [PathologyPatientController::class, 'create'])->name('create');
        Route::post('/store', [PathologyPatientController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyPatientController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyPatientController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyPatientController::class, 'delete'])->name('delete');

        Route::get('/test_find/{id}', [PathologyPatientController::class, 'testFind']);
        Route::get('/tube_find/{id}', [PathologyPatientController::class, 'tubeFind']);
        Route::get('/invoice/{id}', [PathologyPatientController::class, 'invoice'])->name('invoice');
    });
    Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/store', [DoctorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DoctorController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DoctorController::class, 'delete'])->name('delete');

        Route::get('/due/{id}', [DoctorController::class, 'referralDue']);
        Route::post('/payment_details', [DoctorController::class, 'paymentDetailStore'])->name('payment.store');
        Route::get('/payment_details/{id}', [DoctorController::class, 'paymentDetail']);
        Route::get('/payment/edit/{id}', [DoctorController::class, 'paymentEdit']);
        Route::post('/payment_details/update', [DoctorController::class, 'ReferralPaymentUpdate'])->name('payment.update');
        Route::get('/payment/delete/{id}', [DoctorController::class, 'paymentDelete'])->name('payment.delete');
    });
    Route::group(['prefix' => 'referral', 'as' => 'referral.'], function () {
        Route::get('/', [ReferralController::class, 'index'])->name('index');
        Route::get('/create', [ReferralController::class, 'create'])->name('create');
        Route::post('/store', [ReferralController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ReferralController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ReferralController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ReferralController::class, 'delete'])->name('delete');

        Route::get('/due/{id}', [ReferralController::class, 'referralDue']);
        Route::post('/payment_details', [ReferralController::class, 'paymentDetailStore'])->name('payment.store');
        Route::get('/payment_details/{id}', [ReferralController::class, 'paymentDetail']);
        Route::get('/payment/edit/{id}', [ReferralController::class, 'paymentEdit']);
        Route::post('/payment_details/update', [ReferralController::class, 'ReferralPaymentUpdate'])->name('payment.update');
        Route::get('/payment/delete/{id}', [ReferralController::class, 'paymentDelete'])->name('payment.delete');

    });
    Route::group(['prefix' => 'pathology/test', 'as' => 'test.'], function () {
        Route::get('/', [PathologyTestController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTestController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTestController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyTestController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PathologyTestController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTestController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/tube', 'as' => 'tube.'], function () {
        Route::get('/', [PathologyTubeController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTubeController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTubeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyTubeController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyTubeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTubeController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/unit', 'as' => 'pathology.unit.'], function () {
        Route::get('/', [PathologyUnitController::class, 'index'])->name('index');
        Route::get('/create', [PathologyUnitController::class, 'create'])->name('create');
        Route::post('/store', [PathologyUnitController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyUnitController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyUnitController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyUnitController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/result-name', 'as' => 'pathology.result_name.'], function () {
        Route::get('/', [PathologyResultNameController::class, 'index'])->name('index');
        Route::get('/create', [PathologyResultNameController::class, 'create'])->name('create');
        Route::post('/store', [PathologyResultNameController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyResultNameController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyResultNameController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyResultNameController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/result-heading', 'as' => 'pathology.result_heading.'], function () {
        Route::get('/', [PathologyResultHeadingController::class, 'index'])->name('index');
        Route::get('/create', [PathologyResultHeadingController::class, 'create'])->name('create');
        Route::post('/store', [PathologyResultHeadingController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyResultHeadingController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyResultHeadingController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyResultHeadingController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/test-setup', 'as' => 'pathology.test_setup.'], function () {
        Route::get('/', [PathologyTestSetupController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTestSetupController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTestSetupController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyTestSetupController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PathologyTestSetupController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTestSetupController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/test_category', 'as' => 'test_category.'], function () {
        Route::get('/', [PathologyTestCategoryController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTestCategoryController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTestCategoryController::class, 'store'])->name('store');
        Route::post('/categorystore', [PathologyTestCategoryController::class, 'categorystore'])->name('categorystore');
        Route::get('/edit/{id}', [PathologyTestCategoryController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyTestCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTestCategoryController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/report-set', 'as' => 'report_set.'], function () {
        Route::get('/', [PathologyReportSetupController::class, 'index'])->name('index');
        Route::get('/create', [PathologyReportSetupController::class, 'create'])->name('create');
        Route::post('/store', [PathologyReportSetupController::class, 'store'])->name('store');
        Route::post('/categorystore', [PathologyReportSetupController::class, 'categorystore'])->name('categorystore');
        Route::get('/edit/{id}', [PathologyReportSetupController::class, 'edit'])->name('edit');
        Route::post('/update', [PathologyReportSetupController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyReportSetupController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'finance', 'as' => 'due_collection.'], function () {
        Route::get('/due_collection', [FinanceController::class, 'dueCollection'])->name('index');
        Route::post('/due_collection/store/{id} ', [FinanceController::class, 'dueCollectionStore'])->name('store');
    });
    
});

Auth::routes();

