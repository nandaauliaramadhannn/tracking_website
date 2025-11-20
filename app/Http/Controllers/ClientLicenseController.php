<?php

namespace App\Http\Controllers;

use App\Services\ClientLicenseService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientLicenseController extends Controller
{
    public function showForm(ClientLicenseService $service)
    {
        $local = $service->getLocalLicense();

        return view('license.setup', [
            'local' => $local,
        ]);
    }

    public function submit(Request $request, ClientLicenseService $service)
    {
        $request->validate([
            'license_key'  => 'required|string',
            'product_code' => 'required|string',
        ]);

        $result = $service->validateAndStore(
            $request->license_key,
            $request->product_code
        );

        if (!($result['valid'] ?? false)) {
            Alert::error('Lisensi Gagal', $result['message'] ?? 'Lisensi tidak valid.');
            return back()->withInput();
        }

        Alert::success('Berhasil', 'Lisensi berhasil diaktifkan.');
        return redirect()->route('dashboard'); // sesuaikan route dashboard kamu
    }
}
