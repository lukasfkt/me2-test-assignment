<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PointRecordsController;
use Illuminate\Support\Facades\Route;

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

# Public routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);

# Auth require
Route::middleware('auth:api')->controller(CollaboratorsController::class)->prefix('collaborators')->group(function () {
    # GET ROUTES
    Route::get('list', 'list');
    Route::get('search', 'search');

    # PUT ROUTES
    Route::put('edit', 'edit');

    # POST ROUTES
    Route::post('store', 'store');

    # DELETE ROUTES
    Route::delete('delete', 'delete');
});

Route::middleware('auth:api')->controller(ScheduleController::class)->prefix('schedule')->group(function () {
    # GET ROUTES
    Route::get('list', 'list');

    # POST ROUTES
    Route::post('store', 'store');
});

Route::middleware('auth:api')->controller(PointRecordsController::class)->prefix('pointRecords')->group(function () {
    # POST ROUTES
    Route::post('store', 'store');
});
