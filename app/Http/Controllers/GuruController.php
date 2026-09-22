<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Guru::class);

        $query = Guru::with(['user', 'kelas']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('mapel', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $gurus = $query->latest('id')->paginate(10)->withQueryString();

        return view('guru.index', compact('gurus'));
    }

    public function create(): View
    {
        Gate::authorize('create', Guru::class);

        return view('guru.create');
    }

    public function store(StoreGuruRequest $request): RedirectResponse
    {
        Gate::authorize('create', Guru::class);

        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $roleGuru = Role::where('name_role', 'guru')->first()->id;

            $user = User::create([
                'role_id' => $roleGuru,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'mapel' => $validated['mapel'],
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Akun guru berhasil dibuat.');
    }

    public function show(Guru $guru): View
    {
        Gate::authorize('view', $guru);

        $guru->load(['user', 'kelas.siswa.user']);

        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru): View
    {
        Gate::authorize('update', $guru);

        $guru->load(['user']);

        return view('guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        Gate::authorize('update', $guru);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $guru) {
            $user = $guru->user;
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            $guru->update([
                'nip' => $validated['nip'],
                'mapel' => $validated['mapel'],
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        Gate::authorize('delete', $guru);

        DB::transaction(function () use ($guru) {
            $user = $guru->user;
            $guru->delete();
            $user?->delete();
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
