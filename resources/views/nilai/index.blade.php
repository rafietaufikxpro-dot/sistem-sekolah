<x-app-layout>
    <x-slot name="header">
        Nilai Akademik
    </x-slot>

    <x-card class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Daftar Nilai Akademik</h3>
                <p class="text-xs text-navy-700">
                    @if(Auth::user()->isAdmin())
                        Monitoring Nilai Siswa (Read-Only untuk Admin).
                    @elseif(Auth::user()->isSiswa())
                        Nilai Akademik Terdaftar Anda (Read-Only).
                    @else
                        Kelola dan input nilai tugas, UTS, dan UAS siswa.
                    @endif
                </p>
            </div>

            @can('create', App\Models\Nilai::class)
                <x-button variant="primary" href="{{ route('nilai.create') }}">
                    + Input Nilai Baru
                </x-button>
            @endcan
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('nilai.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Cari Nama Siswa</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Nilai</label>
                <select name="jenis_nilai" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="">Semua Jenis</option>
                    <option value="tugas" {{ request('jenis_nilai') === 'tugas' ? 'selected' : '' }}>Tugas</option>
                    <option value="uts" {{ request('jenis_nilai') === 'uts' ? 'selected' : '' }}>UTS</option>
                    <option value="uas" {{ request('jenis_nilai') === 'uas' ? 'selected' : '' }}>UAS</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Semester</label>
                <select name="semester" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="">Semua Semester</option>
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <x-button type="submit" variant="primary" class="w-full">Filter</x-button>
                @if(request()->anyFilled(['search', 'jenis_nilai', 'semester']))
                    <x-button variant="ghost" href="{{ route('nilai.index') }}">Reset</x-button>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
            <table class="w-full text-left text-sm">
                <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Guru / Mapel</th>
                        <th class="px-4 py-3">Tahun / Sem</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Nilai</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($nilais as $n)
                        <tr class="hover:bg-navy-100 ">
                            <td class="px-4 py-3 font-medium">{{ $n->siswa->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-navy-700">{{ $n->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-navy-700">
                                <span class="font-medium text-navy-900 ">{{ $n->guru->mapel ?? '-' }}</span>
                                <span class="block text-xs">By: {{ $n->guru->user->name ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 text-navy-700 text-xs">{{ $n->tahun_ajaran }} (Sem {{ $n->semester }})</td>
                            <td class="px-4 py-3 uppercase text-xs font-semibold text-ink-700 ">{{ $n->jenis_nilai }}</td>
                            <td class="px-4 py-3 font-mono font-bold text-navy-700  text-base">{{ $n->nilai }}</td>
                            <td class="px-4 py-3 text-right space-x-1">
                                <x-button variant="ghost" href="{{ route('nilai.show', $n->id) }}" class="text-xs py-1 px-2">
                                    Detail
                                </x-button>

                                {{-- Notice: Admin policy returns false for update/delete, so @can will hide edit/delete for Admin --}}
                                @can('update', $n)
                                    <x-button variant="ghost" href="{{ route('nilai.edit', $n->id) }}" class="text-xs py-1 px-2">
                                        Edit
                                    </x-button>
                                @endcan
                                @can('delete', $n)
                                    <x-confirm-modal
                                        :form-id="'delete-nilai-'.$n->id"
                                        :action="route('nilai.destroy', $n->id)"
                                        title="Hapus Data Nilai?"
                                        message="Yakin ingin menghapus nilai ini? Data tidak dapat dikembalikan."
                                        class="text-xs py-1 px-2"
                                    >Hapus</x-confirm-modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-navy-700">Belum ada data nilai akademik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $nilais->links() }}
        </div>
    </x-card>
</x-app-layout>
