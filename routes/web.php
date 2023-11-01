<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PathologyTestCategoryController;
use App\Http\Controllers\PathologyTestController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SiteSettingController;
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
    Route::group(['prefix' => 'patient', 'as' => 'patient.'], function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/create', [PatientController::class, 'create'])->name('create');
        Route::post('/store', [PatientController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PatientController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PatientController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/store', [DoctorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DoctorController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DoctorController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'referral', 'as' => 'referral.'], function () {
        Route::get('/', [ReferralController::class, 'index'])->name('index');
        Route::get('/create', [ReferralController::class, 'create'])->name('create');
        Route::post('/store', [ReferralController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ReferralController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ReferralController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ReferralController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/test', 'as' => 'test.'], function () {
        Route::get('/', [PathologyTestController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTestController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTestController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyTestController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PathologyTestController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTestController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'pathology/test_category', 'as' => 'test_category.'], function () {
        Route::get('/', [PathologyTestCategoryController::class, 'index'])->name('index');
        Route::get('/create', [PathologyTestCategoryController::class, 'create'])->name('create');
        Route::post('/store', [PathologyTestCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PathologyTestCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PathologyTestCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PathologyTestCategoryController::class, 'delete'])->name('delete');
    });
    
});

Auth::routes();

