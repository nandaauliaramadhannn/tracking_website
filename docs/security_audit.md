# GovTraffic: Temuan Kekurangan & Risiko

## Ringkasan
Audit singkat ini menyoroti celah keamanan, bug potensial, dan hal-hal yang masih kurang dari aplikasi. Fokus utama adalah API pelacakan, manajemen website, dan keterpaparan data analytics.

## Perbaikan Terkini
- **Validasi & origin check pada tracking publik.** Endpoint `POST /api/app/public/track` kini memvalidasi website/token, URL referrer, user-agent length, serta memblokir origin/referer yang tidak cocok dengan domain website. Permintaan dibatasi rate-limit dan pesan error dibuat generik.【F:app/Http/Controllers/Api/TrackingController.php†L16-L121】【F:routes/api.php†L19-L24】
- **Proteksi analytics API.** Grafik per-bulan kini berada di grup `auth:sanctum` dan pesan error disembunyikan dari klien.【F:routes/api.php†L22-L24】【F:app/Http/Controllers/Api/DashboardApiController.php†L8-L58】
- **Validasi update website.** Pembaruan website memakai validation rules yang sama dengan pembuatan sehingga field sensitif seperti `total_visit` tak bisa dimanipulasi via mass assignment.【F:app/Http/Controllers/Admin/WebsiteController.php†L80-L111】
- **Pagination & filter log pengunjung.** Halaman log kini memakai paginate dengan filter website & pencarian teks untuk menghindari beban berlebih sekaligus memudahkan investigasi.【F:app/Http/Controllers/Admin/VisitorController.php†L10-L36】【F:resources/views/admin/visitor/index.blade.php†L1-L83】
## Temuan Keamanan (tersisa)
- **Tidak ada audit trail atau logging admin untuk aksi kritis.** Pembuatan, pengubahan, dan penghapusan website maupun token tidak meninggalkan jejak audit, menyulitkan investigasi jika terjadi penyalahgunaan.
- **Belum ada mekanisme rotasi/penonaktifan token otomatis.** Token pelacakan aktif permanen tanpa masa berlaku atau rotasi berkala, sehingga token yang bocor tetap bisa dipakai.

## Rekomendasi Singkat
- Tambahkan audit log admin untuk setiap aksi penting dan sediakan rotasi token pelacakan secara terjadwal.
