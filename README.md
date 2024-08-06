# API Rekam Medik

## Penjelasan

API Rekam Medik dirancang untuk mengelola data rekam medis pasien.

##### Akun

-   Username = admin
-   password = 123

##### fitur

-   Login = Endpoint untuk mengotentikasi pengguna ke dalam sistem atau aplikasi.
-   Add Patient = Endpoint untuk menambah pasien ke dalam sistem atau aplikasi.
-   Make Visit = Endpoint untuk membuat kunjungan.

##### Teknologi

-   Bahasa Pemrograman = PHP 8.1
-   Framework = Laravel 10
-   Basis Data = MySQL Ver. 8.0
-   Dokumentasi API = [Postman](https://documenter.getpostman.com/view/29022837/2sA3rxqDcA)

## Instalasi

Clone repositori

```bash
https://github.com/ZyanAlkanza/rekam_medik_backend.git
```

Instal dependensi

```bash
composer install
```

Konfigurasi .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rekam_medik
DB_USERNAME=username
DB_PASSWORD=password
```

Jalankan Migrasi

```bash
php artisan migrate
```

Jalankan Server

```bash
php artisan serve
```

## Lisensi

[MIT](https://choosealicense.com/licenses/mit/)
