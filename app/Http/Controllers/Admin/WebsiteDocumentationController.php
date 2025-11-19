<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WebsiteDocumentationController extends Controller
{
    public function show($id)
    {
        try {
            $website = Website::with('tokens')->findOrFail($id);

            // ambil token aktif (1 saja)
            $token = $website->tokens()->where('active', true)->first();

            if (!$token) {
                return back()->with('error', 'Token tidak ditemukan untuk website ini.');
            }

            // URL API tracking
            $apiUrl = url('/api/app/public/track');

            return view('admin.website.documentation', compact('website', 'token', 'apiUrl'));

        } catch (\Exception $e) {

            return back()->with('error', 'Gagal memuat dokumentasi: '.$e->getMessage());
        }
    }
}

