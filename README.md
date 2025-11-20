# 🌐 GovTraffic — Government News Traffic Tracker  
![Laravel](https://img.shields.io/badge/Laravel-Framework-red?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue?style=flat-square)
![WordPress](https://img.shields.io/badge/WordPress-Plugin-blue?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

GovTraffic adalah platform **Tracking Pengunjung** untuk website berita/media dan dipusatkan ke dalam **Dashboard Pemerintahan**.  
Aplikasi ini mencatat setiap kunjungan (IP, referrer, device, halaman yang dikunjungi) melalui **API**, **JavaScript Snippet**, atau **WordPress Plugin**.

GovTraffic cocok untuk kebutuhan:

- Pemerintah daerah yang ingin mengetahui **jumlah pengunjung setiap media lokal**
- Mengetahui **berita apa yang paling banyak dibaca**  
- Membandingkan performa website media setiap bulan  
- Monitoring real-time traffic visitor berbagai portal berita  

---

## 🚀 Fitur Utama

### 🔹 1. Tracking Visitor Real-Time
- Mencatat setiap kunjungan halaman
- Menyimpan:
  - IP Address  
  - Referrer  
  - User Agent  
  - Current URL (link berita)  
  - Timestamp (visited_at)

### 🔹 2. Dashboard Pemerintah (Highcharts)
- Total Websites  
- Total Visits  
- Total Logs  
- Today’s Visits  
- Recent Visitor Logs  
- **Top Websites**  
- **Top Articles (Link Berita paling dibaca)**  
- **Monthly Visit Comparison Chart (Per Website)**  

### 🔹 3. Integrasi Multi-Platform
- JavaScript Snippet (HTML, Laravel Blade, Blogger, React)
- WordPress Plugin (auto tracking setiap post)
- Manual API Support

### 🔹 4. WordPress Plugin
- Upload plugin → Masukkan Website ID & Token → tracking otomatis  
- Plugin otomatis mengirim current URL, user-agent, referrer

### 🔹 5. Security
- Per-website Token Authentication  
- Domain & Origin Validation  
- Tamper-proof logs  
- Rate limiting anti-spam request  

---

# 🏗 Arsitektur Aplikasi
GovTraffic (Laravel Backend)
│
├── Website Management
├── Visitor Tracking (API)
├── VisitorLog DB Storage
├── Token Management
├── WordPress Plugin
└── Dashboard Admin (Highcharts)
# 📥 Instalasi Aplikasi (Backend)

### 1. Clone Repository
### 2. Install Dependency
composer install
npm install
npm run build
### 3. Setup Environment
cp .env.example .env
php artisan key:generate

Sesuaikan database Anda di `.env`.
### 4. Migrasi & Seeder
php artisan migrate --seed
### 5. Jalankan Server
php artisan serve
