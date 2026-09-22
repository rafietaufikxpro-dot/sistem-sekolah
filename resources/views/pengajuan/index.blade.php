<x-app-layout>
    <x-slot name="header">
        Pengajuan Administrasi
    </x-slot>

    <x-card class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Daftar Pengajuan Administrasi</h3>
                <p class="text-xs text-navy-700">
                    @if(Auth::user()->isSiswa())
                        Buat dan pantai riwayat pengajuan surat atau izin Anda.
                    @elseif(Auth::user()->isGuru())
                        Daftar pengajuan masuk dari siswa untuk distujui/ditolak.
                    @else
                        Moderasi seluruh pengajuan administrasi siswa.
                    @endif
                </p>
            </div>

            @can('create', App\Models\Pengajuan::class)
                <x-button variant="primary" href="{{ route('pengajuan.create') }}">
                    + Buat Pengajuan Baru
                </x-button>
            @endcan
        </div>

        <!-- Filter Form: Search/filter by status, jenis, or siswa -->
        <form method="GET" action="{{ route('pengajuan.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Cari Kata Kunci / Siswa</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis, nama siswa..." class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Filter Status</label>
                <select name="status" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Pengajuan</label>
                <input type="text" name="jenis_pengajuan" value="{{ request('jenis_pengajuan') }}" placeholder="Filter jenis pengajuan..." class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
            </div>

            <div class="flex items-end space-x-2">
                <x-button type="submit" variant="primary" class="w-full">Filter</x-button>
                @if(request()->anyFilled(['search', 'status', 'jenis_pengajuan']))
                    <x-button variant="ghost" href="{{ route('pengajuan.index') }}">Reset</x-button>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
            <table class="w-full text-left text-sm">
                <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">Siswa Pemohon</th>
                        <th class="px-4 py-3">Jenis Pengajuan</th>
                        <th class="px-4 py-3">Tgl Pengajuan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Diproses Oleh</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($pengajuans as $p)
                        <tr class="hover:bg-navy-100 ">
                            <td class="px-4 py-3 font-medium">
                                {{ $p->siswa->user->name ?? '-' }}
                                <span class="block text-xs text-navy-700">NIS: {{ $p->siswa->nis ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 text-navy-900  font-medium">{{ $p->jenis_pengajuan }}</td>
                            <td class="px-4 py-3 text-navy-700 text-xs">{{ $p->tanggal_pengajuan->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <x-badge :status="$p->status" />
                            </td>
                            <td class="px-4 py-3 text-navy-700 text-xs">
                                {{ $p->guru->user->name ?? ($p->status !== 'menunggu' ? 'Admin' : '-') }}
                            </td>
                            <td class="px-4 py-3 text-right space-x-1">
                                <x-button variant="ghost" href="{{ route('pengajuan.show', $p->id) }}" class="text-xs py-1 px-2">
                                    Detail
                                </x-button>

                                @can('review', $p)
                                    @if($p->status === 'menunggu' || Auth::user()->isAdmin())
                                        <x-button variant="primary" href="{{ route('pengajuan.review', $p->id) }}" class="text-xs py-1 px-2">
                                            Proses
                                        </x-button>
                                    @endif
                                @endcan

                                @can('update', $p)
                                    <x-button variant="ghost" href="{{ route('pengajuan.edit', $p->id) }}" class="text-xs py-1 px-2">
                                        Edit
                                    </x-button>
                                @endcan

                                @can('delete', $p)
                                    <x-confirm-modal
                                        :form-id="'delete-pengajuan-'.$p->id"
                                        :action="route('pengajuan.destroy', $p->id)"
                                        title="Hapus Pengajuan?"
                                        message="Yakin ingin menghapus pengajuan ini? Data tidak dapat dikembalikan."
                                        class="text-xs py-1 px-2"
                                    >Hapus</x-confirm-modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-navy-700">Belum ada data pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pengajuans->links() }}
        </div>
    </x-card>
</x-app-layout>
