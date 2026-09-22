<x-app-layout>
    <x-slot name="header">
        Data Kelas
    </x-slot>

    <x-card class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Daftar Kelas</h3>
                <p class="text-xs text-navy-700">
                    @if(Auth::user()->isGuru())
                        Daftar kelas perwalian yang Anda ampu (Read-Only).
                    @else
                        Kelola data kelas dan penugasan wali kelas.
                    @endif
                </p>
            </div>
            @can('create', App\Models\Kelas::class)
                <x-button variant="primary" href="{{ route('kelas.create') }}">
                    + Tambah Kelas
                </x-button>
            @endcan
        </div>

        <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
            <table class="w-full text-left text-sm">
                <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">Nama Kelas</th>
                        <th class="px-4 py-3">Jurusan</th>
                        <th class="px-4 py-3">Wali Kelas</th>
                        <th class="px-4 py-3">Jumlah Siswa</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($kelases as $k)
                        <tr class="hover:bg-navy-100 ">
                            <td class="px-4 py-3 font-semibold text-navy-900 ">{{ $k->nama_kelas }}</td>
                            <td class="px-4 py-3 text-navy-700">{{ $k->jurusan }}</td>
                            <td class="px-4 py-3 font-medium">{{ $k->waliKelas->user->name ?? 'Belum ada wali kelas' }}</td>
                            <td class="px-4 py-3 text-navy-700 font-mono">{{ $k->siswa->count() }} Siswa</td>
                            <td class="px-4 py-3 text-right space-x-1">
                                <x-button variant="ghost" href="{{ route('kelas.show', $k->id) }}" class="text-xs py-1 px-2">
                                    Detail
                                </x-button>
                                @can('update', $k)
                                    <x-button variant="ghost" href="{{ route('kelas.edit', $k->id) }}" class="text-xs py-1 px-2">
                                        Edit
                                    </x-button>
                                @endcan
                                @can('delete', $k)
                                    <x-confirm-modal
                                        :form-id="'delete-kelas-'.$k->id"
                                        :action="route('kelas.destroy', $k->id)"
                                        title="Hapus Data Kelas?"
                                        message="Yakin ingin menghapus kelas ini? Data tidak dapat dikembalikan."
                                        class="text-xs py-1 px-2"
                                    >Hapus</x-confirm-modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-navy-700">Tidak ada data kelas yang dapat ditampilkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $kelases->links() }}
        </div>
    </x-card>
</x-app-layout>
