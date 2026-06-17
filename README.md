# Laravel Vue Project

## Persyaratan

Pastikan perangkat sudah terinstall:

- PHP >= 8.4
- Node.js >= 18
- MySQL / MariaDB

## Instalasi Project

### 1. Install Dependency Backend

composer install

### 2. Install Dependency Frontend

npm install

### 3. Konfigurasi Database

Sesuaikan konfigurasi database pada file `.env`

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

### 4. Jalankan Migrasi (opsional)

php artisan migrate

Jika butuh data dummy bisa jalankan

php artisan db:seed

Atau sekaligus:

php artisan migrate --seed

### Menjalankan Laravel
buat 2 terminal lalu masukan perintah

php artisan serve

### Menjalankan Vue (Vite)

npm run dev

Aplikasi dapat diakses melalui:

http://127.0.0.1:8000

## Struktur Teknologi

- Laravel 9
- Vue 3
- Inertia.js
- Tailwind CSS
- MySQL


### Menjalankan Ulang Migration (opsional)

php artisan migrate:fresh --seed

### Membuat Storage Link (jika file upload tidak berjalan)
file upload bisa dicek di storage/app/public/agenda
Jika project menggunakan upload file:

php artisan storage:link

## Catatan

Pastikan service MySQL sudah berjalan sebelum menjalankan migration.