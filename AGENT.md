# AGENT.md — Sistem Sekolah (Laravel)

Dokumen ini adalah panduan kerja untuk AI coding agent yang membantu membangun project **Sistem Sekolah**. Ikuti aturan di sini secara ketat — ini merangkum PRD project dan aturan akademik (LKPD Sumatif Tengah Semester) yang harus dipatuhi.

## 1. Ringkasan Project

Aplikasi web berbasis **Laravel** untuk sentralisasi data siswa, guru, nilai akademik, dan pengajuan administrasi sekolah. Masalah yang diselesaikan:
- Petugas kesulitan mencari data tertentu.
- Data administrasi tersebar di berbagai file.
- Riwayat pengajuan administrasi sulit dilacak.

## 2. Tech Stack (WAJIB, jangan diganti tanpa konfirmasi user)

- **Framework:** Laravel (versi terbaru stabil, MVC)
- **Auth:** Laravel Breeze — **stack Blade** (bukan Livewire/Inertia/React/Vue)
- **Styling:** Tailwind CSS (bawaan Breeze), dipakai konsisten di seluruh halaman
- **Templating:** Blade — layout reusable (components/partials), directive looping & conditional, `@include`/`<x-component>`
- **Database:** MySQL, via Eloquent ORM
- **Validasi:** Laravel FormRequest — WAJIB terpisah dari Controller, jangan validasi inline di controller
- **Authorization:** Laravel Gate/Policy, 3 role dengan hak akses benar-benar berbeda
- **Middleware:** Minimal 1 custom middleware dengan fungsi nyata (bukan sekadar contoh kosong)

## 3. Role & Hak Akses (WAJIB diimplementasikan persis seperti ini)

| Role | Hak Akses |
|---|---|
| **siswa** | Login, register (mandiri via Breeze), lihat data pribadi, lihat nilai akademik sendiri, buat & lihat status pengajuan administrasi sendiri |
| **guru** | CRUD data siswa, input/ubah nilai siswa, lihat & setujui/tolak pengajuan administrasi, **hanya bisa melihat** (read-only) data kelas perwaliannya — tidak ada hak edit |
| **admin** | Semua hak kecuali: (a) mengubah struktur database, (b) mengubah nilai akademik siswa. Admin: tambah/ubah/hapus akun guru, CRUD siswa, **CRUD penuh data kelas** termasuk assign/ubah `wali_kelas_id`, moderasi penuh atas semua pengajuan (lihat/edit/hapus), lihat dashboard ringkasan |

**Aturan ketat:**
- Guru **tidak boleh** self-register lewat form publik — akun guru dibuat oleh admin.
- Admin **tidak boleh** bisa mengubah kolom nilai siswa lewat endpoint apapun — blokir di level Policy, bukan cuma di UI.
- Guru **read-only** terhadap data kelas — cuma boleh melihat kelas di mana `kelas.wali_kelas_id === guru.id` yang sedang login, tidak ada endpoint create/update/delete kelas untuk guru sama sekali.
- Admin punya **CRUD penuh** atas resource `kelas`, termasuk yang menentukan/mengubah `wali_kelas_id` (assign guru mana yang jadi wali kelas mana).

## 4. Skema Database (gunakan persis nama tabel & kolom ini agar sinkron dengan ERD manual project)

```
users
  id (pk), role_id (fk -> role.id), name, email, password, timestamps

role
  id (pk), name_role

admin
  id (pk), user_id (fk -> users.id)

guru
  id (pk), user_id (fk -> users.id), nip, mapel   -- 1 guru = 1 mapel, JANGAN dipecah jadi tabel terpisah

siswa
  id (pk), user_id (fk -> users.id), kelas_id (fk -> kelas.id), nis, jenis_kelamin, alamat, foto

kelas
  id (pk), nama_kelas, jurusan, wali_kelas_id (fk -> guru.id)

nilai
  id (pk), siswa_id (fk -> siswa.id), guru_id (fk -> guru.id),
  semester, tahun_ajaran, jenis_nilai (enum: tugas, uts, uas), nilai, keterangan, timestamps

pengajuan
  id (pk), siswa_id (fk -> siswa.id), guru_id (fk -> guru.id, nullable),
  jenis_pengajuan, keterangan (text), status (enum: menunggu, disetujui, ditolak),
  catatan_guru (nullable), tanggal_pengajuan, tanggal_diproses, file_lampiran (nullable), timestamps
```

