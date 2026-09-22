<x-app-layout>
    <x-slot name="header">
        Detail Pengajuan Administrasi
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-lg font-semibold text-navy-900 ">Detail Pengajuan</h3>
                <x-button variant="ghost" href="{{ route('pengajuan.index') }}" class="text-xs">
                    &larr; Kembali
                </x-button>
            </div>

            <div class="space-y-4 text-sm divide-y divide-[var(--border)]">
                <div class="pt-2 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Status Pengajuan</span>
                        <x-badge :status="$pengajuan->status" class="mt-1" />
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold uppercase text-navy-700 block">Tanggal Diajukan</span>
                        <span class="text-navy-900 ">{{ $pengajuan->tanggal_pengajuan->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Siswa Pemohon</span>
                    <span class="font-medium text-base text-navy-900 ">{{ $pengajuan->siswa->user->name ?? '-' }}</span>
                    <span class="text-xs text-navy-700 block">NIS: {{ $pengajuan->siswa->nis }} | Kelas: {{ $pengajuan->siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}</span>
                </div>

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Jenis Pengajuan</span>
                    <p class="font-medium text-navy-700  text-base mt-0.5">{{ $pengajuan->jenis_pengajuan }}</p>
                </div>

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Keterangan / Alasan Siswa</span>
                    <p class="text-ink-700  mt-1">{{ $pengajuan->keterangan }}</p>
                </div>

                @if($pengajuan->file_lampiran)
                    <div class="pt-3">
                        <span class="text-xs font-semibold uppercase text-navy-700 block mb-1">File Lampiran</span>
                        <a href="{{ asset('storage/' . $pengajuan->file_lampiran) }}" target="_blank" class="inline-flex items-center text-xs font-medium text-navy-600  hover:underline">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            Buka / Download File Lampiran
                        </a>
                    </div>
                @endif

                <div class="pt-3">
                    <span class="text-xs font-semibold uppercase text-navy-700 block">Informasi Pemrosesan</span>
                    @if($pengajuan->status !== 'menunggu')
                        <p class="text-ink-700  mt-1">
                            Diproses oleh: <span class="font-medium text-navy-900 ">{{ $pengajuan->guru->user->name ?? 'Admin / Pengajar' }}</span><br>
                            Tanggal diproses: {{ $pengajuan->tanggal_diproses ? $pengajuan->tanggal_diproses->format('d M Y') : '-' }}
                        </p>
                        @if($pengajuan->catatan_guru)
                            <div class="mt-2 p-3 rounded-lg bg-navy-100  border border-[var(--border)]">
                                <span class="text-xs font-semibold text-navy-700 block">Catatan Guru:</span>
                                <p class="text-sm italic text-navy-900 ">{{ $pengajuan->catatan_guru }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-xs text-amber-600  italic mt-1">Pengajuan masih menunggu peninjauan oleh guru/admin.</p>
                    @endif
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
