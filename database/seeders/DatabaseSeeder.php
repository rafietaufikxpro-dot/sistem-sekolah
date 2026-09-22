<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Pengajuan;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $roleSiswa = Role::where('name_role', 'siswa')->first()->id;
        $roleGuru = Role::where('name_role', 'guru')->first()->id;
        $roleAdmin = Role::where('name_role', 'admin')->first()->id;

        // Admin User
        $adminUser = User::create([
            'role_id' => $roleAdmin,
            'name' => 'Administrator Utama',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        Admin::create(['user_id' => $adminUser->id]);

        // Guru 1
        $guruUser1 = User::create([
            'role_id' => $roleGuru,
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'budi.santoso@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        $guru1 = Guru::create([
            'user_id' => $guruUser1->id,
            'nip' => '198501012010011001',
            'mapel' => 'Matematika',
        ]);

        // Guru 2
        $guruUser2 = User::create([
            'role_id' => $roleGuru,
            'name' => 'Siti Aminah, M.Pd.',
            'email' => 'siti.aminah@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        $guru2 = Guru::create([
            'user_id' => $guruUser2->id,
            'nip' => '198803152012022002',
            'mapel' => 'Bahasa Indonesia',
        ]);

        // Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'X IPA 1',
            'jurusan' => 'MIPA',
            'wali_kelas_id' => $guru1->id,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'XI IPS 2',
            'jurusan' => 'IPS',
            'wali_kelas_id' => $guru2->id,
        ]);

        // Siswa 1
        $siswaUser1 = User::create([
            'role_id' => $roleSiswa,
            'name' => 'Ahmad Rizky',
            'email' => 'siswa1@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        $siswa1 = Siswa::create([
            'user_id' => $siswaUser1->id,
            'kelas_id' => $kelas1->id,
            'nis' => '1001',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
        ]);

        // Siswa 2
        $siswaUser2 = User::create([
            'role_id' => $roleSiswa,
            'name' => 'Dewi Lestari',
            'email' => 'siswa2@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        $siswa2 = Siswa::create([
            'user_id' => $siswaUser2->id,
            'kelas_id' => $kelas1->id,
            'nis' => '1002',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Mawar No. 4, Jakarta',
        ]);

        // Siswa 3
        $siswaUser3 = User::create([
            'role_id' => $roleSiswa,
            'name' => 'Fajar Nugraha',
            'email' => 'siswa3@sekolah.sch.id',
            'password' => Hash::make('password'),
        ]);
        $siswa3 = Siswa::create([
            'user_id' => $siswaUser3->id,
            'kelas_id' => $kelas2->id,
            'nis' => '1003',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Pemuda No. 12, Jakarta',
        ]);

        // Nilai
        Nilai::create([
            'siswa_id' => $siswa1->id,
            'guru_id' => $guru1->id,
            'semester' => 1,
            'tahun_ajaran' => '2025/2026',
            'jenis_nilai' => 'tugas',
            'nilai' => 88.50,
            'keterangan' => 'Tugas Aljabar 1',
        ]);

        Nilai::create([
            'siswa_id' => $siswa1->id,
            'guru_id' => $guru1->id,
            'semester' => 1,
            'tahun_ajaran' => '2025/2026',
            'jenis_nilai' => 'uts',
            'nilai' => 90.00,
            'keterangan' => 'UTS Matematika Semester Ganjil',
        ]);

        Nilai::create([
            'siswa_id' => $siswa2->id,
            'guru_id' => $guru2->id,
            'semester' => 1,
            'tahun_ajaran' => '2025/2026',
            'jenis_nilai' => 'tugas',
            'nilai' => 85.00,
            'keterangan' => 'Tugas Ejaan Bahasa Indonesia',
        ]);

        // Pengajuan
        Pengajuan::create([
            'siswa_id' => $siswa1->id,
            'guru_id' => null,
            'jenis_pengajuan' => 'Surat Keterangan Aktif Siswa',
            'keterangan' => 'Persyaratan pengajuan beasiswa daerah.',
            'status' => 'menunggu',
            'catatan_guru' => null,
            'tanggal_pengajuan' => now()->toDateString(),
            'tanggal_diproses' => null,
        ]);

        Pengajuan::create([
            'siswa_id' => $siswa2->id,
            'guru_id' => $guru1->id,
            'jenis_pengajuan' => 'Surat Izin Dispensasi Lomba',
            'keterangan' => 'Mengikuti Olimpiade Matematika tingkat provinsi.',
            'status' => 'disetujui',
            'catatan_guru' => 'Disetujui. Selamat berjuang!',
            'tanggal_pengajuan' => now()->subDays(2)->toDateString(),
            'tanggal_diproses' => now()->subDay()->toDateString(),
        ]);
    }
}