**Catatan implementasi Eloquent:**
- `User` → `belongsTo Role`; `User` → `hasOne Siswa/Guru/Admin` (tergantung role)
- `Siswa` → `belongsTo Kelas`, `hasMany Nilai`, `hasMany Pengajuan`
- `Guru` → `hasOne Kelas` (sebagai wali kelas), `hasMany Nilai` (yang dia input), `hasMany Pengajuan` (yang dia proses)
- `Pengajuan.guru_id` **nullable** karena saat status masih `menunggu`, belum tentu ada guru yang memprosesnya
- `Nilai.guru_id` **wajib diisi (NOT NULL)** — beda dengan pengajuan, setiap baris nilai pasti diinput oleh guru tertentu, tidak ada status "pending" untuk nilai
- Saat load list yang butuh relasi (misal daftar pengajuan dengan nama siswa & guru), **wajib eager load** (`with('siswa', 'guru')`) — jangan biarkan N+1 query

## 5. Functional Requirements (checklist implementasi)

### Auth & Profil
- [ ] Siswa registrasi & login mandiri (email) via Breeze
- [ ] Akun guru/admin dibuat oleh admin, bukan form publik
- [ ] Logout & middleware `auth` untuk halaman terproteksi
- [ ] Guru dapat melihat profil sendiri

### Data Siswa (guru & admin bisa CRUD)
- [ ] Simpan, tambah, ubah, hapus data siswa
- [ ] Lihat, cari (search), filter, dan pagination data siswa — **ketiganya harus tetap bekerja bersamaan** (jadikan ini modul utama untuk requirement "search+filter+pagination")

### Manajemen Akun Guru (admin only)
- [ ] Tambah, ubah, hapus, lihat data guru

### Manajemen Kelas
- [ ] Guru: lihat (read-only) kelas perwaliannya — tidak ada tombol edit/tambah/hapus untuk guru
- [ ] Admin: CRUD penuh kelas (tambah, ubah, hapus, termasuk assign `wali_kelas_id`)

### Nilai Akademik
- [ ] Siswa: lihat nilai sendiri (read-only)
- [ ] Guru: input & ubah nilai siswa (jenis_nilai: tugas/uts/uas, per semester & tahun ajaran)
- [ ] Admin: **read-only**, tidak boleh ubah nilai

### Pengajuan Administrasi
- [ ] Siswa: buat pengajuan baru, upload lampiran opsional
- [ ] Siswa: lihat status pengajuan sendiri + riwayatnya
- [ ] Guru: lihat daftar pengajuan masuk, setujui/tolak (update status + catatan_guru + tanggal_diproses)
- [ ] Admin: lihat semua pengajuan, bisa edit & hapus (moderasi)
- [ ] Search/filter pengajuan berdasarkan status, jenis, atau siswa

### Dashboard Admin
- [ ] Angka ringkas: total siswa, total guru (tidak perlu grafik/chart)
- [ ] Tabel/list gabungan data guru & siswa dalam satu halaman

## 6. Middleware Custom (wajib buat minimal 1, contoh konkret)

Buat middleware yang memblokir **siswa** dari route approval pengajuan (`/pengajuan/{id}/approve`, `/pengajuan/{id}/reject`), karena hanya guru & admin yang boleh memproses persetujuan. Contoh nama: `EnsureCanReviewPengajuan`.

## 7. Aturan yang TIDAK BOLEH dilanggar agent

- **JANGAN generate gambar/file ERD** — aturan akademik project ini melarang ERD dibuat oleh AI. Agent hanya boleh bantu migration, model, controller, dan kode lain — bukan diagram ERD.
- **JANGAN ubah struktur database** (nama tabel/kolom) yang sudah ditetapkan di section 4 tanpa konfirmasi eksplisit ke user — ini sudah difinalisasi dari PRD.
- **JANGAN buat admin bisa mengubah nilai** — ini pelanggaran requirement inti.
- **JANGAN buat guru bisa self-register** — akun guru hanya dibuat lewat panel admin.
- **JANGAN buat guru punya endpoint create/update/delete untuk kelas** — guru cuma boleh read (lihat kelas perwaliannya).
- FormRequest wajib dipakai untuk semua validasi form, jangan taruh `$request->validate()` langsung di controller.
- **JANGAN ubah token warna/dark mode di section 8 (Style Guide)** tanpa konfirmasi eksplisit ke user — sudah difinalisasi dari review prototipe demo.

## 8. Style Guide / Design System (Tailwind, WAJIB diikuti)

Basis palet & komponen di bawah ini diturunkan dari prototipe demo interaktif (HTML/JS) yang sudah direview — dipakai sebagai acuan visual resmi saat membangun Blade view. **Jangan ubah token warna di bawah ini tanpa konfirmasi eksplisit ke user** (sama seperti aturan skema database di section 4).

