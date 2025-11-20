<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       if (app()->runningInConsole() === false) {
            $result = app(\App\Services\ClientLicenseService::class)->check();
            if (!($result['valid'] ?? false)) {
                abort(403, 'Lisensi tidak valid.');
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
