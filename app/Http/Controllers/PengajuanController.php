<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewPengajuanRequest;
use App\Http\Requests\StorePengajuanRequest;
use App\Http\Requests\UpdatePengajuanRequest;
use App\Models\Pengajuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Pengajuan::class);

        $user = $request->user();
        $query = Pengajuan::with(['siswa.user', 'guru.user']);

        if ($user->isSiswa()) {
            $siswaId = $user->siswa?->id;
            $query->where('siswa_id', $siswaId);
        }

        // Search & Filters
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('jenis_pengajuan')) {
            $query->where('jenis_pengajuan', 'like', '%'.$request->input('jenis_pengajuan').'%');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pengajuan', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('siswa.user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $pengajuans = $query->latest('id')->paginate(10)->withQueryString();

        return view('pengajuan.index', compact('pengajuans'));
    }

    public function create(): View
    {
        Gate::authorize('create', Pengajuan::class);

        return view('pengajuan.create');
    }

    public function store(StorePengajuanRequest $request): RedirectResponse
    {
        Gate::authorize('create', Pengajuan::class);

        $validated = $request->validated();
        $siswa = $request->user()->siswa;

        if (! $siswa) {
            abort(403, 'Hanya profil siswa terdaftar yang dapat membuat pengajuan.');
        }

        $lampiranPath = null;
        if ($request->hasFile('file_lampiran')) {
            $lampiranPath = $request->file('file_lampiran')->store('lampiran-pengajuan', 'public');
        }

        Pengajuan::create([
            'siswa_id' => $siswa->id,
            'guru_id' => null,
            'jenis_pengajuan' => $validated['jenis_pengajuan'],
            'keterangan' => $validated['keterangan'],
            'status' => 'menunggu',
            'tanggal_pengajuan' => now()->toDateString(),
            'file_lampiran' => $lampiranPath,
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan administrasi berhasil dikirim.');
    }

    public function show(Pengajuan $pengajuan): View
    {
        Gate::authorize('view', $pengajuan);

        $pengajuan->load(['siswa.user', 'siswa.kelas', 'guru.user']);

        return view('pengajuan.show', compact('pengajuan'));
    }

    public function reviewForm(Pengajuan $pengajuan): View
    {
        Gate::authorize('review', $pengajuan);

        $pengajuan->load(['siswa.user', 'siswa.kelas']);

        return view('pengajuan.review', compact('pengajuan'));
    }

    public function processReview(ReviewPengajuanRequest $request, Pengajuan $pengajuan): RedirectResponse
    {
        Gate::authorize('review', $pengajuan);

        $validated = $request->validated();
        $guruId = $request->user()->guru?->id;

        $pengajuan->update([
            'status' => $validated['status'],
            'catatan_guru' => $validated['catatan_guru'] ?? null,
            'guru_id' => $guruId,
            'tanggal_diproses' => now()->toDateString(),
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diproses.');
    }

    public function edit(Pengajuan $pengajuan): View
    {
        Gate::authorize('update', $pengajuan);

        $pengajuan->load(['siswa.user']);

        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $pengajuan): RedirectResponse
    {
        Gate::authorize('update', $pengajuan);

        $pengajuan->update($request->validated());

        return redirect()->route('pengajuan.index')->with('success', 'Data pengajuan berhasil diperbarui (moderasi).');
    }

    public function destroy(Pengajuan $pengajuan): RedirectResponse
    {
        Gate::authorize('delete', $pengajuan);

        if ($pengajuan->file_lampiran) {
            Storage::disk('public')->delete($pengajuan->file_lampiran);
        }

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
