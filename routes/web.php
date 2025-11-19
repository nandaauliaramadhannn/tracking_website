<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\WebsiteDocumentationController;
use App\Http\Controllers\Admin\AnalyticsController;
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
    return view('welcome');
});

Route::middleware('guest')->prefix('auth/private')->group(function () {
    // Auth routes will go here
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'loginform'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
});

Route::middleware('auth')->prefix('app/private')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('website', WebsiteController::class);
    Route::get('/website/{id}/documentation', [WebsiteDocumentationController::class, 'show'])->name('website.documentation');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});
