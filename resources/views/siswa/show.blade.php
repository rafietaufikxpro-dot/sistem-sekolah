<x-app-layout>
    <x-slot name="header">
        Detail Siswa: {{ $siswa->user->name ?? '-' }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <x-card>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div>
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->user->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-navy-700">
                    @else
                        <div class="w-24 h-24 rounded-full bg-navy-100  text-navy-700  flex items-center justify-center font-serif font-bold text-2xl border-2 border-navy-700">
                            {{ strtoupper(substr($siswa->user->name ?? 'S', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-3 w-full">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif text-xl font-semibold text-navy-900 ">{{ $siswa->user->name ?? '-' }}</h3>
                        <x-button variant="ghost" href="{{ route('siswa.index') }}" class="text-xs">
                            &larr; Kembali
                        </x-button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs font-semibold uppercase text-navy-700 block">NIS</span>
                            <span class="font-mono font-medium">{{ $siswa->nis }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-navy-700 block">Email</span>
                            <span>{{ $siswa->user->email ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-navy-700 block">Kelas</span>
                            <span>{{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }} ({{ $siswa->kelas->jurusan ?? '-' }})</span>
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase text-navy-700 block">Jenis Kelamin</span>
                            <span>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-xs font-semibold uppercase text-navy-700 block">Alamat</span>
                            <span>{{ $siswa->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Riwayat Nilai Akademik Siswa -->
        <x-card>
            <h4 class="font-serif text-base font-semibold mb-3 text-navy-900 ">Nilai Akademik Siswa</h4>
            <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-navy-100  text-navy-700 font-semibold text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2.5">Mapel / Guru</th>
                            <th class="px-4 py-2.5">Tahun Ajaran</th>
                            <th class="px-4 py-2.5">Semester</th>
                            <th class="px-4 py-2.5">Jenis</th>
                            <th class="px-4 py-2.5">Nilai</th>
                            <th class="px-4 py-2.5">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @forelse($siswa->nilai as $n)
                            <tr class="hover:bg-navy-100 ">
                                <td class="px-4 py-2 font-medium">
                                    {{ $n->guru->mapel ?? '-' }}
                                    <span class="block text-xs text-navy-700">Guru: {{ $n->guru->user->name ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-2 text-navy-700">{{ $n->tahun_ajaran }}</td>
                                <td class="px-4 py-2 text-navy-700">Sem {{ $n->semester }}</td>
                                <td class="px-4 py-2 uppercase font-semibold text-xs text-ink-700 ">{{ $n->jenis_nilai }}</td>
                                <td class="px-4 py-2 font-mono font-bold text-navy-700 ">{{ $n->nilai }}</td>
                                <td class="px-4 py-2 text-navy-700 text-xs">{{ $n->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-3 text-center text-navy-700">Belum ada data nilai akademik.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
