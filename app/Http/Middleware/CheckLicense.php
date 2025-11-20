<?php

namespace App\Http\Middleware;

use App\Services\ClientLicenseService;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan cek lisensi untuk route tertentu
        if (
            $request->is('license*') ||      // form lisensi
            $request->is('login') ||
            $request->is('logout') ||
            $request->is('password/*') ||
            $request->is('assets/*') ||
            $request->is('vendor/*')
        ) {
            return $next($request);
        }

        $service = app(ClientLicenseService::class);
        $local   = $service->getLocalLicense();

        // 1) Kalau belum ada lisensi lokal → paksa ke form
        if (!$local) {
            return redirect()->route('license.form');
        }

        // 2) Kalau sudah ada → cek ke server
        $result = $service->check();

        if (!($result['valid'] ?? false)) {

            // Toast notif supaya user tahu kenapa
            if (class_exists(Alert::class)) {
                Alert::toast(
                    $result['message'] ?? 'Lisensi tidak valid.',
                    'error'
                );
            }

            // Jika request AJAX / API → balas JSON 403
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Lisensi tidak valid.',
                    'reason'  => $result['reason'] ?? null,
                ], 403);
            }

            // Redirect ke form lisensi untuk perbaikan/perpanjang
            return redirect()->route('license.form');
        }

        return $next($request);
    }
}
