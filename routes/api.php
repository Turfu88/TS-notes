<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimesheetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(TimesheetController::class)->group(function () {
    Route::get('timesheets', 'index');
    Route::post('timesheet', 'store');
    Route::get('timesheet/{id}', 'show');
    Route::put('timesheet/{id}', 'update');
    Route::delete('timesheet/{id}', 'destroy');
});
