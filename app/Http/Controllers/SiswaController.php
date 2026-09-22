<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Siswa::class);

        $query = Siswa::with(['user', 'kelas']);

        // Search & Filter working TOGETHER
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->input('kelas_id'));
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        $siswas = $query->latest('id')->paginate(10)->withQueryString();
        $kelases = Kelas::all();

        return view('siswa.index', compact('siswas', 'kelases'));
    }

    public function create(): View
    {
        Gate::authorize('create', Siswa::class);

        $kelases = Kelas::all();

        return view('siswa.create', compact('kelases'));
    }

    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        Gate::authorize('create', Siswa::class);

        $validated = $request->validated();

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('siswa-foto', 'public');
        }

        DB::transaction(function () use ($validated, $fotoPath) {
            $roleSiswa = Role::where('name_role', 'siswa')->first()->id;

            $user = User::create([
                'role_id' => $roleSiswa,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $validated['kelas_id'] ?? null,
                'nis' => $validated['nis'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'foto' => $fotoPath,
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa): View
    {
        Gate::authorize('view', $siswa);

        $siswa->load(['user', 'kelas', 'nilai.guru.user', 'pengajuan']);

        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        Gate::authorize('update', $siswa);

        $siswa->load(['user', 'kelas']);
        $kelases = Kelas::all();

        return view('siswa.edit', compact('siswa', 'kelases'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        Gate::authorize('update', $siswa);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $siswa) {
            $user = $siswa->user;
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $siswa->foto = $request->file('foto')->store('siswa-foto', 'public');
            }

            $siswa->update([
                'kelas_id' => $validated['kelas_id'] ?? null,
                'nis' => $validated['nis'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        Gate::authorize('delete', $siswa);

        DB::transaction(function () use ($siswa) {
            $user = $siswa->user;

            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $siswa->delete();
            $user?->delete();
        });

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
