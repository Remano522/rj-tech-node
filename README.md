# RJ Tech Node Portfolio App

Web portfolio berbasis Laravel untuk menampilkan profil creator, CV interaktif, dan galeri proyek. Aplikasi ini juga menyediakan dashboard admin untuk mengelola data portfolio secara dinamis tanpa mengubah kode secara manual.

## Fitur Utama

- Landing page portfolio dengan hero section, daftar creator, dan galeri proyek.
- Modal detail proyek dan modal CV yang diambil langsung dari database.
- Login admin dengan autentikasi Laravel.
- Otorisasi admin menggunakan middleware khusus.
- CRUD proyek: create, read, update, delete.
- Manajemen foto proyek: upload, ganti, dan hapus.
- Edit biodata dan CV creator dari dashboard.
- Validasi input menggunakan Form Request.
- UI interaktif dengan dark mode, modal, dan konfirmasi aksi menggunakan SweetAlert2.
- Seed data untuk akun admin, proyek, dan CV.

## Stack Teknologi

- Backend: PHP 8.2, Laravel 12, Eloquent ORM
- Frontend: Blade, HTML, CSS, JavaScript
- Database: SQLite/MySQL compatible via migration Laravel
- Tooling: Vite, PHPUnit
- Library tambahan: SweetAlert2

## Struktur Data

### `users`

- Menyimpan akun login.
- Memiliki field `is_admin` untuk otorisasi dashboard admin.

### `projects`

- Menyimpan judul proyek, creator, kategori, deskripsi, dan gambar.

### `cvs`

- Menyimpan data profil creator.
- Kolom `skills`, `experience`, dan `certifications` disimpan sebagai JSON array.

## Alur Aplikasi

### Halaman publik

- Route `/` mengambil semua data `projects` dan `cvs`.
- User bisa melihat gallery proyek.
- User bisa klik creator untuk melihat CV dalam modal.

### Halaman admin

- Route `/login` digunakan untuk autentikasi.
- Route `/admin/dashboard` hanya bisa diakses user dengan `is_admin = true`.
- Admin bisa:
  - menambah proyek
  - mengedit proyek
  - menghapus proyek
  - upload atau hapus foto proyek
  - memperbarui CV creator

## Cara Menjalankan Project

### 1. Install dependency

```bash
composer install
npm install
```

### 2. Siapkan environment

```bash
copy .env.example .env
php artisan key:generate
```

### 3. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

### 4. Jalankan aplikasi

```bash
php artisan serve
npm run dev
```

## Akun Admin Default

- Email: `admin@rjtech.com`
- Password: `admin123`

## Testing

Jalankan pengujian dengan:

```bash
php artisan test
```

Test yang sudah disiapkan mencakup:

- akses dashboard admin
- pembatasan akses non-admin
- CRUD proyek
- update data CV

## Catatan Penilaian

Project ini sudah mencakup komponen rubric berikut:

- Front End: desain antarmuka, HTML/CSS, JavaScript interaktif, aksesibilitas dasar
- Back End: struktur kode, autentikasi, otorisasi, CRUD, validasi data, keamanan dasar
- Basis Data: migration, seeder, desain tabel, konsistensi data
- Fungsi: landing page publik, admin dashboard, error handling berbasis validasi
- Dokumentasi: README teknis dan alur penggunaan
