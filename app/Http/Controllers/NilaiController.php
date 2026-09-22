<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class NilaiController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Nilai::class);

        $user = $request->user();
        $query = Nilai::with(['siswa.user', 'siswa.kelas', 'guru.user']);

        if ($user->isSiswa()) {
            $siswaId = $user->siswa?->id;
            $query->where('siswa_id', $siswaId);
        }

        if ($request->filled('jenis_nilai')) {
            $query->where('jenis_nilai', $request->input('jenis_nilai'));
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->input('semester'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('siswa.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $nilais = $query->latest('id')->paginate(10)->withQueryString();

        return view('nilai.index', compact('nilais'));
    }

    public function create(): View
    {
        Gate::authorize('create', Nilai::class);

        $siswas = Siswa::with(['user', 'kelas'])->get();

        return view('nilai.create', compact('siswas'));
    }

    public function store(StoreNilaiRequest $request): RedirectResponse
    {
        Gate::authorize('create', Nilai::class);

        $validated = $request->validated();
        $guruId = $request->user()->guru?->id;

        if ($guruId === null) {
            abort(403, 'Hanya guru yang dapat menginput nilai akademik.');
        }

        Nilai::create(array_merge($validated, [
            'guru_id' => $guruId,
        ]));

        return redirect()->route('nilai.index')->with('success', 'Nilai akademik berhasil ditambahkan.');
    }

    public function show(Nilai $nilai): View
    {
        Gate::authorize('view', $nilai);

        $nilai->load(['siswa.user', 'siswa.kelas', 'guru.user']);

        return view('nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai): View
    {
        Gate::authorize('update', $nilai);

        $nilai->load(['siswa.user', 'siswa.kelas']);

        return view('nilai.edit', compact('nilai'));
    }

    public function update(UpdateNilaiRequest $request, Nilai $nilai): RedirectResponse
    {
        Gate::authorize('update', $nilai);

        $nilai->update($request->validated());

        return redirect()->route('nilai.index')->with('success', 'Nilai akademik berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai): RedirectResponse
    {
        Gate::authorize('delete', $nilai);

        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai akademik berhasil dihapus.');
    }
}
