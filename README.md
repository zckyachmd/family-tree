# Family Tree

Family Tree adalah aplikasi web yang dibangun menggunakan teknologi Laravel 10, MySQL, Bootstrap 5, dan jQuery. Aplikasi ini bertujuan untuk membantu pengguna dalam membuat pohon keluarga mereka.

## Requirements

-   PHP 8.1 atau lebih baru
-   Composer
-   MySQL 5.7 atau lebih baru
-   Git

## Installation

1. Clone repository ini dengan menggunakan perintah berikut:

```bash
git clone https://github.com/zckyachmd/family-tree.git
```

2. Masuk ke dalam folder proyek dengan menggunakan perintah berikut:

```bash
cd family-tree
```

3. Install semua dependensi yang dibutuhkan oleh aplikasi dengan menggunakan perintah berikut:

```bash
composer install
```

4. Salin file .env.example menjadi .env dengan menggunakan perintah berikut:

```bash
cp .env.example .env
```

5. Buatlah database baru di MySQL dengan nama family_tree.
6. Ubah konfigurasi database di file .env sesuai dengan konfigurasi database yang telah dibuat.
7. Jalankan perintah berikut untuk melakukan migrasi dan seeding:

```bash
php artisan migrate --seed
```

Perintah ini akan membuat semua tabel yang dibutuhkan oleh aplikasi dan mengisi data awal ke dalam database. 8. Jalankan perintah berikut untuk menjalankan aplikasi:

```bash
php artisan serve
```

9. Aplikasi sekarang bisa diakses di http://localhost:8000.

## Documentation

Dokumentasi API dapat diakses di [Postman](https://documenter.getpostman.com/view/16163112/2s93JqS5Cc). Dokumentasi ini menyediakan informasi tentang endpoint-endpoint yang tersedia, parameter yang diperlukan, dan contoh tanggapan yang dihasilkan oleh masing-masing endpoint.
