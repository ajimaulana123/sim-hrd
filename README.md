# HRD Management System

Sistem manajemen HR untuk mengelola data karyawan, absensi, penggajian, rekrutmen, dan cuti.

## Fitur

- Manajemen Karyawan
  - CRUD data karyawan
  - Validasi data (termasuk batasan gaji maksimum 999,999,999)
  - Pencarian dan filter berdasarkan nama, ID, email, departemen, dan status

- Absensi
  - Clock in/out
  - Riwayat absensi
  - Laporan absensi per karyawan

- Penggajian
  - Perhitungan gaji otomatis
  - Slip gaji
  - Riwayat penggajian

- Rekrutmen
  - Posting lowongan kerja
  - Manajemen lamaran
  - Tracking status lamaran

- Manajemen Cuti
  - Pengajuan cuti
  - Approval/reject cuti
  - Riwayat cuti per karyawan

## Perubahan Terbaru

- Perbaikan validasi input gaji karyawan (maksimum 999,999,999)
- Penambahan user admin default untuk manajemen sistem
- Perbaikan tampilan form pengajuan cuti
- Penanganan error untuk data yang tidak ditemukan

## Setup

1. Clone repository
```bash
git clone [URL_REPOSITORY]
cd hr
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database
```bash
# Update konfigurasi database di .env
php artisan migrate
php artisan db:seed
```

5. Create storage link
```bash
php artisan storage:link
```

6. Run development server
```bash
php artisan serve
npm run dev
```

## Default Admin Account

```
Email: admin@admin.com
Password: password
```

## Kontribusi

Silakan buat pull request untuk kontribusi.

## License

[MIT License](LICENSE)
