<x-app-layout>
    <x-slot name="header">
        Manajemen Akun Guru
    </x-slot>

    <x-card class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Daftar Tenaga Pendidik / Guru</h3>
                <p class="text-xs text-navy-700">Kelola akun guru dan mata pelajaran yang diampu.</p>
            </div>
            @can('create', App\Models\Guru::class)
                <x-button variant="primary" href="{{ route('guru.create') }}">
                    + Tambah Akun Guru
                </x-button>
            @endcan
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('guru.index') }}" class="mb-6">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, mapel..." class="w-full sm:w-80 text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                <x-button type="submit" variant="primary">Cari</x-button>
                @if(request('search'))
                    <x-button variant="ghost" href="{{ route('guru.index') }}">Reset</x-button>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
            <table class="w-full text-left text-sm">
                <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">NIP</th>
                        <th class="px-4 py-3">Nama Guru</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Wali Kelas</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($gurus as $g)
                        <tr class="hover:bg-navy-100 ">
                            <td class="px-4 py-3 font-mono text-xs font-semibold">{{ $g->nip }}</td>
                            <td class="px-4 py-3 font-medium">{{ $g->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-navy-700 font-medium">{{ $g->mapel }}</td>
                            <td class="px-4 py-3 text-navy-700">{{ $g->kelas->nama_kelas ?? 'Bukan Wali Kelas' }}</td>
                            <td class="px-4 py-3 text-navy-700 text-xs">{{ $g->user->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-right space-x-1">
                                <x-button variant="ghost" href="{{ route('guru.show', $g->id) }}" class="text-xs py-1 px-2">
                                    Detail
                                </x-button>
                                @can('update', $g)
                                    <x-button variant="ghost" href="{{ route('guru.edit', $g->id) }}" class="text-xs py-1 px-2">
                                        Edit
                                    </x-button>
                                @endcan
                                @can('delete', $g)
                                    <x-confirm-modal
                                        :form-id="'delete-guru-'.$g->id"
                                        :action="route('guru.destroy', $g->id)"
                                        title="Hapus Data Guru?"
                                        message="Yakin ingin menghapus guru ini? Data tidak dapat dikembalikan."
                                        class="text-xs py-1 px-2"
                                    >Hapus</x-confirm-modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-navy-700">Data guru belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $gurus->links() }}
        </div>
    </x-card>
</x-app-layout>
