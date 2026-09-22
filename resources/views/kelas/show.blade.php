<x-app-layout>
    <x-slot name="header">
        Detail Kelas: {{ $kelas->nama_kelas }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-serif text-xl font-semibold text-navy-900 ">{{ $kelas->nama_kelas }}</h3>
                    <p class="text-xs text-navy-700">Jurusan: {{ $kelas->jurusan }}</p>
                </div>
                <x-button variant="ghost" href="{{ route('kelas.index') }}" class="text-xs">
                    &larr; Kembali
                </x-button>
            </div>

            <div class="p-4 rounded-lg bg-navy-100  text-sm">
                <span class="text-xs font-semibold uppercase text-navy-700 block">Wali Kelas</span>
                <span class="font-medium text-navy-700 ">
                    {{ $kelas->waliKelas->user->name ?? 'Belum ditentukan' }}
                </span>
                @if($kelas->waliKelas)
                    <span class="text-xs text-navy-700 block">NIP: {{ $kelas->waliKelas->nip }} | Mapel: {{ $kelas->waliKelas->mapel }}</span>
                @endif
            </div>
        </x-card>

        <x-card>
            <h4 class="font-serif text-base font-semibold mb-3 text-navy-900 ">Daftar Siswa di Kelas Ini</h4>
            <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2.5">NIS</th>
                            <th class="px-4 py-2.5">Nama Siswa</th>
                            <th class="px-4 py-2.5">Gender</th>
                            <th class="px-4 py-2.5">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @forelse($kelas->siswa as $s)
                            <tr class="hover:bg-navy-100 ">
                                <td class="px-4 py-2 font-mono text-xs font-semibold">{{ $s->nis }}</td>
                                <td class="px-4 py-2 font-medium">{{ $s->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-navy-700">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="px-4 py-2 text-navy-700 text-xs">{{ $s->user->email ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-3 text-center text-navy-700">Belum ada siswa terdaftar di kelas ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
