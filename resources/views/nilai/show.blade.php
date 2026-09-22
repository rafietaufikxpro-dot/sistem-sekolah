<x-app-layout>
    <x-slot name="header">
        Detail Nilai Akademik
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Informasi Nilai</h3>
                <x-button variant="ghost" href="{{ route('nilai.index') }}" class="text-xs">
                    &larr; Kembali
                </x-button>
            </div>

            <div class="space-y-4 text-sm divide-y divide-[var(--border)]">
                <div class="pt-2">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Siswa</span>
                    <span class="font-medium text-base text-navy-900 ">{{ $nilai->siswa->user->name ?? '-' }}</span>
                    <span class="text-xs text-navy-700 block">NIS: {{ $nilai->siswa->nis }} | Kelas: {{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</span>
                </div>

                <div class="pt-3 grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Mata Pelajaran</span>
                        <span class="font-medium text-navy-700 ">{{ $nilai->guru->mapel ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Guru Pengajar</span>
                        <span>{{ $nilai->guru->user->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="pt-3 grid grid-cols-3 gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Tahun Ajaran</span>
                        <span>{{ $nilai->tahun_ajaran }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Semester</span>
                        <span>Sem {{ $nilai->semester }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Jenis Nilai</span>
                        <span class="uppercase font-semibold text-xs text-ink-700 ">{{ $nilai->jenis_nilai }}</span>
                    </div>
                </div>

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Nilai Perolehan</span>
                    <span class="font-mono text-3xl font-bold text-navy-700 ">{{ $nilai->nilai }}</span>
                </div>

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Keterangan</span>
                    <p class="text-ink-700  mt-1">{{ $nilai->keterangan ?? 'Tidak ada keterangan.' }}</p>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
