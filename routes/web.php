<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\ClientLicenseController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\WebsiteDocumentationController;
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
Route::get('/license/setup', [ClientLicenseController::class, 'showForm'])->name('license.form');
Route::post('/license/setup', [ClientLicenseController::class, 'submit'])->name('license.submit');
Route::get('/download/govtraffic-plugin', function () {
    $file = public_path('govtraffic.zip');

    if (!file_exists($file)) {
        abort(404, 'Plugin file not found.');
    }

    return response()->download($file, 'govtraffic-reporter.zip', [
        'Content-Type' => 'application/zip'
    ]);
})->name('plugin.govtraffic.download');
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

    // API endpoints for AJAX polling
    Route::get('/api/dashboard-stats', [ApiController::class, 'dashboardStats'])->name('api.dashboard.stats');
    Route::get('/api/analytics-stats', [ApiController::class, 'analyticsStats'])->name('api.analytics.stats');
    Route::get('/api/website/{id}/stats', [ApiController::class, 'websiteStats'])->name('api.website.stats');

    //visitor
    Route::get('/visitor/data', [VisitorController::class, 'index'])->name('visitor.log.index');
});