### Dark mode
- Ikut **preferensi sistem/browser secara otomatis** — TIDAK ada toggle manual di UI.
- Di `tailwind.config.js`: `darkMode: 'media'` (bukan `'class'`), karena tidak ada switch yang perlu disimpan per user.
- Setiap komponen/utility warna WAJIB punya pasangan `dark:` — jangan hardcode warna tanpa varian gelapnya (rawan invisible/kontras jelek di dark mode).

### Palet warna
Tambahkan di `tailwind.config.js` → `theme.extend.colors`:

```js
colors: {
  ink:   { 900:'#1B2430', 700:'#3A4756', 500:'#6B7686', 300:'#AEB6C2', 100:'#E6E9ED', 50:'#F4F5F7' },
  navy:  { 900:'#152238', 700:'#22375C', 600:'#2C4573', 100:'#E2E8F5' },
  amber: { 600:'#B8790A', 100:'#FBEBCC' },
  green: { 700:'#276749', 100:'#DFF3E6' },
  red:   { 700:'#B3261E', 100:'#FBE3E1' },
  paper: '#FBFAF7',
}
```

Padanan dark mode (pakai token yang sama, tapi surface & ink dibalik — bisa didefinisikan sebagai CSS variables di `resources/css/app.css` lalu dipanggil lewat arbitrary value `bg-[var(--surface)]`, supaya tidak perlu tulis `dark:` di setiap elemen satu-satu):

```css
:root {
  --paper: #FBFAF7; --card: #FFFFFF; --ink-900:#1B2430; --ink-500:#6B7686; --border:#E6E9ED;
}
@media (prefers-color-scheme: dark) {
  :root {
    --paper:#161C25; --card:#1D2531; --ink-900:#EDEFF2; --ink-500:#94A0AF; --border:#2A3341;
  }
}
```

### Tipografi
- Font UI/body: **Inter** (400/500/600). Font heading besar: **Source Serif 4** (500/600).
- Load lewat **Google Fonts CDN** (bukan bundling npm/`@fontsource`) — tambahkan di `<head>` layout utama (`resources/views/layouts/app.blade.php`), sebelum `@vite`/CSS project:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,500;8..60,600&display=swap" rel="stylesheet">
```

Lalu daftarkan sebagai `fontFamily` di `tailwind.config.js`:

```js
fontFamily: {
  sans: ['Inter', 'ui-sans-serif', 'system-ui'],
  serif: ['"Source Serif 4"', 'Georgia', 'serif'],
}
```

- Pakai `font-sans` untuk body/UI (default), `font-serif` khusus untuk judul dashboard/halaman (18–26px, 500/600).
- Body text 14–14.5px, line-height nyaman (±1.6).

### Komponen Blade yang perlu dibuat (`resources/views/components/`)
- `<x-button variant="primary|ghost|danger">` — primary = navy-700 bg + teks putih, ghost = transparan + hover ink-50/dark, danger = border+teks red-700
- `<x-badge status="menunggu|disetujui|ditolak">` — menunggu=amber, disetujui=green, ditolak=red (masing-masing pakai pasangan *-100 bg + *-700 teks)
- `<x-card>` — surface putih/`--card`, border 1px `--border`, radius 12px, padding 20px
- `<x-metric-card label value>` — untuk dashboard admin (total siswa, total guru, dst.)
- Tabel data: header uppercase 12px ink-500, row border-bottom ink-100/dark, hover ink-50/dark
- Layout utama: sidebar 230px (navy-900 bg) + topbar sticky; sidebar collapse jadi hamburger di breakpoint <820px (mobile)

### Referensi visual
Prototipe interaktif (vanilla HTML/JS, BUKAN kode Laravel — jangan disalin literal) yang menunjukkan semua pola di atas: lihat artifact "Sistem Sekolah — Demo Full" yang sudah dibagikan sebelumnya di percakapan. Gunakan sebagai referensi tata letak & interaksi (login, dashboard per role, tabel search/filter/pagination, modal form, badge status) saat membangun Blade view.

## 9. Definition of Done

Client dapat menggunakan sistem sesuai kebutuhan utama (pencarian data & tracking pengajuan); tiap role mengakses sistem sesuai hak aksesnya masing-masing; seluruh data dikelola lewat Laravel (bukan manual/file terpisah); relasi antar tabel jelas dan konsisten; dan semua fitur di atas bisa dipakai lewat antarmuka aplikasi (bukan cuma lewat tinker/seeder).

---
*Dokumen ini diturunkan dari PRD Sistem Sekolah v1.0 (Final). Kalau ada requirement yang berubah di PRD, update juga file ini.*
