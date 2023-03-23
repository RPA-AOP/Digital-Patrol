<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatrolController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//	return $request->user();
//});
Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";

});
Route::middleware(['auth:sanctum'])->group(function () {

    //USER
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // SCHEDULE
    Route::controller(ScheduleController::class)
        ->prefix('schedule')
        ->name('shedule.')
        ->group(function () {
            Route::get('/', [ScheduleController::class, 'getSchedules'])->name('getSchedule');
            Route::get('/shift', [ScheduleController::class, 'getShift'])->name('getShift');
        });

    // PATROL
    Route::controller(PatrolController::class)
        ->prefix('patrol')
        ->name('patrol.')
        ->group(function () {
            Route::get('/', [PatrolController::class, 'getPatrolConfig'])->name('get');
            Route::post('/activity', [PatrolController::class, 'patrolActivity'])->name('patrol_activity');
            Route::get('/activity', [PatrolController::class, 'getPatrolActivity'])->name('get_patrol_activity');
        });

});
