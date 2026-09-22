<x-app-layout>
    <x-slot name="header">
        Data Siswa
    </x-slot>

    <x-card class="mb-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-serif text-lg font-semibold text-navy-900">Daftar Siswa</h3>
                <p class="text-xs text-navy-700">Kelola dan temukan data siswa terdaftar.</p>
            </div>
            @can('create', App\Models\Siswa::class)
                <x-button variant="primary" href="{{ route('siswa.create') }}">
                    + Tambah Siswa
                </x-button>
            @endcan
        </div>

        <!-- Combined Search & Filters -->
        <form method="GET" action="{{ route('siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Cari Nama / NIS</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NIS..." class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)] focus:ring-navy-600 focus:border-navy-600">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Filter Kelas</label>
                <select name="kelas_id" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)] focus:ring-navy-600 focus:border-navy-600">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} ({{ $k->jurusan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Filter Gender</label>
                <select name="jenis_kelamin" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)] focus:ring-navy-600 focus:border-navy-600">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <x-button type="submit" variant="primary" class="w-full">
                    Filter & Cari
                </x-button>
                @if(request()->anyFilled(['search', 'kelas_id', 'jenis_kelamin']))
                    <x-button variant="ghost" href="{{ route('siswa.index') }}" title="Reset Filter">
                        Reset
                    </x-button>
                @endif
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
            <table class="w-full text-left text-sm">
                <thead class="bg-navy-100 text-navy-900 font-semibold text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">NIS</th>
                        <th class="px-4 py-3">Nama Lengkap</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Gender</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($siswas as $s)
                        <tr>
                            <td class="px-4 py-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-navy-100 text-navy-700 flex items-center justify-center font-semibold text-xs">
                                        {{ strtoupper(substr($s->user->name ?? 'S', 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono text-xs font-semibold text-navy-700">{{ $s->nis }}</td>
                            <td class="px-4 py-3 font-medium text-navy-900">{{ $s->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-navy-700">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-navy-700">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-4 py-3 text-navy-700 text-xs">{{ $s->user->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-right space-x-1">
                                <x-button variant="ghost" href="{{ route('siswa.show', $s->id) }}" class="text-xs py-1 px-2">
                                    Detail
                                </x-button>
                                @can('update', $s)
                                    <x-button variant="ghost" href="{{ route('siswa.edit', $s->id) }}" class="text-xs py-1 px-2">
                                        Edit
                                    </x-button>
                                @endcan
                                @can('delete', $s)
                                    <x-confirm-modal
                                        :form-id="'delete-siswa-'.$s->id"
                                        :action="route('siswa.destroy', $s->id)"
                                        title="Hapus Data Siswa?"
                                        message="Yakin ingin menghapus siswa ini? Data tidak dapat dikembalikan."
                                        class="text-xs py-1 px-2"
                                    >Hapus</x-confirm-modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-navy-700">Data siswa tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $siswas->links() }}
        </div>
    </x-card>
</x-app-layout>
