<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\DashboardApiController;

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

Route::post('app/public/track', [TrackingController::class, 'store'])
    ->middleware('throttle:60,1')
    ->name('track');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/chart/per-month', [DashboardApiController::class, 'chartPerMonth'])
        ->name('api.dashboard.chart.permonth');
});
