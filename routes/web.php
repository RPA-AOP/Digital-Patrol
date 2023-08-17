<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Components\Select2Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\MasterCompanyController;
use App\Http\Controllers\PatrolConfigController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\ReportAbnormalityController;
use App\Http\Controllers\ReportAccidentController;
use App\Http\Controllers\ReportPatrolController;
use App\Http\Controllers\ScheduleConfigController;
use App\Http\Controllers\templates\laravel_example\UserManagement;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');

Route::group(['middleware' => ['auth', 'check-permission']], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::controller(Select2Controller::class)->prefix('select2')->name('select2.')->group(function () {
        Route::get('master_program/', [Select2Controller::class, 'master_program'])->name('master_program');
        Route::get('get/', [Select2Controller::class, 'get'])->name('get');
        Route::post('add', [Select2Controller::class, 'store'])->name('add');
    });
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/list', [UserController::class, 'userListPatrol'])->name('list-patrol-user');

    Route::controller(HomeController::class)->prefix('dashboard')
        ->name('dashboard.')->group(function () {
            Route::get('/list', [HomeController::class, 'list'])->name('list');
            Route::get('/data-chart', [HomeController::class, 'chart'])->name('chart');
            Route::get('/data-abnormal-timeseries', [HomeController::class, 'getAbnormalTimeseries'])->name('abnormal-timeseries');
        });


    Route::controller(PatrolConfigController::class)->prefix('patrolconfig')
        ->name('patrolconfig.')->group(function () {
            Route::get('/', [PatrolConfigController::class, 'index'])->name('index');
            Route::get('/list', [PatrolConfigController::class, 'list'])->name('list');
            Route::get('/create', [PatrolConfigController::class, 'create'])->name('create');
            Route::delete('/delete', [PatrolConfigController::class, 'destroy'])->name('delete');
            Route::post('/store', [PatrolConfigController::class, 'store'])->name('store');
            Route::get('/manage/{id}', [PatrolConfigController::class, 'manage'])->name('manage');
            Route::get('/edit/{id}', [PatrolConfigController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [PatrolConfigController::class, 'update'])->name('update');
            Route::post('/updateConfigHierarchy/{id}', [PatrolConfigController::class, 'updateConfigHierarchy'])->name('updateConfigHierarchy');
            Route::post('/import', [PatrolConfigController::class, 'import'])->name('import');
        });
    Route::controller(ScheduleConfigController::class)->prefix('scheduleconfig')
        ->name('scheduleconfig.')->group(function () {
            Route::get('/', [ScheduleConfigController::class, 'index'])->name('index');
            Route::get('/list', [ScheduleConfigController::class, 'list'])->name('list');
            Route::get('/create', [ScheduleConfigController::class, 'create'])->name('create');
            Route::delete('/delete', [ScheduleConfigController::class, 'destroy'])->name('delete');
            Route::post('/store', [ScheduleConfigController::class, 'store'])->name('store');
            Route::get('/manage/{id}', [ScheduleConfigController::class, 'manage'])->name('manage');
            Route::get('/edit/{id}', [ScheduleConfigController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [ScheduleConfigController::class, 'update'])->name('update');
            Route::post('/import', [ScheduleConfigController::class, 'import'])->name('import');
            Route::post('/updateShift/{company_id}', [ScheduleConfigController::class, 'updateShift'])->name('updateShift');
        });

    Route::controller(UserController::class)->prefix('management-user')
        ->name('management-user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/activity', [UserController::class, 'activity'])->name('activity');
            Route::get('/activity/list', [UserController::class, 'activityList'])->name('activity_list');
            Route::get('/list', [UserController::class, 'list'])->name('list');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [UserController::class, 'show'])->name('show');
            Route::get('/detail-user-patrol/{id}', [UserController::class, 'userListPatrol'])->name('user-list-patrol');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [UserController::class, 'update'])->name('update');
            Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
            Route::post('/update-user-group/{id}', [UserController::class, 'updateUserGroup'])->name('updateUserGroup');
        });




    Route::controller(QrcodeController::class)->prefix('qr-code')->name('qr-code.')->group(function () {
        Route::get('/', [QrcodeController::class, 'index'])->name('index');
        Route::get('/dectypQrCode/{id}', [QrcodeController::class, 'index'])->name('decrypt');

    });

    Route::controller(MasterCompanyController::class)->prefix('master-company')
        ->name('master.company.')->group(function () {
            Route::get('/', [MasterCompanyController::class, 'index'])->name('index');
            Route::get('/list', [MasterCompanyController::class, 'list'])->name('list');
            Route::get('/create', [MasterCompanyController::class, 'create'])->name('create');
            Route::post('/store', [MasterCompanyController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MasterCompanyController::class, 'edit'])->name('edit');

        });


    Route::controller(ReportAccidentController::class)->prefix('report-accident')
        ->name('report.accident.')->group(function () {
            Route::get('/', [ReportAccidentController::class, 'index'])->name('index');
            Route::get('/list', [ReportAccidentController::class, 'list'])->name('list');
            Route::get('/detail/{id}', [ReportAccidentController::class, 'detail'])->name('detail');
        });


    Route::controller(ReportPatrolController::class)->prefix('report-patrol')
        ->name('report.patrol.')->group(function () {
            Route::get('/', [ReportPatrolController::class, 'index'])->name('index');
            Route::get('/list', [ReportPatrolController::class, 'list'])->name('list');
            Route::get('/detail/{id}', [ReportPatrolController::class, 'detail'])->name('detail');
            Route::get('/preview', [ReportPatrolController::class, 'preview'])->name('preview');
        });

    Route::controller(ReportAbnormalityController::class)->prefix('report-abnormality')
        ->name('report.abnormal.')->group(function () {
            Route::get('/', [ReportAbnormalityController::class, 'index'])->name('index');
            Route::get('/list', [ReportAbnormalityController::class, 'list'])->name('list');
            Route::get('/detail/{id}', [ReportAbnormalityController::class, 'detail'])->name('detail');
            Route::post('/action/', [ReportAbnormalityController::class, 'action'])->name('action');
        });
});
