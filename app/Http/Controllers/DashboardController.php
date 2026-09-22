<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengajuan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $totalSiswa = Siswa::count();
            $totalGuru = Guru::count();

            // Combined list of guru & siswa
            $gurus = Guru::with(['user', 'kelas'])->latest('id')->get();
            $siswas = Siswa::with(['user', 'kelas'])->latest('id')->get();

            return view('dashboard', compact('totalSiswa', 'totalGuru', 'gurus', 'siswas'));
        }

        if ($user->isGuru()) {
            $guru = $user->guru;
            $kelasWali = $guru?->kelas;
            $totalSiswaWali = $kelasWali ? $kelasWali->siswa()->count() : 0;
            $pengajuanMasuk = $kelasWali
                ? Pengajuan::with(['siswa.user'])
                    ->where('status', 'menunggu')
                    ->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasWali->id))
                    ->latest()
                    ->take(5)
                    ->get()
                : collect();

            return view('dashboard', compact('guru', 'kelasWali', 'totalSiswaWali', 'pengajuanMasuk'));
        }

        // Siswa
        $siswa = $user->siswa;
        $nilaiCount = $siswa?->nilai()->count() ?? 0;
        $pengajuanCount = $siswa?->pengajuan()->count() ?? 0;
        $pengajuanTerbaru = $siswa?->pengajuan()->latest()->take(5)->get() ?? collect();

        return view('dashboard', compact('siswa', 'nilaiCount', 'pengajuanCount', 'pengajuanTerbaru'));
    }
}
