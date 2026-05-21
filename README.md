# SIREKIPEMA (Sistem Rekap Izin Penelitian Mahasiswa)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-38BDF8)
![Vite](https://img.shields.io/badge/Vite-Frontend-yellow)

Sistem Pengelolaan Surat Izin Penelitian adalah aplikasi berbasis web yang dibangun menggunakan framework Laravel 12 untuk membantu proses pengajuan, verifikasi, persetujuan, dan penerbitan surat izin penelitian secara digital dan terintegrasi.

Sistem ini dirancang untuk digunakan oleh instansi pemerintahan seperti Kesbangpol dengan dukungan multi-role access, audit trail, SIEM monitoring, private file storage, serta otomatisasi pembuatan dokumen PDF dan DOCX.

---

# ✨ Fitur Utama

## 🔐 Sistem Multi-Role

Aplikasi menerapkan Role-Based Access Control (RBAC) menggunakan middleware Laravel untuk membatasi hak akses pengguna berdasarkan peran.

### Super Admin

* Mengelola akun pengguna
* Mengaktifkan akun mahasiswa
* Memantau audit trail
* Memantau SIEM & security logs
* Mengelola data sistem

### Operator

* Mengelola workdesk tiket
* Melakukan verifikasi dokumen
* Mengambil dan memproses tiket permohonan
* Mengunduh dokumen permohonan
* Menghasilkan surat PDF & DOCX

### Kabid (Kepala Bidang)

* Melakukan validasi tingkat lanjut
* Menyetujui atau menolak permohonan
* Melihat preview surat PDF sebelum persetujuan

### Mahasiswa (Pemohon)

* Mengajukan izin penelitian
* Mengunggah dokumen persyaratan
* Melihat status permohonan
* Mengirim revisi dokumen
* Menggunakan fitur autosave formulir

---

# 📄 Pengelolaan Dokumen

## Generate PDF & DOCX

Sistem menggunakan:

* `barryvdh/laravel-dompdf`
* `phpoffice/phpword`

untuk menghasilkan surat resmi secara otomatis dalam format PDF dan DOCX.

## Private File Storage

Seluruh dokumen sensitif disimpan pada direktori private storage Laravel dan hanya dapat diakses melalui route yang telah diautentikasi.

---

# 🛡️ Sistem Keamanan

## Audit Trail

Sistem mencatat aktivitas penting pengguna seperti:

* login
* logout
* perubahan data
* verifikasi tiket
* approval dokumen
* download file

## SIEM Monitoring

Dashboard SIEM digunakan untuk memantau:

* aktivitas mencurigakan
* percobaan login berulang
* akses tidak sah
* anomali aktivitas pengguna

## Rate Limiting

Endpoint autosave mahasiswa dibatasi menggunakan Laravel Rate Limiter untuk mencegah spam dan serangan brute force.

```txt
Maksimal 30 request per menit
```

---

# 🏗️ Arsitektur Sistem

| Layer          | Teknologi               |
| -------------- | ----------------------- |
| Backend        | Laravel 12              |
| Frontend       | Blade, Tailwind CSS     |
| Build Tools    | Vite                    |
| Database       | PostgreSQL              |
| Queue          | Laravel Queue           |
| Authentication | Laravel Auth Middleware |
| File Storage   | Laravel Private Storage |
| PDF Generator  | DomPDF                  |
| DOCX Generator | PHPWord                 |

---

# 🛠️ Tech Stack

## Backend

* PHP 8.2
* Laravel 12

## Frontend

* Tailwind CSS
* Vite
* Blade Template Engine

## Libraries

* Intervention Image v3
* Laravel DomPDF
* PHPWord

## Development Tools

* Laravel Sail
* Laravel Pail
* Laravel Pint
* PHPUnit
* Laravel IDE Helper

---

# 🚀 Instalasi Project

## 1. Clone Repository

```bash
git clone https://github.com/username/kesbangpol-izin-penelitian.git
cd kesbangpol-izin-penelitian
```

---

## 2. Install Dependencies

```bash
composer install
npm install
```

---

## 3. Konfigurasi Environment

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kesbangpol
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Jalankan Migrasi

```bash
php artisan migrate
```

Jika tersedia seeder:

```bash
php artisan db:seed
```

---

## 6. Jalankan Development Server

```bash
composer run dev
```

Command tersebut akan menjalankan:

* Laravel Server
* Queue Listener
* Vite Development Server
* Log Monitoring

---

# ⚠️ Catatan Laravel Pail (Windows)

`php artisan pail` memerlukan extension PHP `pcntl` yang hanya tersedia pada Linux/WSL.

Jika menggunakan Windows native, gunakan alternatif berikut untuk memantau log:

```powershell
Get-Content storage/logs/laravel.log -Wait
```

---

# 🧪 Testing

Menjalankan seluruh pengujian aplikasi:

```bash
composer run test
```

Testing meliputi:

* Authentication Test
* Authorization Test
* Feature Test
* Ticket Workflow Test
* Validation Test

---

# 📁 Struktur Penyimpanan File

```txt
storage/
└── app/
    └── private/
        ├── surat/
        ├── dokumen/
        └── revisi/
```

---

# 👨‍💻 Developer

Dikembangkan untuk digitalisasi layanan izin penelitian pada instansi pemerintahan menggunakan Laravel Framework.

---

# 📝 License

Project ini menggunakan lisensi MIT.

Silakan gunakan, modifikasi, dan distribusikan sesuai ketentuan lisensi.
