<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aktivasi Lisensi Aplikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    {{-- SweetAlert (toast/info dari middleware & controller) --}}
    @include('sweetalert::alert')

    <div class="container py-5" style="max-width: 480px;">
        <div class="shadow-sm card">
            <div class="text-white card-header bg-primary">
                <h4 class="mb-0">Aktivasi Lisensi Aplikasi</h4>
            </div>

            <div class="card-body">
                <p class="mb-3 text-muted">
                    Masukkan license key yang Anda dapatkan dari penyedia aplikasi.
                </p>

                {{-- INFO LISENSI SAAT INI (JIKA SUDAH PERNAH DISIMPAN) --}}
                @if(!empty($local))
                    <div class="alert alert-info small">
                        <div><strong>Lisensi saat ini:</strong></div>
                        <div>Key: <code>{{ $local['license_key'] ?? '-' }}</code></div>
                        <div>Product Code: <code>{{ $local['product_code'] ?? '-' }}</code></div>
                        <div class="mt-1">
                            Anda dapat mengganti lisensi dengan mengisi form di bawah ini.
                        </div>
                    </div>
                @endif

                <form action="{{ route('license.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">License Key</label>
                        <input type="text" name="license_key"
                               class="form-control @error('license_key') is-invalid @enderror"
                               value="{{ old('license_key', $local['license_key'] ?? '') }}"
                               required>
                        @error('license_key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="product_code"
                               class="form-control @error('product_code') is-invalid @enderror"
                               value="{{ old('product_code', $local['product_code'] ?? config('license.product_code')) }}"
                               required>
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100">
                        Simpan & Validasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS (opsional, kalau butuh komponen JS) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</
