<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        Gate::authorize('viewAny', Kelas::class);

        $user = $request->user();

        if ($user->isGuru()) {
            // Guru only sees their own class perwalian
            $guruId = $user->guru?->id;

            if ($guruId === null || $user->guru->kelas === null) {
                return redirect()->route('dashboard')->with('info', 'Anda belum ditugaskan sebagai wali kelas manapun.');
            }

            $kelases = Kelas::with(['waliKelas.user', 'siswa.user'])
                ->where('wali_kelas_id', $guruId)
                ->paginate(10);
        } else {
            // Admin sees all classes
            $kelases = Kelas::with(['waliKelas.user', 'siswa.user'])
                ->latest('id')
                ->paginate(10);
        }

        return view('kelas.index', compact('kelases'));
    }

    public function create(): View
    {
        Gate::authorize('create', Kelas::class);

        $gurus = Guru::with('user')->get();

        return view('kelas.create', compact('gurus'));
    }

    public function store(StoreKelasRequest $request): RedirectResponse
    {
        Gate::authorize('create', Kelas::class);

        Kelas::create($request->validated());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela): View
    {
        Gate::authorize('view', $kela);

        $kela->load(['waliKelas.user', 'siswa.user']);

        return view('kelas.show', ['kelas' => $kela]);
    }

    public function edit(Kelas $kela): View
    {
        Gate::authorize('update', $kela);

        $gurus = Guru::with('user')->get();

        return view('kelas.edit', ['kelas' => $kela, 'gurus' => $gurus]);
    }

    public function update(UpdateKelasRequest $request, Kelas $kela): RedirectResponse
    {
        Gate::authorize('update', $kela);

        $kela->update($request->validated());

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela): RedirectResponse
    {
        Gate::authorize('delete', $kela);

        $kela->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
