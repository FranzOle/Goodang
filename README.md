# 📦 Goodang - Sistem Manajemen Gudang  

Goodang adalah aplikasi berbasis web untuk mempermudah pengelolaan aktivitas gudang secara digital. Dengan fitur-fitur yang canggih, Goodang memastikan pencatatan, pelacakan, dan analisis barang berjalan dengan lancar. 🚀  

## ✨ Keunggulan Utama  
- **Manajemen Gudang & Barang:** Tambah, edit, hapus gudang & barang. 🏷️  
- **Transaksi Barang:** Catat barang masuk, keluar, dan stok opname. 🔄  
- **Laporan:** Laporan stok barang, transaksi, dan kartu stok. 📊  
- **Cetak Label:** Cetak label dengan pdf untuk barang. 🖨️  
- **Pengelolaan Pengguna:** Registrasi & manajemen akses pengguna. 👥
- **Integrasi AI:** Gunakan AI yang sudah terintegrasi. 🤖
- **Free API:** Kelola API goodang ini yang memudahkan anda mengembangkan aplikasi sesuai dengan platform yang anda mau 👨🏻‍💻
- **Free Aplikasi Flutter:** Aplikasi android yang juga terintegrasi dalam satu database dan sistem 📱 
- **Multi-Gudang:** Kelola lebih dari satu gudang. 🌐  

---


## 🎯 Target Pengguna  
1. **Admin Gudang:** Mengelola seluruh data dan aktivitas gudang. 🛠️  
2. **Petugas Gudang:** Mencatat barang masuk, keluar, dan stok penjualan. 📋  

---

## 🚀 Mulailah Menggunakan Goodang  
Goodang membantu Anda mengelola gudang dengan lebih efisien dan modern. Jangan ragu untuk mencoba aplikasi ini! 😊  

---

# 📦 Panduan Lengkap Setup Aplikasi Goodang
Panduan ini akan membantu Anda melakukan setup aplikasi dengan langkah-langkah berikut. Pastikan Anda mengikuti setiap langkah dengan saksama. 🚀

---

## 📋 Persyaratan Minimum dan Opsional

- **PHP:** Versi 8.1 atau lebih baru
- **Python:** Versi 3 atau lebih baru (opsional)  
- **Composer:** Versi terbaru  
- **Node.js & npm:** Node.js versi 16 ke atas dan npm versi 8 ke atas  
- **Database:** PostgreSQL, MySQL, atau lainnya sesuai preferensi Anda  
- **Ekstensi PHP:** `pdo_pgsql` atau `pdo_mysql` (sesuai database), `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`  

---

## 🛠️ Langkah-Langkah Setup

1. **Clone Repository**  
   Clone repository ini ke dalam direktori lokal Anda (jika pakai Git):  
   **`git clone https://github.com/FranzOle/Goodang.git`**

2. **Install Dependencies**  
   Masuk ke direktori project, lalu install dependensi:  
   **`composer install`**  
   **`npm install`**

3. **Konfigurasi File `.env`**  
   Salin file `.env.example` menjadi `.env` dengan perintah:  
   **`cp .env.example .env`**  
   Kemudian, sesuaikan pengaturan database di file `.env`. Contoh untuk PostgreSQL:  
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=goodang
   DB_USERNAME=postgres
   DB_PASSWORD=postgres
   ```
   Contoh untuk MySQL:  
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=goodang
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. **Konfigurasi `app/config/database.php`**  
   Pastikan konfigurasi di `app/config/database.php` mendukung jenis database yang Anda pilih. Contoh:  
   ```php
   'default' => env('DB_CONNECTION', 'pgsql'),
   'connections' => [
       'pgsql' => [
           'driver' => 'pgsql',
           'host' => env('DB_HOST', '127.0.0.1'),
           'port' => env('DB_PORT', '5432'),
           'database' => env('DB_DATABASE', 'forge'),
           'username' => env('DB_USERNAME', 'forge'),
           'password' => env('DB_PASSWORD', ''),
           'charset' => 'utf8',
           'prefix' => '',
           'schema' => 'public',
       ],
       'mysql' => [
           'driver' => 'mysql',
           'host' => env('DB_HOST', '127.0.0.1'),
           'port' => env('DB_PORT', '3306'),
           'database' => env('DB_DATABASE', 'forge'),
           'username' => env('DB_USERNAME', 'forge'),
           'password' => env('DB_PASSWORD', ''),
           'charset' => 'utf8mb4',
           'collation' => 'utf8mb4_unicode_ci',
           'prefix' => '',
           'strict' => true,
       ],
   ],
   ```

5. **Generate Application Key dan Storage Link**  
   Jalankan perintah untuk menghasilkan application key dan link ke public:  
   **`php artisan key:generate`**
   **`php artisan storage:link`**

6. **Migrasi dan Seeder**  
   Jalankan migrasi untuk membuat tabel database:  
   **`php artisan migrate`**  
   Kemudian, buat akun admin default dengan menjalankan seeder:  
   **`php artisan db:seed --class=UserSeeder`**  
   Akun admin yang dihasilkan adalah:  
   - **Email:** admin@goodang.com  
   - **Password:** password  

7. **Konfigurasi JWT**  
   Jalankan di cmd atau powershell kode ini untuk generate secret key   
   **`php artisan jwt:secret"`**
   
8. **Jalankan Server**  
   Jalankan server untuk memastikan aplikasi berfungsi:  
   **`php artisan serve`**  
   Di terminal lain, jalankan:  
   **`npm run dev`**  

9. **Jalankan Aplikasi AI (Jika perlu)**  
   Jalankan di cmd atau powershell kode ini  
   **`python "goodang/python/index.py"`**

10. **Jalankan Aplikasi Android**  
   Jalankan di cmd atau powershell kode ini (note: pakai Handphone anda dengan debugging USB atau android emulator
   **`cd goodang_mobile`**
    Lalu Jalankan perintah ini:
   **`flutter run`**
   
---

## 🛠️ Teknologi yang Digunakan  

- **Framework:** Laravel 10, Flutter, VueJS
- **Frontend:** Bootstrap 5, AdminLTE3, JQuery, TailwindCSS
- **Fitur Tambahan:** Jetstream 4, Flash, MPdf, Spatie, TKinter, JWT, Google Gemini, Gradle, JWT  
- **Database:** PostgreSQL 15, MySQL
- **Bahasa Pemrograman:** PHP, Javascript, Python, Dart
- **Konfigurasi Lokasi:** Nominatim dan Leaflet  

---

## 🧑‍💻 Pengembang  

Aplikasi ini dikembangkan oleh:  
**Lionel Jevon Chrismana Putra**  
Siswa Kelas XII, SMKN 2 Buduran
Intern Hexa Integra Mandiri.
  

## Note
Aplikasi ini belum sepenuhnya selesai dan butuh pengembangan lebih lanjut
