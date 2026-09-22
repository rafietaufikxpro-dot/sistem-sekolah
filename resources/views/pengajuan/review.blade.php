<x-app-layout>
    <x-slot name="header">
        Proses Persetujuan Pengajuan
    </x-slot>

    <x-card class="max-w-2xl mx-auto space-y-6">
        <div class="p-4 bg-navy-100  rounded-lg text-sm space-y-2">
            <div>
                <span class="text-xs font-semibold uppercase text-navy-700 block">Siswa Pemohon</span>
                <span class="font-medium text-base text-navy-900 ">{{ $pengajuan->siswa->user->name ?? '-' }}</span>
                <span class="text-xs text-navy-700 block">NIS: {{ $pengajuan->siswa->nis }} | Kelas: {{ $pengajuan->siswa->kelas->nama_kelas ?? '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase text-navy-700 block">Jenis Pengajuan</span>
                <span class="font-medium text-navy-700 ">{{ $pengajuan->jenis_pengajuan }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase text-navy-700 block">Keterangan Siswa</span>
                <p class="text-ink-700  mt-0.5">{{ $pengajuan->keterangan }}</p>
            </div>

            @if($pengajuan->file_lampiran)
                <div class="pt-2">
                    <a href="{{ asset('storage/' . $pengajuan->file_lampiran) }}" target="_blank" class="inline-flex items-center text-xs font-medium text-navy-600  hover:underline">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Lihat / Download File Lampiran
                    </a>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('pengajuan.process', $pengajuan->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Keputusan Persetujuan</label>
                <select name="status" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="disetujui" {{ old('status', $pengajuan->status) === 'disetujui' ? 'selected' : '' }}>Setujui Pengajuan</option>
                    <option value="ditolak" {{ old('status', $pengajuan->status) === 'ditolak' ? 'selected' : '' }}>Tolak Pengajuan</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Catatan / Alasan (Opsional)</label>
                <textarea name="catatan_guru" rows="3" placeholder="Tuliskan alasan atau pesan untuk siswa..." class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('catatan_guru', $pengajuan->catatan_guru) }}</textarea>
                @error('catatan_guru') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('pengajuan.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Simpan Keputusan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
