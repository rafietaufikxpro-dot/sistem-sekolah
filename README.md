# Sistem Sekolah — Portal Akademik Terpadu

Aplikasi web manajemen sekolah berbasis Laravel yang menyediakan akses terpusat bagi Administrator, Guru, dan Siswa untuk mengelola data akademik, nilai, kelas, dan pengajuan administrasi.

---

## Fitur Utama

- **Manajemen Data Siswa** — CRUD data siswa lengkap dengan foto profil, NIS, kelas, dan informasi pribadi
- **Manajemen Data Guru** — CRUD data guru dengan NIP dan mata pelajaran
- **Manajemen Kelas** — Pengelolaan kelas dan penugasan wali kelas
- **Nilai Akademik** — Input dan pantau nilai tugas, UTS, dan UAS per semester dan tahun ajaran
- **Pengajuan Administrasi** — Siswa dapat mengajukan surat/dispensasi secara online; guru memproses persetujuan
- **Dashboard Role-based** — Tampilan dashboard berbeda untuk Admin, Guru, dan Siswa
- **Autentikasi** — Login, registrasi mandiri siswa, dan manajemen profil
- **Alert & Konfirmasi** — Modal konfirmasi sebelum aksi hapus/logout, notifikasi flash otomatis

---

## Role & Hak Akses

| Fitur | Admin | Guru | Siswa |
|---|---|---|---|
| Kelola data siswa | ✅ CRUD | ✅ CRUD | ❌ |
| Lihat detail siswa sendiri | — | — | ✅ |
| Kelola data guru | ✅ CRUD | ❌ | ❌ |
| Kelola kelas | ✅ CRUD | ✅ Lihat kelas sendiri | ❌ |
| Input & edit nilai | ❌ | ✅ (nilai sendiri saja) | ❌ |
| Lihat nilai | ✅ | ✅ | ✅ (nilai sendiri) |
| Buat pengajuan | ❌ | ❌ | ✅ |
| Review pengajuan | ✅ | ✅ | ❌ |
| Hapus pengajuan | ✅ | ❌ | ❌ |
| Dashboard statistik | ✅ | ✅ | ✅ |

---

## Teknologi

- **Backend** — [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend** — [Blade](https://laravel.com/docs/blade) + [Tailwind CSS v4](https://tailwindcss.com) + [Alpine.js](https://alpinejs.dev)
- **Database** — MySQL (via Laravel Eloquent ORM)
- **Auth** — Laravel Breeze (session-based)
- **Build Tool** — [Vite](https://vitejs.dev)
- **Font** — Inter + Source Serif 4 (Google Fonts)

---

## Cara Menjalankan Project

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL
- [Laragon](https://laragon.org) / XAMPP / Herd (opsional)

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/rafietaufikxpro-dot/sistem-sekolah.git
cd sistem-sekolah
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi Node.js**
```bash
npm install
```

**4. Salin dan konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuaikan koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

**5. Jalankan migrasi dan seeder**
```bash
php artisan migrate --seed
```

**6. Buat symlink storage**
```bash
php artisan storage:link
```

**7. Build asset frontend**
```bash
npm run build
```

Atau untuk mode development dengan hot reload:
```bash
npm run dev
```

**8. Jalankan server**
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

### Akun Default (Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@sekolah.sch.id | password |
| Guru | guru@sekolah.sch.id | password |
| Siswa | siswa@sekolah.sch.id | password |

---

## Struktur Role Utama

```
app/
├── Http/
│   ├── Controllers/         # SiswaController, GuruController, NilaiController, dll
│   ├── Middleware/          # EnsureCanReviewPengajuan
│   └── Requests/            # Form Request validation
├── Models/                  # User, Siswa, Guru, Kelas, Nilai, Pengajuan, Role
└── Policies/                # Authorization per model
```

---

## Lisensi

Project ini dibuat untuk keperluan pembelajaran. Bebas digunakan dan dimodifikasi.
