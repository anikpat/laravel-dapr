<?php

use Illuminate\Http\Request;
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

Route::post('/dapr/create', [\App\Http\Controllers\DaprController::class, 'DaprCreateMessage']);
Route::post('/dapr/cancel', [\App\Http\Controllers\DaprController::class, 'DaprCancelMessage']);
Route::post('/dapr/receive', [\App\Http\Controllers\DaprController::class, 'DaprReceive']);