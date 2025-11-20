<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ClientLicenseService
{
    /**
     * Ambil lisensi lokal dari file storage/app/license.json
     */
    public function getLocalLicense(): ?array
    {
        $path = config('license.local_path');

        if (!file_exists($path)) {
            return null;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        return is_array($data) ? $data : null;
    }

    /**
     * Simpan lisensi lokal ke file
     */
    public function saveLocalLicense(string $licenseKey, string $productCode): void
    {
        $path = config('license.local_path');

        $data = [
            'license_key'  => $licenseKey,
            'product_code' => $productCode,
        ];

        file_put_contents($path, json_encode($data));
    }

    /**
     * Validasi lisensi ke server (dipakai middleware)
     */
    public function check(): array
    {
        $local = $this->getLocalLicense();

        if (!$local || empty($local['license_key']) || empty($local['product_code'])) {
            return [
                'valid'   => false,
                'reason'  => 'NO_LOCAL_LICENSE',
                'message' => 'Lisensi belum diatur di aplikasi.',
            ];
        }

        $cacheKey = 'license_status_' . md5($local['license_key'] . $local['product_code']);

        // Cache 5 menit
        return Cache::remember($cacheKey, 60, function () use ($local) {
            $serverUrl = rtrim(config('license.server_url'), '/');
            if (!$serverUrl) {
                return [
                    'valid'   => false,
                    'reason'  => 'NO_SERVER_URL',
                    'message' => 'URL server lisensi belum dikonfigurasi.',
                ];
            }

            try {
                $response = Http::timeout(5)->post($serverUrl . '/api/licenses/validate', [
                    'license_key'  => $local['license_key'],
                    'product_code' => $local['product_code'],
                    'device_id'    => config('license.device_id'),
                ]);

                if (!$response->ok()) {
                    return [
                        'valid'   => false,
                        'reason'  => 'LICENSE_SERVER_ERROR',
                        'message' => 'Gagal menghubungi server lisensi.',
                    ];
                }

                return $response->json();
            } catch (\Throwable $e) {
                return [
                    'valid'   => false,
                    'reason'  => 'LICENSE_SERVER_UNREACHABLE',
                    'message' => 'Server lisensi tidak dapat diakses.',
                ];
            }
        });
    }

    /**
     * Dipakai saat user isi form pertama kali
     */
    public function validateAndStore(string $licenseKey, string $productCode): array
    {
        $serverUrl = rtrim(config('license.server_url'), '/');

        if (!$serverUrl) {
            return [
                'valid'   => false,
                'reason'  => 'NO_SERVER_URL',
                'message' => 'URL server lisensi belum dikonfigurasi.',
            ];
        }

        try {
            $response = Http::timeout(5)->post($serverUrl . '/api/licenses/validate', [
                'license_key'  => $licenseKey,
                'product_code' => $productCode,
                'device_id'    => config('license.device_id'),
            ]);

            $data = $response->json();

            if (!($data['valid'] ?? false)) {
                return $data;
            }

            // kalau valid → simpan lokal
            $this->saveLocalLicense($licenseKey, $productCode);

            // buang cache lama kalau ada
            Cache::flush();

            return $data;
        } catch (\Throwable $e) {
            return [
                'valid'   => false,
                'reason'  => 'LICENSE_SERVER_UNREACHABLE',
                'message' => 'Server lisensi tidak dapat diakses.',
            ];
        }
    }
}
