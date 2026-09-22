<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Pengajuan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SistemSekolahAuthAndPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_cannot_create_or_update_grades(): void
    {
        $adminUser = User::whereHas('role', fn ($q) => $q->where('name_role', 'admin'))->first();
        $siswa = Siswa::first();

        // Admin attempting to create grade should be forbidden 403
        $response = $this->actingAs($adminUser)->post(route('nilai.store'), [
            'siswa_id' => $siswa->id,
            'semester' => 1,
            'tahun_ajaran' => '2025/2026',
            'jenis_nilai' => 'tugas',
            'nilai' => 95,
        ]);

        $response->assertStatus(403);
    }

    public function test_guru_is_read_only_on_kelas(): void
    {
        $guruUser = User::whereHas('role', fn ($q) => $q->where('name_role', 'guru'))->first();

        // Guru trying to create a class should be forbidden 403
        $response = $this->actingAs($guruUser)->post(route('kelas.store'), [
            'nama_kelas' => 'XII IPA 3',
            'jurusan' => 'MIPA',
        ]);

        $response->assertStatus(403);
    }

    public function test_siswa_is_blocked_from_reviewing_pengajuan(): void
    {
        $siswaUser = User::whereHas('role', fn ($q) => $q->where('name_role', 'siswa'))->first();
        $pengajuan = Pengajuan::first();

        // Siswa accessing review form or process endpoint should get 403
        $response = $this->actingAs($siswaUser)->get(route('pengajuan.review', $pengajuan->id));
        $response->assertStatus(403);

        $responseProcess = $this->actingAs($siswaUser)->post(route('pengajuan.process', $pengajuan->id), [
            'status' => 'disetujui',
            'catatan_guru' => 'Coba setujui sendiri',
        ]);
        $responseProcess->assertStatus(403);
    }

    public function test_siswa_self_registration_assigns_siswa_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siswa Baru',
            'email' => 'siswabaru@sekolah.sch.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nis' => '9999',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Kebon Jeruk',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'siswabaru@sekolah.sch.id']);

        $user = User::where('email', 'siswabaru@sekolah.sch.id')->first();
        $this->assertTrue($user->isSiswa());
        $this->assertNotNull($user->siswa);
        $this->assertEquals('9999', $user->siswa->nis);
    }

    public function test_siswa_search_and_filter_work_together(): void
    {
        $adminUser = User::whereHas('role', fn ($q) => $q->where('name_role', 'admin'))->first();
        $kelas = Kelas::first();

        $response = $this->actingAs($adminUser)->get(route('siswa.index', [
            'search' => 'Ahmad',
            'kelas_id' => $kelas->id,
            'jenis_kelamin' => 'L',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Ahmad Rizky');
    }
}
