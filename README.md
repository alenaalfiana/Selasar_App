# 🎓 Selasar - Sistem Informasi Manajemen Event Kampus

Selasar adalah sistem informasi manajemen event kampus berbasis web yang dikembangkan menggunakan **Laravel 12**, **Filament Admin Panel**, dan **MySQL**. Sistem ini membantu mahasiswa menemukan, mendaftar, dan mengikuti berbagai kegiatan kampus secara terpusat.

## ✨ Fitur Utama

### 👤 User

* Melihat daftar event kampus
* Filter event berdasarkan kategori dan jenis
* Melihat detail event
* Mendaftar event
* Upload bukti pembayaran
* Melihat status pendaftaran
* Mendapatkan tiket digital setelah pembayaran divalidasi

### 🛠️ Admin

* Kelola data event (CRUD)
* Kelola kategori event
* Kelola jenis event
* Kelola pendaftaran peserta
* Validasi pembayaran
* Generate tiket peserta
* Kelola presensi peserta
* Monitoring data event dan peserta

---

## 🗄️ Struktur Database

Terdiri dari 8 tabel utama:

* users
* event
* kategori
* jenis
* pendaftaran
* pembayaran
* tiket
* presensi

Relasi yang digunakan:

* One-to-One (1:1)
* One-to-Many (1:N)
* Many-to-Many (M:N)

---

## 🚀 Teknologi

* Laravel 12
* Filament 5
* MySQL
* Tailwind CSS
* PHP 8+

---

## 🔑 Akun Demo

### Admin

Email:

```text
admin@gmail.com
```

Password:

```text
password
```

### User

Email:

```text
user@gmail.com
```

Password:

```text
password
```

---

## ⚙️ Instalasi

Clone repository:

```bash
git clone <repository-url>
```

Masuk ke folder project:

```bash
cd selasar-app
```

Install dependency:

```bash
composer install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`, kemudian jalankan:

```bash
php artisan migrate --seed
```

Buat symbolic link storage:

```bash
php artisan storage:link
```

Jalankan aplikasi:

```bash
php artisan serve
```

---

## 📖 Alur Sistem

1. Admin membuat event.
2. User melihat daftar event.
3. User melakukan pendaftaran.
4. User mengunggah bukti pembayaran (jika event berbayar).
5. Admin memvalidasi pembayaran.
6. Sistem menerbitkan tiket digital.
7. Peserta menggunakan tiket saat menghadiri event.
8. Admin melakukan presensi peserta.

---

## 📚 Proyek Akademik

Proyek ini dikembangkan sebagai tugas Ujian Akhir Semester (UAS) mata kuliah **Pemrograman Web** dan **Basis Data**, dengan implementasi:

* Laravel Framework
* Filament Resource
* ERD Konseptual dan Relasional
* Trigger Database
* Stored Procedure
* Database View
* Database Index
* Multi User Authentication & Authorization
