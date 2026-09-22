<x-app-layout>
    <x-slot name="header">
        Detail Guru: {{ $guru->user->name ?? '-' }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-xl font-semibold text-navy-900 ">{{ $guru->user->name ?? '-' }}</h3>
                <x-button variant="ghost" href="{{ route('guru.index') }}" class="text-xs">
                    &larr; Kembali
                </x-button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs font-semibold uppercase text-navy-700 block">NIP</span>
                    <span class="font-mono font-medium">{{ $guru->nip }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Email</span>
                    <span>{{ $guru->user->email ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Mata Pelajaran Utama</span>
                    <span class="font-medium text-navy-700 ">{{ $guru->mapel }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Wali Kelas</span>
                    <span>{{ $guru->kelas->nama_kelas ?? 'Bukan wali kelas' }}</span>
                </div>
            </div>
        </x-card>

        @if($guru->kelas)
            <x-card>
                <h4 class="font-serif text-base font-semibold mb-3 text-navy-900 ">Daftar Siswa Perwalian ({{ $guru->kelas->nama_kelas }})</h4>
                <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2.5">NIS</th>
                                <th class="px-4 py-2.5">Nama Siswa</th>
                                <th class="px-4 py-2.5">Gender</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--border)]">
                            @forelse($guru->kelas->siswa as $s)
                                <tr class="hover:bg-navy-100 ">
                                    <td class="px-4 py-2 font-mono text-xs font-semibold">{{ $s->nis }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $s->user->name ?? '-' }}</td>
                                    <td class="px-4 py-2 text-navy-700">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-4 py-3 text-center text-navy-700">Belum ada siswa terdaftar di kelas perwalian ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endif
    </div>
</x-app-layout>
